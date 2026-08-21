<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SugarConsumption;
use App\Models\PointHistory;
use App\Models\Student;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Beverage;
use App\Models\Challenge;
use App\Models\TpbQuestion;
use App\Models\TpbResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        } elseif ($user->role === 'guru') {
            return $this->guruDashboard();
        } else {
            return $this->siswaDashboard($user);
        }
    }

    private function siswaDashboard($user)
    {
        // 1. Ambil Total Gula Hari Ini
        $todaySugar = SugarConsumption::where('user_id', $user->id)
            ->whereDate('consumed_at', Carbon::today())
            ->sum('total_sugar_grams');

        // 2. Ambil Total Poin Gamifikasi Siswa
        $totalPoints = PointHistory::where('user_id', $user->id)
            ->sum('points_earned');

        // 3. Ambil Riwayat Konsumsi Hari Ini
        $todayConsumptions = SugarConsumption::where('user_id', $user->id)
            ->whereDate('consumed_at', Carbon::today())
            ->with('beverage.category')
            ->orderBy('consumed_at', 'desc')
            ->get();

        // 4. Siapkan Data untuk Chart.js (7 Hari Terakhir)
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');

            $dailySugar = SugarConsumption::where('user_id', $user->id)
                ->whereDate('consumed_at', $date)
                ->sum('total_sugar_grams');

            $chartData[] = (float) $dailySugar;
        }

        // 5. Informasi Mahasiswa / Antropometri
        $student = $user->student ? $user->student->load('school', 'schoolClass') : null;

        // 6. TPB Smart Warning System
        $warningLevel = 'aman';
        $tpbMessage = '';
        if ($todaySugar <= 15) {
            $warningLevel = 'aman';
            $tpbMessage = 'Pilihan sehatmu hari ini luar biasa! Membatasi asupan gula membantu menjaga berat badan tetap stabil dan berenergi sepanjang hari. (Attitude)';
        } elseif ($todaySugar <= 25) {
            $warningLevel = 'waspada';
            $tpbMessage = 'Hati-hati! Asupan gulamu hampir mendekati batas maksimal WHO. Ingat, teman-teman sebayamu di sekolah memilih air putih untuk menjaga konsentrasi! (Subjective Norms)';
        } else {
            $warningLevel = 'tinggi';
            $tpbMessage = 'Warning! Asupan gulamu hari ini sudah mencapai ' . number_format($todaySugar, 1) . 'g, melebihi rekomendasi 25g WHO. Ingat, kamu memiliki kontrol penuh atas kesehatan tubuhmu sendiri untuk menolak minuman manis berikutnya! (Perceived Behavioral Control)';
        }

        // 7. Badge/Gamifikasi
        $badgeName = 'Pemula Sehat 🥤';
        if ($totalPoints >= 150) {
            $badgeName = 'Pahlawan SmartSip 🏆';
        } elseif ($totalPoints >= 50) {
            $badgeName = 'Pejuang Anti Gula 🛡️';
        }

        return view('dashboard.siswa', compact(
            'todaySugar', 
            'totalPoints', 
            'todayConsumptions', 
            'chartLabels', 
            'chartData', 
            'student', 
            'warningLevel', 
            'tpbMessage', 
            'badgeName'
        ));
    }

    private function guruDashboard()
    {
        $teacher = Auth::user();
        $schoolId = $teacher->school_id;

        // Base query for students taught by this teacher
        $studentsQuery = Student::query();
        if ($schoolId) {
            $studentsQuery->where('school_id', $schoolId);
        }

        $studentIds = $studentsQuery->pluck('user_id');
        $totalStudents = count($studentIds);
        
        // Rata-rata asupan gula hari ini (hanya siswa sekolah guru)
        $avgSugarToday = SugarConsumption::whereIn('user_id', $studentIds)
            ->whereDate('consumed_at', Carbon::today())
            ->avg('total_sugar_grams') ?? 0;

        // Persentase siswa yang melebihi batas WHO (> 25g/hari) berdasarkan data 7 hari terakhir (mingguan)
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $overLimitUserIdsFromLogs = SugarConsumption::whereIn('user_id', $studentIds)
            ->whereBetween('consumed_at', [$startDate, $endDate])
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('SUM(total_sugar_grams) / 7 > 25')
            ->pluck('user_id')
            ->toArray();

        $teacherStudentDbIds = Student::whereIn('user_id', $studentIds)->pluck('id');
        $overLimitUserIdsFromFFQ = \App\Models\FFQResponse::whereIn('student_id', $teacherStudentDbIds)
            ->where('total_daily_sugar_grams', '>', 25)
            ->with('student')
            ->get()
            ->pluck('student.user_id')
            ->filter()
            ->toArray();

        $allOverLimitUserIds = array_unique(array_merge($overLimitUserIdsFromLogs, $overLimitUserIdsFromFFQ));
        $studentsOverLimitCount = count($allOverLimitUserIds);
        
        $percentOverLimit = $totalStudents > 0 ? ($studentsOverLimitCount / $totalStudents) * 100 : 0;

        // Rata-rata poin siswa
        $avgPoints = PointHistory::whereIn('user_id', $studentIds)
            ->groupBy('user_id')
            ->selectRaw('SUM(points_earned) as total')
            ->get()
            ->avg('total') ?? 0;

        // 2. Data Chart Tren 7 Hari Terakhir (Rata-rata Konsumsi Gula Siswa Sekolah Ini)
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');

            $dailyAvg = SugarConsumption::whereIn('user_id', $studentIds)
                ->whereDate('consumed_at', $date)
                ->avg('total_sugar_grams') ?? 0;

            $chartData[] = (float) $dailyAvg;
        }

        // 3. Rincian Kelas (Hanya kelas di sekolah guru ini)
        $classesQuery = SchoolClass::with('school');
        if ($schoolId) {
            $classesQuery->where('school_id', $schoolId);
        }
        $classes = $classesQuery->get()->map(function($class) {
            $classStudentIds = Student::where('class_id', $class->id)->pluck('user_id');
            $avgSugar = SugarConsumption::whereIn('user_id', $classStudentIds)
                ->whereDate('consumed_at', Carbon::today())
                ->avg('total_sugar_grams') ?? 0;
            $avgPoints = PointHistory::whereIn('user_id', $classStudentIds)
                ->groupBy('user_id')
                ->selectRaw('SUM(points_earned) as total')
                ->get()
                ->avg('total') ?? 0;
            
            return [
                'name' => $class->name,
                'school' => $class->school->name,
                'student_count' => count($classStudentIds),
                'avg_sugar_today' => $avgSugar,
                'avg_points' => $avgPoints,
            ];
        });

        // 4. Daftar Siswa (Hanya siswa di sekolah guru ini)
        $studentsListQuery = Student::with(['user.pointHistories', 'school', 'schoolClass']);
        if ($schoolId) {
            $studentsListQuery->where('school_id', $schoolId);
        }
        $studentsList = $studentsListQuery->get()->map(function($std) {
            $todaySugar = SugarConsumption::where('user_id', $std->user_id)
                ->whereDate('consumed_at', Carbon::today())
                ->sum('total_sugar_grams');
            
            $totalPoints = $std->user ? $std->user->pointHistories->sum('points_earned') : 0;
            
            // Kuesioner status
            $hasFilledQuestionnaire = TpbResponse::where('student_id', $std->id)->exists() ? 'Sudah Isi' : 'Belum';

            return [
                'nickname' => $std->nickname,
                'gender' => $std->gender === 'L' ? 'Laki-laki' : 'Perempuan',
                'school_name' => $std->school->name ?? '-',
                'class_name' => $std->schoolClass->name ?? '-',
                'bmi' => $std->bmi_score ?? '-',
                'today_sugar' => $todaySugar,
                'total_points' => $totalPoints,
                'survey_status' => $hasFilledQuestionnaire,
            ];
        });

        return view('dashboard.guru', compact(
            'totalStudents', 
            'avgSugarToday', 
            'percentOverLimit', 
            'avgPoints', 
            'chartLabels', 
            'chartData', 
            'classes', 
            'studentsList'
        ));
    }

    private function adminDashboard()
    {
        $stats = [
            'users' => \App\Models\User::count(),
            'students' => Student::count(),
            'schools' => School::count(),
            'classes' => SchoolClass::count(),
            'beverages' => Beverage::count(),
            'challenges' => Challenge::count(),
            'questions' => TpbQuestion::count(),
        ];

        // 1. Analytics Aggregates
        $totalStudents = $stats['students'];
        
        $avgSugarToday = SugarConsumption::whereDate('consumed_at', Carbon::today())
            ->avg('total_sugar_grams') ?? 0;

        // Persentase siswa yang melebihi batas WHO (> 25g/hari) berdasarkan data 7 hari terakhir (mingguan)
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $overLimitUserIdsFromLogs = SugarConsumption::whereBetween('consumed_at', [$startDate, $endDate])
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('SUM(total_sugar_grams) / 7 > 25')
            ->pluck('user_id')
            ->toArray();

        $overLimitUserIdsFromFFQ = \App\Models\FFQResponse::where('total_daily_sugar_grams', '>', 25)
            ->with('student')
            ->get()
            ->pluck('student.user_id')
            ->filter()
            ->toArray();

        $allOverLimitUserIds = array_unique(array_merge($overLimitUserIdsFromLogs, $overLimitUserIdsFromFFQ));
        $studentsOverLimitCount = count($allOverLimitUserIds);
        
        $percentOverLimit = $totalStudents > 0 ? ($studentsOverLimitCount / $totalStudents) * 100 : 0;

        $avgPoints = PointHistory::groupBy('user_id')
            ->selectRaw('SUM(points_earned) as total')
            ->get()
            ->avg('total') ?? 0;

        // 2. Data Chart Tren 7 Hari Terakhir
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');

            $dailyAvg = SugarConsumption::whereDate('consumed_at', $date)
                ->avg('total_sugar_grams') ?? 0;

            $chartData[] = round((float) $dailyAvg, 1);
        }

        // 3. Rincian Kelas
        $classes = SchoolClass::get()->map(function($class) {
            $studentIds = Student::where('class_id', $class->id)->pluck('user_id');
            $avgSugar = SugarConsumption::whereIn('user_id', $studentIds)
                ->whereDate('consumed_at', Carbon::today())
                ->avg('total_sugar_grams') ?? 0;
            $avgPoints = PointHistory::whereIn('user_id', $studentIds)
                ->groupBy('user_id')
                ->selectRaw('SUM(points_earned) as total')
                ->get()
                ->avg('total') ?? 0;
            
            return [
                'name' => $class->name,
                'school' => 'Master Kelas',
                'student_count' => count($studentIds),
                'avg_sugar_today' => round((float) $avgSugar, 1),
                'avg_points' => round((float) $avgPoints, 0),
            ];
        });

        // 4. Daftar Siswa Responden
        $studentsList = Student::with(['user.pointHistories', 'school', 'schoolClass'])->get()->map(function($std) {
            $todaySugar = SugarConsumption::where('user_id', $std->user_id)
                ->whereDate('consumed_at', Carbon::today())
                ->sum('total_sugar_grams');
            
            $totalPoints = $std->user ? $std->user->pointHistories->sum('points_earned') : 0;
            
            $hasFilledQuestionnaire = TpbResponse::where('student_id', $std->id)->exists() ? 'Sudah Isi' : 'Belum';

            return [
                'nickname' => $std->nickname,
                'gender' => $std->gender === 'L' ? 'Laki-laki' : 'Perempuan',
                'school_name' => $std->school ? $std->school->name : '-',
                'class_name' => $std->schoolClass ? $std->schoolClass->name : '-',
                'bmi' => $std->bmi_score ?? '-',
                'today_sugar' => round($todaySugar, 1),
                'total_points' => $totalPoints,
                'survey_status' => $hasFilledQuestionnaire,
            ];
        });

        $underLimitCount = max(0, $totalStudents - $studentsOverLimitCount);
        $distributionData = [$underLimitCount, $studentsOverLimitCount];

        // 5. Data Profil Psikologis TPB (Theory of Planned Behavior) 4 Konstruk
        $tpbConstructsKeys = ['attitude', 'subjective_norm', 'pbc', 'intention'];
        $tpbScores = [];
        foreach ($tpbConstructsKeys as $construct) {
            $avg = TpbResponse::whereHas('question', function($q) use ($construct) {
                $q->where('construct_type', $construct);
            })->avg('score');

            $tpbScores[$construct] = $avg ? round((float)$avg, 2) : 0;
        }

        $tpbRadarData = [
            $tpbScores['attitude'],
            $tpbScores['subjective_norm'],
            $tpbScores['pbc'],
            $tpbScores['intention'],
        ];

        return view('dashboard.admin', compact(
            'stats',
            'totalStudents',
            'avgSugarToday',
            'percentOverLimit',
            'avgPoints',
            'chartLabels',
            'chartData',
            'distributionData',
            'classes',
            'studentsList',
            'tpbScores',
            'tpbRadarData'
        ));
    }
}