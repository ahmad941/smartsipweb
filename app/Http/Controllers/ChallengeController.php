<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\PointHistory;
use App\Models\SugarConsumption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $challenges = Challenge::where('is_active', true)->get();

        $challengesStatus = $challenges->map(function($challenge) use ($user) {
            $isClaimed = false;
            $isCompleted = false;

            if ($challenge->title === 'Pejuang Air Putih') {
                $isClaimed = PointHistory::where('user_id', $user->id)
                    ->where('challenge_id', $challenge->id)
                    ->whereDate('created_at', Carbon::today())
                    ->exists();

                $todaySugar = SugarConsumption::where('user_id', $user->id)
                    ->whereDate('consumed_at', Carbon::today())
                    ->sum('total_sugar_grams');
                
                $isCompleted = ($todaySugar == 0);
            } elseif ($challenge->title === '3 Hari Tanpa Soda') {
                $isClaimed = PointHistory::where('user_id', $user->id)
                    ->where('challenge_id', $challenge->id)
                    ->exists();

                $hasSodaRecently = SugarConsumption::where('user_id', $user->id)
                    ->whereDate('consumed_at', '>=', Carbon::today()->subDays(2))
                    ->whereHas('beverage.category', function($query) {
                        $query->where('name', 'like', '%Soda%');
                    })
                    ->exists();

                $isCompleted = !$hasSodaRecently;
            }

            return [
                'challenge' => $challenge,
                'is_claimed' => $isClaimed,
                'is_completed' => $isCompleted,
            ];
        });

        return view('challenges.index', compact('challengesStatus'));
    }

    public function claim($id)
    {
        $user = Auth::user();
        $challenge = Challenge::findOrFail($id);

        if ($challenge->title === 'Pejuang Air Putih') {
            $alreadyClaimed = PointHistory::where('user_id', $user->id)
                ->where('challenge_id', $challenge->id)
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if ($alreadyClaimed) {
                return redirect()->back()->with('error', 'Kamu sudah mengklaim poin tantangan ini hari ini!');
            }

            $todaySugar = SugarConsumption::where('user_id', $user->id)
                ->whereDate('consumed_at', Carbon::today())
                ->sum('total_sugar_grams');

            if ($todaySugar > 0) {
                return redirect()->back()->with('error', 'Kamu belum memenuhi syarat! Asupan gulamu hari ini masih di atas 0g.');
            }
        } elseif ($challenge->title === '3 Hari Tanpa Soda') {
            $alreadyClaimed = PointHistory::where('user_id', $user->id)
                ->where('challenge_id', $challenge->id)
                ->exists();

            if ($alreadyClaimed) {
                return redirect()->back()->with('error', 'Kamu sudah mengklaim poin tantangan ini sebelumnya!');
            }

            $hasSodaRecently = SugarConsumption::where('user_id', $user->id)
                ->whereDate('consumed_at', '>=', Carbon::today()->subDays(2))
                ->whereHas('beverage.category', function($query) {
                    $query->where('name', 'like', '%Soda%');
                })
                ->exists();

            if ($hasSodaRecently) {
                return redirect()->back()->with('error', 'Kamu belum memenuhi syarat! Kamu mengonsumsi minuman bersoda dalam 3 hari terakhir.');
            }
        }

        PointHistory::create([
            'user_id' => $user->id,
            'challenge_id' => $challenge->id,
            'points_earned' => $challenge->reward_points,
            'description' => 'Klaim Misi: ' . $challenge->title,
        ]);

        return redirect()->back()->with('success', 'Selamat! Kamu berhasil mendapatkan ' . $challenge->reward_points . ' poin gamifikasi.');
    }
}
