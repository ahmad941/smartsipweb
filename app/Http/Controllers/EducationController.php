<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    private function getQuizzes()
    {
        return [
            1 => [
                'id' => 1,
                'question' => 'Berapa rekomendasi batas maksimal asupan gula harian untuk anak dan remaja menurut Organisasi Kesehatan Dunia (WHO)?',
                'options' => [
                    'A' => '10 gram (sekitar 2.5 sendok teh)',
                    'B' => '25 gram (sekitar 6 sendok teh)',
                    'C' => '50 gram (sekitar 12 sendok teh)',
                    'D' => '100 gram (sekitar 24 sendok teh)',
                ],
                'correct' => 'B',
                'reward' => 10,
                'explanation' => 'WHO merekomendasikan batas konsumsi gula bebas maksimal 25 gram per hari untuk remaja demi mengurangi risiko obesitas, kerusakan gigi, dan diabetes tipe 2 di usia muda.',
            ],
            2 => [
                'id' => 2,
                'question' => 'Segelas minuman brown sugar boba berukuran sedang rata-rata bisa mengandung gula sebanyak...',
                'options' => [
                    'A' => '5 - 10 gram',
                    'B' => '10 - 20 gram',
                    'C' => '20 - 30 gram',
                    'D' => '50 - 60 gram',
                ],
                'correct' => 'D',
                'reward' => 10,
                'explanation' => 'Segelas brown sugar boba berukuran medium umumnya mengandung sekitar 50 hingga 60 gram gula. Jumlah ini sudah melebihi dua kali lipat batas maksimal rekomendasi WHO!',
            ],
            3 => [
                'id' => 3,
                'question' => 'Mana di antara nama berikut yang merupakan nama lain dari gula tersembunyi yang sering tertulis di label kemasan produk?',
                'options' => [
                    'A' => 'High Fructose Corn Syrup / Maltodextrin',
                    'B' => 'Sodium Chloride / Salt',
                    'C' => 'Monosodium Glutamate',
                    'D' => 'Calcium Carbonate',
                ],
                'correct' => 'A',
                'reward' => 10,
                'explanation' => 'Gula tersembunyi sering disamarkan produsen dengan nama ilmiah di tabel komposisi seperti High Fructose Corn Syrup (HFCS), Maltodextrin, Dextrose, Sucrose, atau Maltose.',
            ]
        ];
    }

    public function index()
    {
        $user = Auth::user();
        
        $articles = Education::where('is_published', true)->get();

        $claimedQuizzes = PointHistory::where('user_id', $user->id)
            ->where('description', 'like', 'Kuis Edukasi #%')
            ->pluck('description')
            ->toArray();

        $quizzes = collect($this->getQuizzes())->map(function($quiz) use ($claimedQuizzes) {
            $descKey = 'Kuis Edukasi #' . $quiz['id'];
            $quiz['is_completed'] = in_array($descKey, $claimedQuizzes);
            return $quiz;
        });

        return view('education.index', compact('articles', 'quizzes'));
    }

    public function answer(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'quiz_id' => 'required|integer',
            'answer' => 'required|string|max:1',
        ]);

        $quizzes = $this->getQuizzes();
        if (!isset($quizzes[$validated['quiz_id']])) {
            return redirect()->back()->with('error', 'Kuis tidak ditemukan.');
        }

        $quiz = $quizzes[$validated['quiz_id']];
        $descKey = 'Kuis Edukasi #' . $quiz['id'];

        $alreadyClaimed = PointHistory::where('user_id', $user->id)
            ->where('description', $descKey)
            ->exists();

        if ($alreadyClaimed) {
            return redirect()->back()->with('error', 'Kamu sudah menyelesaikan kuis ini sebelumnya!');
        }

        if (strtoupper($validated['answer']) !== $quiz['correct']) {
            return redirect()->back()->with('quiz_feedback_error', [
                'quiz_id' => $quiz['id'],
                'message' => 'Jawabanmu salah! Coba lagi ya.',
                'explanation' => $quiz['explanation'],
            ]);
        }

        PointHistory::create([
            'user_id' => $user->id,
            'points_earned' => $quiz['reward'],
            'description' => $descKey,
        ]);

        return redirect()->back()->with('quiz_feedback_success', [
            'quiz_id' => $quiz['id'],
            'message' => 'Jawabanmu BENAR! Kamu mendapatkan +' . $quiz['reward'] . ' poin.',
            'explanation' => $quiz['explanation'],
        ]);
    }
}
