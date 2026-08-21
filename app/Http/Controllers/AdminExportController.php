<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SugarConsumption;
use App\Models\TpbResponse;
use App\Models\FFQResponse;
use App\Models\KnowledgeResponse;
use App\Models\UsabilityResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminExportController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => Student::count(),
            'ffq_count' => FFQResponse::count(),
            'tpb_count' => TpbResponse::count(),
            'knowledge_count' => KnowledgeResponse::count(),
            'usability_count' => UsabilityResponse::count(),
            'sugar_logs' => SugarConsumption::count(),
        ];

        return view('admin.exports.index', compact('stats'));
    }

    // 1. Ekspor Bagian A (Demografi & Antropometri)
    public function exportDemographics()
    {
        $students = Student::with(['user', 'school', 'schoolClass'])->get();

        $csvHeader = [
            'User_ID', 'Nama_Lengkap_User', 'Email', 'Nama_Lengkap_Siswa', 'Jenis_Kelamin',
            'Tanggal_Lahir', 'Umur_Tahun', 'Sekolah', 'Kelompok_Penelitian', 'Kelas',
            'Tinggi_cm', 'Berat_kg', 'BMI_Score', 'Body_Fat_Percentage_BIA',
            'Uang_Saku_per_Hari', 'Pendidikan_Ayah', 'Pendidikan_Ibu', 'Informed_Consent', 'Tanggal_Daftar'
        ];

        $csvData = [];
        $csvData[] = implode(',', $csvHeader);

        foreach ($students as $s) {
            $row = [
                $s->user_id,
                '"' . str_replace('"', '""', $s->user->name ?? '-') . '"',
                '"' . str_replace('"', '""', $s->user->email ?? '-') . '"',
                '"' . str_replace('"', '""', $s->nickname ?? '-') . '"',
                $s->gender === 'L' ? 'Laki-laki' : 'Perempuan',
                $s->date_of_birth ?? '-',
                $s->age ?? '-',
                '"' . str_replace('"', '""', $s->school->name ?? '-') . '"',
                $s->school->group_type ?? '-',
                '"' . str_replace('"', '""', $s->schoolClass->name ?? '-') . '"',
                $s->height_cm ?? '-',
                $s->weight_kg ?? '-',
                $s->bmi_score ?? '-',
                $s->body_fat_percentage ?? '-',
                '"' . str_replace('"', '""', $s->pocket_money ?? '-') . '"',
                '"' . str_replace('"', '""', $s->father_education ?? '-') . '"',
                '"' . str_replace('"', '""', $s->mother_education ?? '-') . '"',
                $s->informed_consent ? 'Ya' : 'Tidak',
                $s->created_at ? $s->created_at->format('Y-m-d H:i:s') : '-'
            ];
            $csvData[] = implode(',', $row);
        }

        $filename = 'SmartSip_Bagian_A_Demografi_' . date('Y-m-d_H-i') . '.csv';

        return Response::make(implode("\n", $csvData), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // 2. Ekspor Bagian B (FFQ 7 Hari)
    public function exportFfq()
    {
        $responses = FFQResponse::with(['student.user', 'student.school'])->get();

        $csvHeader = [
            'Response_ID', 'Student_ID', 'Nama_Lengkap', 'Sekolah', 'Fase',
            'Total_Sugar_Grams_per_Day', 'Kategori_Konsumsi', 'Detail_Items_JSON', 'Tanggal_Isi'
        ];

        $csvData = [];
        $csvData[] = implode(',', $csvHeader);

        foreach ($responses as $r) {
            $row = [
                $r->id,
                $r->student_id,
                '"' . str_replace('"', '""', $r->student->nickname ?? '-') . '"',
                '"' . str_replace('"', '""', $r->student->school->name ?? '-') . '"',
                $r->phase ?? 1,
                $r->total_daily_sugar_grams ?? 0,
                '"' . str_replace('"', '""', $r->category ?? '-') . '"',
                '"' . str_replace('"', '""', json_encode($r->items_data ?? [])) . '"',
                $r->answered_at ? $r->answered_at->format('Y-m-d H:i:s') : ($r->created_at ? $r->created_at->format('Y-m-d H:i:s') : '-')
            ];
            $csvData[] = implode(',', $row);
        }

        $filename = 'SmartSip_Bagian_B_FFQ7Hari_' . date('Y-m-d_H-i') . '.csv';

        return Response::make(implode("\n", $csvData), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // 3. Ekspor Bagian C (Skor TPB 23 Item)
    public function exportTpb()
    {
        $responses = TpbResponse::with(['student.user', 'student.school', 'question'])->get();

        $csvHeader = [
            'Response_ID', 'Student_ID', 'Nama_Lengkap', 'Sekolah', 'Question_ID',
            'Construct_Type', 'Question_Text', 'Likert_Score', 'Fase', 'Tanggal_Isi'
        ];

        $csvData = [];
        $csvData[] = implode(',', $csvHeader);

        foreach ($responses as $r) {
            $row = [
                $r->id,
                $r->student_id,
                '"' . str_replace('"', '""', $r->student->nickname ?? '-') . '"',
                '"' . str_replace('"', '""', $r->student->school->name ?? '-') . '"',
                $r->question_id,
                $r->question->construct_type ?? '-',
                '"' . str_replace('"', '""', $r->question->question_text ?? '-') . '"',
                $r->score,
                $r->phase ?? 1,
                $r->created_at ? $r->created_at->format('Y-m-d H:i:s') : '-'
            ];
            $csvData[] = implode(',', $row);
        }

        $filename = 'SmartSip_Bagian_C_TPB23Item_' . date('Y-m-d_H-i') . '.csv';

        return Response::make(implode("\n", $csvData), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // 4. Ekspor Bagian D (Pengetahuan Gula)
    public function exportKnowledge()
    {
        $responses = KnowledgeResponse::with(['student.user', 'student.school'])->get();

        $csvHeader = [
            'Response_ID', 'Student_ID', 'Nama_Lengkap', 'Sekolah', 'Fase',
            'Score_Total', 'Kategori_Pengetahuan', 'Detail_Answers_JSON', 'Tanggal_Isi'
        ];

        $csvData = [];
        $csvData[] = implode(',', $csvHeader);

        foreach ($responses as $r) {
            $row = [
                $r->id,
                $r->student_id,
                '"' . str_replace('"', '""', $r->student->nickname ?? '-') . '"',
                '"' . str_replace('"', '""', $r->student->school->name ?? '-') . '"',
                $r->phase ?? 1,
                $r->score ?? 0,
                '"' . str_replace('"', '""', $r->category ?? '-') . '"',
                '"' . str_replace('"', '""', json_encode($r->answers ?? [])) . '"',
                $r->answered_at ? $r->answered_at->format('Y-m-d H:i:s') : ($r->created_at ? $r->created_at->format('Y-m-d H:i:s') : '-')
            ];
            $csvData[] = implode(',', $row);
        }

        $filename = 'SmartSip_Bagian_D_Pengetahuan_' . date('Y-m-d_H-i') . '.csv';

        return Response::make(implode("\n", $csvData), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // 5. Ekspor Bagian E (Usability Web SUS)
    public function exportUsability()
    {
        $responses = UsabilityResponse::with(['student.user', 'student.school'])->get();

        $csvHeader = [
            'Response_ID', 'Student_ID', 'Nama_Lengkap', 'Sekolah',
            'Item_1_Mudah_Dipelajari', 'Item_2_Menu_Mudah_Dipahami', 'Item_3_Tampilan_Menarik',
            'Item_4_Informasi_Jelas', 'Item_5_Mandiri_Tanpa_Bantuan', 'Item_6_Fitur_Berjalan_Baik',
            'Item_7_Nyaman_Digunakan', 'Item_8_Ingin_Terus_Pakai', 'Item_9_Rekomendasi_Teman',
            'Item_10_Puas_Keseluruhan', 'SUS_Total_Score', 'Kategori_Usability', 'Tanggal_Isi'
        ];

        $csvData = [];
        $csvData[] = implode(',', $csvHeader);

        foreach ($responses as $r) {
            $scores = $r->scores ?? [];
            $row = [
                $r->id,
                $r->student_id,
                '"' . str_replace('"', '""', $r->student->nickname ?? '-') . '"',
                '"' . str_replace('"', '""', $r->student->school->name ?? '-') . '"',
                $scores[1] ?? (is_array($scores) && isset($scores['1']) ? $scores['1'] : '-'),
                $scores[2] ?? (is_array($scores) && isset($scores['2']) ? $scores['2'] : '-'),
                $scores[3] ?? (is_array($scores) && isset($scores['3']) ? $scores['3'] : '-'),
                $scores[4] ?? (is_array($scores) && isset($scores['4']) ? $scores['4'] : '-'),
                $scores[5] ?? (is_array($scores) && isset($scores['5']) ? $scores['5'] : '-'),
                $scores[6] ?? (is_array($scores) && isset($scores['6']) ? $scores['6'] : '-'),
                $scores[7] ?? (is_array($scores) && isset($scores['7']) ? $scores['7'] : '-'),
                $scores[8] ?? (is_array($scores) && isset($scores['8']) ? $scores['8'] : '-'),
                $scores[9] ?? (is_array($scores) && isset($scores['9']) ? $scores['9'] : '-'),
                $scores[10] ?? (is_array($scores) && isset($scores['10']) ? $scores['10'] : '-'),
                $r->total_score ?? 0,
                '"' . str_replace('"', '""', $r->category ?? '-') . '"',
                $r->answered_at ? $r->answered_at->format('Y-m-d H:i:s') : ($r->created_at ? $r->created_at->format('Y-m-d H:i:s') : '-')
            ];
            $csvData[] = implode(',', $row);
        }

        $filename = 'SmartSip_Bagian_E_Usability_SUS_' . date('Y-m-d_H-i') . '.csv';

        return Response::make(implode("\n", $csvData), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // 6. Ekspor Log Konsumsi Gula Harian
    public function exportSugarLogs()
    {
        $logs = SugarConsumption::with(['user.student.school', 'beverage'])->get();

        $csvHeader = [
            'Log_ID', 'User_ID', 'Nama_User', 'Nama_Lengkap_Siswa', 'Sekolah',
            'Nama_Minuman', 'Volume_ml', 'Total_Gula_Gram', 'Tanggal_Waktu_Konsumsi'
        ];

        $csvData = [];
        $csvData[] = implode(',', $csvHeader);

        foreach ($logs as $l) {
            $row = [
                $l->id,
                $l->user_id,
                '"' . str_replace('"', '""', $l->user->name ?? '-') . '"',
                '"' . str_replace('"', '""', $l->user->student->nickname ?? '-') . '"',
                '"' . str_replace('"', '""', $l->user->student->school->name ?? '-') . '"',
                '"' . str_replace('"', '""', $l->beverage->name ?? '-') . '"',
                $l->volume_ml ?? $l->portion_ml ?? 0,
                $l->total_sugar_grams ?? 0,
                $l->consumed_at ? \Carbon\Carbon::parse($l->consumed_at)->format('Y-m-d H:i:s') : '-'
            ];
            $csvData[] = implode(',', $row);
        }

        $filename = 'SmartSip_Log_Konsumsi_Gula_Harian_' . date('Y-m-d_H-i') . '.csv';

        return Response::make(implode("\n", $csvData), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // 7. Ekspor Perhitungan Final Kuesioner & Statistik Deskriptif (+ Rumus Metodologi)
    public function exportFinalStatistics(Request $request)
    {
        $selectedPhase = $request->query('phase'); // optional filter: T0, T1, T2, or null for all

        $students = Student::with(['user', 'school', 'schoolClass', 'tpbResponses.question', 'ffqResponses', 'knowledgeResponses', 'usabilityResponses'])->get();

        $phasesToProcess = in_array($selectedPhase, ['T0', 'T1', 'T2']) ? [$selectedPhase] : ['T0', 'T1', 'T2'];

        $respondentRows = [];
        $bmiList = [];
        $ffqSugarList = [];
        $knowledgeScoreList = [];
        $attitudeList = [];
        $subjectiveNormList = [];
        $pbcList = [];
        $intentionList = [];
        $susScoreList = [];

        $bmiCatFreq = ['Kurang' => 0, 'Normal' => 0, 'Berisiko' => 0, 'Obesitas I' => 0, 'Obesitas II' => 0];
        $ffqCatFreq = ['Baik' => 0, 'Sedang' => 0, 'Tinggi' => 0];
        $knowCatFreq = ['Baik' => 0, 'Cukup' => 0, 'Kurang' => 0];
        $susCatFreq = ['Sangat Baik' => 0, 'Baik' => 0, 'Cukup' => 0, 'Kurang' => 0];

        foreach ($students as $s) {
            // Kalkulasi BMI
            $heightM = $s->height_cm ? ($s->height_cm / 100) : 0;
            $bmi = ($heightM > 0 && $s->weight_kg) ? round($s->weight_kg / ($heightM * $heightM), 2) : ($s->bmi_score ?? null);
            
            $bmiCategory = '-';
            if ($bmi !== null) {
                if ($bmi < 18.5) $bmiCategory = 'Kurang';
                elseif ($bmi <= 22.9) $bmiCategory = 'Normal';
                elseif ($bmi <= 24.9) $bmiCategory = 'Berisiko';
                elseif ($bmi <= 29.9) $bmiCategory = 'Obesitas I';
                else $bmiCategory = 'Obesitas II';

                if (isset($bmiCatFreq[$bmiCategory])) {
                    $bmiCatFreq[$bmiCategory]++;
                }
                $bmiList[] = $bmi;
            }

            $usabilityResp = $s->usabilityResponses->first();
            $susScore = $usabilityResp->total_score ?? null;
            $susCat = $usabilityResp->category ?? '-';
            if ($susScore !== null) {
                $susScoreList[] = $susScore;
                if (isset($susCatFreq[$susCat])) {
                    $susCatFreq[$susCat]++;
                }
            }

            foreach ($phasesToProcess as $phase) {
                $ffqResp = $s->ffqResponses->where('phase', $phase)->first();
                $knowResp = $s->knowledgeResponses->where('phase', $phase)->first();
                $tpbResps = $s->tpbResponses->where('phase', $phase);

                if (!$ffqResp && !$knowResp && $tpbResps->isEmpty()) {
                    continue;
                }

                $ffqSugar = $ffqResp ? $ffqResp->total_daily_sugar_grams : null;
                $ffqCat = $ffqResp ? $ffqResp->category : '-';
                if ($ffqSugar !== null) {
                    $ffqSugarList[] = $ffqSugar;
                    if (isset($ffqCatFreq[$ffqCat])) {
                        $ffqCatFreq[$ffqCat]++;
                    }
                }

                $knowScore = $knowResp ? $knowResp->score : null;
                $knowCat = $knowResp ? $knowResp->category : '-';
                if ($knowScore !== null) {
                    $knowledgeScoreList[] = $knowScore;
                    if (isset($knowCatFreq[$knowCat])) {
                        $knowCatFreq[$knowCat]++;
                    }
                }

                // Breakdown TPB Scores per Construct
                $attitudeScores = [];
                $normScores = [];
                $pbcScores = [];
                $intentionScores = [];

                foreach ($tpbResps as $tr) {
                    $construct = $tr->question->construct_type ?? '';
                    if ($construct === 'attitude') $attitudeScores[] = $tr->score;
                    elseif ($construct === 'subjective_norm') $normScores[] = $tr->score;
                    elseif ($construct === 'pbc') $pbcScores[] = $tr->score;
                    elseif ($construct === 'intention') $intentionScores[] = $tr->score;
                }

                $attMean = count($attitudeScores) > 0 ? round(array_sum($attitudeScores) / count($attitudeScores), 2) : null;
                $normMean = count($normScores) > 0 ? round(array_sum($normScores) / count($normScores), 2) : null;
                $pbcMean = count($pbcScores) > 0 ? round(array_sum($pbcScores) / count($pbcScores), 2) : null;
                $intMean = count($intentionScores) > 0 ? round(array_sum($intentionScores) / count($intentionScores), 2) : null;

                if ($attMean !== null) $attitudeList[] = $attMean;
                if ($normMean !== null) $subjectiveNormList[] = $normMean;
                if ($pbcMean !== null) $pbcList[] = $pbcMean;
                if ($intMean !== null) $intentionList[] = $intMean;

                $respondentRows[] = [
                    $s->user_id,
                    $s->id,
                    '"' . str_replace('"', '""', $s->user->name ?? '-') . '"',
                    '"' . str_replace('"', '""', $s->nickname ?? '-') . '"',
                    '"' . str_replace('"', '""', $s->school->name ?? '-') . '"',
                    $s->school->group_type ?? '-',
                    '"' . str_replace('"', '""', $s->schoolClass->name ?? '-') . '"',
                    $s->gender === 'L' ? 'Laki-laki' : 'Perempuan',
                    $s->age ?? '-',
                    $s->height_cm ?? '-',
                    $s->weight_kg ?? '-',
                    $bmi !== null ? $bmi : '-',
                    $bmiCategory,
                    $phase,
                    $ffqSugar !== null ? $ffqSugar : '-',
                    '"' . str_replace('"', '""', $ffqCat) . '"',
                    $knowScore !== null ? $knowScore : '-',
                    '"' . str_replace('"', '""', $knowCat) . '"',
                    $attMean !== null ? $attMean : '-',
                    $normMean !== null ? $normMean : '-',
                    $pbcMean !== null ? $pbcMean : '-',
                    $intMean !== null ? $intMean : '-',
                    $susScore !== null ? $susScore : '-',
                    '"' . str_replace('"', '""', $susCat) . '"',
                    $s->updated_at ? $s->updated_at->format('Y-m-d H:i:s') : '-'
                ];
            }
        }

        $csvLines = [];

        // 1. DOKUMENTASI METODOLOGI & RUMUS PERHITUNGAN
        $csvLines[] = '========================================================================================================================';
        $csvLines[] = 'DOKUMENTASI METODOLOGI, RUMUS PERHITUNGAN FINAL, DAN STANDAR ACUAN KUESIONER SMARTSIP WEB';
        $csvLines[] = '========================================================================================================================';
        $csvLines[] = '1. INDEKS MASSA TUBUH (IMT / BMI)';
        $csvLines[] = '   - Rumus: IMT = Berat_Badan (kg) / [ Tinggi_Badan (cm) / 100 ]^2';
        $csvLines[] = '   - Kategori (Permenkes No 2/2020 & WHO): Kurang (<18.5) | Normal (18.5 - 22.9) | Berisiko (23.0 - 24.9) | Obesitas I (25.0 - 29.9) | Obesitas II (>= 30.0)';
        $csvLines[] = '';
        $csvLines[] = '2. ASUPAN GULA HARIAN (SEMI-QUANTITATIVE FFQ 7 HARI)';
        $csvLines[] = '   - Rumus: Total Gula (g/hari) = SUM [ Porsi_ml * (Gula_100ml / 100) * Faktor_Frekuensi_Harian ]';
        $csvLines[] = '   - Faktor Frekuensi Harian (f): 0 (0) | 1-2x/mgg (0.214) | 3-4x/mgg (0.500) | 5-6x/mgg (0.786) | Setiap Hari (1.000)';
        $csvLines[] = '   - Kategori Asupan (Permenkes No 30/2013 & WHO 2015): Baik (< 25 g/hari) | Sedang (25 - 50 g/hari) | Tinggi (> 50 g/hari)';
        $csvLines[] = '';
        $csvLines[] = '3. PENGETAHUAN KONSUMSI GULA (KNOWLEDGE SCORE)';
        $csvLines[] = '   - Rumus: Skor Pengetahuan = SUM [ Jawaban_Benar (1 Poin per Soal) ] (Maksimal 10 Poin)';
        $csvLines[] = '   - Kategori Pengetahuan (Arikunto, 2010): Baik (8 - 10 / 80-100%) | Cukup (6 - 7 / 60-70%) | Kurang (< 6 / <60%)';
        $csvLines[] = '';
        $csvLines[] = '4. THEORY OF PLANNED BEHAVIOR (TPB - 23 ITEM LIKERT)';
        $csvLines[] = '   - Rumus: Skor Konstruk = Rata-rata Skala Likert (1=Sangat Tidak Setuju s/d 5=Sangat Setuju) per Domain';
        $csvLines[] = '   - Domain TPB: Attitude (6 Item) | Subjective Norm (6 Item) | Perceived Behavioral Control (6 Item) | Intention (5 Item)';
        $csvLines[] = '';
        $csvLines[] = '5. SYSTEM USABILITY SCALE (SUS EVALUASI WEBSITE)';
        $csvLines[] = '   - Rumus: Total Skor SUS = SUM [ Skor_Item_1 s/d Skor_Item_10 ] (Maksimal 50 Poin)';
        $csvLines[] = '   - Kategori Usability (Brooke, 1996): Sangat Baik (41 - 50) | Baik (31 - 40) | Cukup (21 - 30) | Kurang (< 21)';
        $csvLines[] = '';
        $csvLines[] = '6. RUMUS STATISTIK DESKRIPTIF';
        $csvLines[] = '   - Rata-rata (Mean): x_bar = SUM(x) / N';
        $csvLines[] = '   - Simpangan Baku (Std Dev): s = SQRT( SUM( (x - x_bar)^2 ) / (N - 1) )';
        $csvLines[] = '   - Persentase Kategorikal (%): Persentase = ( Jumlah_Frekuensi_Kategori / Total_N ) * 100%';
        $csvLines[] = '';

        // 2. RINGKASAN STATISTIK DESKRIPTIF
        $csvLines[] = '========================================================================================================================';
        $csvLines[] = 'RINGKASAN STATISTIK DESKRIPTIF AGGREGAT (VARIABEL NUMERIK)';
        $csvLines[] = '========================================================================================================================';
        $csvLines[] = 'Indikator_Variabel,Jumlah_N,Rata_Rata_Mean,Simpangan_Baku_StdDev,Nilai_Minimum_Min,Nilai_Maksimum_Max';

        $metrics = [
            'Indeks Massa Tubuh (IMT)' => $bmiList,
            'FFQ Asupan Gula Harian (g/hari)' => $ffqSugarList,
            'Skor Pengetahuan Gula (0-10)' => $knowledgeScoreList,
            'TPB - Attitude (Sikap)' => $attitudeList,
            'TPB - Subjective Norm (Norma Subjektif)' => $subjectiveNormList,
            'TPB - Perceived Behavioral Control (PBC)' => $pbcList,
            'TPB - Behavioral Intention (Niat)' => $intentionList,
            'Evaluasi Usability Website (SUS Score 10-50)' => $susScoreList,
        ];

        foreach ($metrics as $label => $values) {
            $count = count($values);
            if ($count > 0) {
                $mean = round(array_sum($values) / $count, 2);
                $min = min($values);
                $max = max($values);
                
                $variance = 0;
                if ($count > 1) {
                    foreach ($values as $v) {
                        $variance += pow($v - $mean, 2);
                    }
                    $stdDev = round(sqrt($variance / ($count - 1)), 2);
                } else {
                    $stdDev = 0;
                }
            } else {
                $mean = '-';
                $stdDev = '-';
                $min = '-';
                $max = '-';
            }
            $csvLines[] = '"' . $label . '",' . $count . ',' . $mean . ',' . $stdDev . ',' . $min . ',' . $max;
        }

        $csvLines[] = '';
        $csvLines[] = '========================================================================================================================';
        $csvLines[] = 'RINGKASAN DISTRIBUSI FREKUENSI KATEGORI (VARIABEL KATEGORIKAL)';
        $csvLines[] = '========================================================================================================================';
        $csvLines[] = 'Kelompok_Kategori,Sub_Kategori,Jumlah_Frekuensi_N,Persentase_%';

        $totalBmiN = count($bmiList);
        foreach ($bmiCatFreq as $catKey => $freq) {
            $pct = $totalBmiN > 0 ? round(($freq / $totalBmiN) * 100, 2) . '%' : '0%';
            $csvLines[] = '"Status IMT","' . $catKey . '",' . $freq . ',"' . $pct . '"';
        }

        $totalFfqN = count($ffqSugarList);
        foreach ($ffqCatFreq as $catKey => $freq) {
            $pct = $totalFfqN > 0 ? round(($freq / $totalFfqN) * 100, 2) . '%' : '0%';
            $csvLines[] = '"FFQ Asupan Gula","' . $catKey . '",' . $freq . ',"' . $pct . '"';
        }

        $totalKnowN = count($knowledgeScoreList);
        foreach ($knowCatFreq as $catKey => $freq) {
            $pct = $totalKnowN > 0 ? round(($freq / $totalKnowN) * 100, 2) . '%' : '0%';
            $csvLines[] = '"Pengetahuan Gula","' . $catKey . '",' . $freq . ',"' . $pct . '"';
        }

        $totalSusN = count($susScoreList);
        foreach ($susCatFreq as $catKey => $freq) {
            $pct = $totalSusN > 0 ? round(($freq / $totalSusN) * 100, 2) . '%' : '0%';
            $csvLines[] = '"Usability SUS","' . $catKey . '",' . $freq . ',"' . $pct . '"';
        }

        // 3. TABEL DATA DETAIL PER RESPONDEN
        $csvLines[] = '';
        $csvLines[] = '========================================================================================================================';
        $csvLines[] = 'DATA HASIL PERHITUNGAN FINAL PER RESPONDEN';
        $csvLines[] = '========================================================================================================================';

        $headers = [
            'User_ID', 'Student_ID', 'Nama_User', 'Nama_Siswa', 'Sekolah', 'Kelompok_Penelitian',
            'Kelas', 'Jenis_Kelamin', 'Usia_Tahun', 'Tinggi_cm', 'Berat_kg', 'BMI_Score', 'BMI_Category',
            'Fase_Kuesioner', 'FFQ_Total_Gula_g_hari', 'FFQ_Category', 'Knowledge_Score', 'Knowledge_Category',
            'TPB_Attitude_Mean', 'TPB_SubjectiveNorm_Mean', 'TPB_PBC_Mean', 'TPB_Intention_Mean',
            'SUS_Total_Score', 'SUS_Category', 'Tanggal_Update'
        ];

        $csvLines[] = implode(',', $headers);

        foreach ($respondentRows as $row) {
            $csvLines[] = implode(',', $row);
        }

        $phaseSuffix = $selectedPhase ? '_' . $selectedPhase : '_SemuaFase';
        $filename = 'SmartSip_Hasil_Perhitungan_Final_Statistik' . $phaseSuffix . '_' . date('Y-m-d_H-i') . '.csv';

        return Response::make(implode("\n", $csvLines), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
