<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        // Peringkat Global
        $globalUsers = User::where('role', 'siswa')
            ->has('student')
            ->withSum('pointHistories as total_points', 'points_earned')
            ->with(['student.school', 'student.schoolClass'])
            ->get()
            ->sortByDesc('total_points')
            ->values();

        // Cari ranking global user aktif
        $activeUserGlobalRank = $globalUsers->search(function($u) use ($user) {
            return $u->id === $user->id;
        });
        $activeUserGlobalRank = $activeUserGlobalRank !== false ? $activeUserGlobalRank + 1 : '-';

        // Peringkat Kelas
        $classUsers = collect();
        $activeUserClassRank = '-';
        if ($student) {
            $classUsers = User::where('role', 'siswa')
                ->whereHas('student', function($q) use ($student) {
                    $q->where('class_id', $student->class_id);
                })
                ->withSum('pointHistories as total_points', 'points_earned')
                ->with(['student.school', 'student.schoolClass'])
                ->get()
                ->sortByDesc('total_points')
                ->values();

            $activeUserClassRank = $classUsers->search(function($u) use ($user) {
                return $u->id === $user->id;
            });
            $activeUserClassRank = $activeUserClassRank !== false ? $activeUserClassRank + 1 : '-';
        }

        return view('leaderboard.index', compact(
            'globalUsers', 
            'classUsers', 
            'activeUserGlobalRank', 
            'activeUserClassRank',
            'student'
        ));
    }
}
