<?php

namespace App\Http\Controllers;

use App\Models\FFQResponse;
use App\Models\KnowledgeQuestion;
use App\Models\KnowledgeResponse;
use App\Models\PointHistory;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\TpbQuestion;
use App\Models\TpbResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PublicSurveyController extends Controller
{
    public function index()
    {
        $schools = School::all();
        $classes = SchoolClass::all();
        $knowledgeQuestions = KnowledgeQuestion::where('is_active', true)->get();
        $tpbQuestions = TpbQuestion::where('is_active', true)->get();
        $ffqBeverages = SurveyController::getFFQBeverageMaster();

        return view('public-survey.index', compact('schools', 'classes', 'knowledgeQuestions', 'tpbQuestions', 'ffqBeverages'));
    }

    public function store(Request $request)
    {
        // 1. Ambil soal untuk validasi dinamis
        $knowledgeQuestions = KnowledgeQuestion::where('is_active', true)->get();
        $tpbQuestions = TpbQuestion::where('is_active', true)->get();
        $ffqBeverages = SurveyController::getFFQBeverageMaster();

        // 2. Buat aturan validasi
        $rules = [
            'email' => 'required|email|max:255',
            'school_id' => 'required|exists:schools,id',
            'class_id' => 'required|exists:school_classes,id',
            'nickname' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date|before:today',
            'height_cm' => 'required|numeric|min:50|max:250',
            'weight_kg' => 'required|numeric|min:10|max:200',
            'body_fat_percentage' => 'nullable|numeric|min:1|max:80',
            'pocket_money' => 'required|string',
            'father_education' => 'required|string',
            'mother_education' => 'required|string',
            'informed_consent' => 'required|accepted',
        ];

        // Validasi Jawaban Pengetahuan Gula
        foreach ($knowledgeQuestions as $kq) {
            $rules["knowledge_answers.{$kq->id}"] = 'required|in:A,B,C,D';
        }

        // Validasi Jawaban TPB
        foreach ($tpbQuestions as $tq) {
            $rules["tpb_answers.{$tq->id}"] = 'required|integer|min:1|max:5';
        }

        // Validasi Jawaban FFQ
        foreach ($ffqBeverages as $idx => $b) {
            $rules["ffq_freq.{$idx}"] = 'required|in:0,1,2,3,4';
            $rules["ffq_portion.{$idx}"] = 'required|in:250,350,450';
        }

        $messages = [
            'informed_consent.accepted' => 'Anda wajib menyetujui lembar persetujuan (informed consent) untuk berpartisipasi dalam riset ini.',
            'knowledge_answers.*.required' => 'Semua soal kuesioner pengetahuan wajib dijawab.',
            'tpb_answers.*.required' => 'Semua soal kuesioner TPB wajib dijawab.',
            'ffq_freq.*.required' => 'Frekuensi konsumsi semua minuman pada survei FFQ wajib dipilih.',
            'ffq_portion.*.required' => 'Porsi konsumsi semua minuman pada survei FFQ wajib dipilih.',
        ];

        $validated = $request->validate($rules, $messages);

        $email = strtolower(trim($validated['email']));

        // 3. Pengecekan Duplikasi: Apakah email ini sudah pernah membuat student & mengisi kuesioner T0?
        $user = User::where('email', $email)->first();

        if ($user && $user->student) {
            $existingStudent = $user->student;
            $hasFilled = FFQResponse::where('student_id', $existingStudent->id)->where('phase', 'T0')->exists()
                || TpbResponse::where('student_id', $existingStudent->id)->where('phase', 'T0')->exists()
                || KnowledgeResponse::where('student_id', $existingStudent->id)->where('phase', 'T0')->exists();

            if ($hasFilled) {
                // Loginkan user ke session browser agar dapat mengakses dashboard jika diinginkan
                Auth::login($user, true);

                return redirect()->route('public.survey.success', $existingStudent->id)
                    ->with('info', 'Email ini (' . $email . ') sudah pernah digunakan untuk mengisi kuesioner. Terima kasih atas partisipasi Anda!');
            }

            // Perbarui data antropometri jika sebelumnya ada data yang berubah
            $heightM = $validated['height_cm'] / 100;
            $bmiScore = $validated['weight_kg'] / ($heightM * $heightM);
            $existingStudent->update([
                'school_id' => $validated['school_id'],
                'class_id' => $validated['class_id'],
                'nickname' => $validated['nickname'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'height_cm' => $validated['height_cm'],
                'weight_kg' => $validated['weight_kg'],
                'bmi_score' => round($bmiScore, 2),
                'body_fat_percentage' => $validated['body_fat_percentage'] ?? null,
                'pocket_money' => $validated['pocket_money'],
                'father_education' => $validated['father_education'],
                'mother_education' => $validated['mother_education'],
                'informed_consent' => true,
            ]);

            $student = $existingStudent;
        } else {

            if (!$user) {
                $user = User::create([
                    'name' => $validated['nickname'],
                    'email' => $email,
                    'role' => 'siswa',
                    'password' => Hash::make(Str::random(32)),
                ]);
            }

            $heightM = $validated['height_cm'] / 100;
            $bmiScore = $validated['weight_kg'] / ($heightM * $heightM);

            $student = Student::create([
                'user_id' => $user->id,
                'school_id' => $validated['school_id'],
                'class_id' => $validated['class_id'],
                'nickname' => $validated['nickname'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'height_cm' => $validated['height_cm'],
                'weight_kg' => $validated['weight_kg'],
                'bmi_score' => round($bmiScore, 2),
                'body_fat_percentage' => $validated['body_fat_percentage'] ?? null,
                'pocket_money' => $validated['pocket_money'],
                'father_education' => $validated['father_education'],
                'mother_education' => $validated['mother_education'],
                'informed_consent' => true,
            ]);
        }

        $phase = 'T0';

        // 4. Simpan Kuesioner Pengetahuan Gula
        $scoreKnowledge = 0;
        $userKnowledgeAnswers = [];
        foreach ($knowledgeQuestions as $kq) {
            $ans = $validated['knowledge_answers'][$kq->id];
            $userKnowledgeAnswers[$kq->id] = $ans;
            if ($ans === $kq->correct_option) {
                $scoreKnowledge++;
            }
        }
        $categoryKnowledge = 'Kurang';
        if ($scoreKnowledge >= 8) {
            $categoryKnowledge = 'Baik';
        } elseif ($scoreKnowledge >= 6) {
            $categoryKnowledge = 'Cukup';
        }

        KnowledgeResponse::create([
            'student_id' => $student->id,
            'phase' => $phase,
            'score' => $scoreKnowledge,
            'category' => $categoryKnowledge,
            'answers' => $userKnowledgeAnswers,
            'answered_at' => now(),
        ]);

        // 5. Simpan Kuesioner TPB
        foreach ($tpbQuestions as $tq) {
            $scoreTpb = (int) $validated['tpb_answers'][$tq->id];
            TpbResponse::create([
                'student_id' => $student->id,
                'question_id' => $tq->id,
                'phase' => $phase,
                'score' => $scoreTpb,
                'answered_at' => now(),
            ]);
        }

        // 6. Simpan Survei FFQ
        $totalDailySugar = 0;
        $itemsData = [];
        $freqFactors = [
            0 => 0,
            1 => 1.5 / 7,
            2 => 3.5 / 7,
            3 => 5.5 / 7,
            4 => 1.0,
        ];

        foreach ($ffqBeverages as $idx => $b) {
            $freqCode = (int) $validated['ffq_freq'][$idx];
            $portionMl = (int) $validated['ffq_portion'][$idx];
            $factor = $freqFactors[$freqCode];

            $gramsPerServing = $portionMl * ($b['sugar_100ml'] / 100);
            $dailySugarFromThisItem = $gramsPerServing * $factor;
            $totalDailySugar += $dailySugarFromThisItem;

            $itemsData[] = [
                'name' => $b['name'],
                'sugar_100ml' => $b['sugar_100ml'],
                'freq_code' => $freqCode,
                'portion_ml' => $portionMl,
                'daily_sugar_grams' => round($dailySugarFromThisItem, 2),
            ];
        }

        $totalDailySugar = round($totalDailySugar, 2);
        $categoryFfq = 'Baik';
        if ($totalDailySugar > 50) {
            $categoryFfq = 'Tinggi';
        } elseif ($totalDailySugar >= 25) {
            $categoryFfq = 'Sedang';
        }

        FFQResponse::create([
            'student_id' => $student->id,
            'phase' => $phase,
            'items_data' => $itemsData,
            'total_daily_sugar_grams' => $totalDailySugar,
            'category' => $categoryFfq,
            'answered_at' => now(),
        ]);

        // 7. Berikan Gamifikasi Poin (+60 poin total untuk 3 kuesioner)
        PointHistory::create([
            'user_id' => $user->id,
            'points_earned' => 60,
            'description' => 'Menyelesaikan Kuesioner Awal Siswa (Pengetahuan, TPB, & FFQ Fase T0)',
        ]);

        // 8. Loginkan user otomatis di browser
        Auth::login($user, true);

        return redirect()->route('public.survey.success', $student->id)
            ->with('success', 'Selamat! Kuesioner awal berhasil disimpan dan akun SmartSip Anda telah aktif (+60 Poin Gamifikasi).');
    }

    public function success($student_id)
    {
        $student = Student::with(['user', 'school', 'schoolClass'])->findOrFail($student_id);

        if (Auth::check() && Auth::user()->student && Auth::user()->student->id != $student->id && Auth::user()->role !== 'admin') {
            return redirect()->route('public.survey.success', Auth::user()->student->id);
        }

        $knowledgeResponse = KnowledgeResponse::where('student_id', $student->id)->where('phase', 'T0')->latest()->first();
        $ffqResponse = FFQResponse::where('student_id', $student->id)->where('phase', 'T0')->latest()->first();
        $tpbResponsesCount = TpbResponse::where('student_id', $student->id)->where('phase', 'T0')->count();

        return view('public-survey.success', compact('student', 'knowledgeResponse', 'ffqResponse', 'tpbResponsesCount'));
    }

}
