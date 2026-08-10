<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SugarConsumption;
use App\Models\TpbResponse;
use App\Models\FfqResponse;
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
            'ffq_count' => FfqResponse::count(),
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
            'User_ID', 'Nama_Lengkap', 'Email', 'Nickname_Responden', 'Jenis_Kelamin',
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
        $responses = FfqResponse::with(['student.user', 'student.school'])->get();

        $csvHeader = [
            'Response_ID', 'Student_ID', 'Nickname', 'Sekolah', 'Fase',
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
            'Response_ID', 'Student_ID', 'Nickname', 'Sekolah', 'Question_ID',
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
            'Response_ID', 'Student_ID', 'Nickname', 'Sekolah', 'Fase',
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
            'Response_ID', 'Student_ID', 'Nickname', 'Sekolah',
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
            'Log_ID', 'User_ID', 'Nama_Responden', 'Nickname', 'Sekolah',
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
                $l->portion_ml ?? 0,
                $l->total_sugar_grams ?? 0,
                $l->consumed_at ? $l->consumed_at->format('Y-m-d H:i:s') : '-'
            ];
            $csvData[] = implode(',', $row);
        }

        $filename = 'SmartSip_Log_Konsumsi_Gula_Harian_' . date('Y-m-d_H-i') . '.csv';

        return Response::make(implode("\n", $csvData), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
