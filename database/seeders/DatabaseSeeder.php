<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Challenge;
use App\Models\BeverageCategory;
use App\Models\Beverage;
use App\Models\Setting;
use App\Models\TpbQuestion;
use App\Models\Education;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Pengaturan Sistem (Settings)
        Setting::upsert([
            ['key' => 'app_name', 'value' => 'SmartSip Web'],
            ['key' => 'footer_text', 'value' => '© 2026 Tim Peneliti Hibah Dikti - Theory of Planned Behavior'],
        ], ['key'], ['value']);

        // 2. Membuat Master Data Sekolah & Kelas (Metodologi Riset)
        School::firstOrCreate(
            ['name' => 'SMAN 1 Intervensi'],
            ['group_type' => 'intervensi']
        );

        School::firstOrCreate(
            ['name' => 'SMAN 2 Kontrol'],
            ['group_type' => 'kontrol']
        );

        // Master Data Kelas Mandiri
        $masterClasses = ['KELAS VII', 'KELAS VIII', 'KELAS IX', 'X-IPA 1', 'X-IPA 2', 'XI-IPA 1', 'XII-IPA 1'];
        foreach ($masterClasses as $className) {
            SchoolClass::firstOrCreate(['name' => $className]);
        }

        // 3. Membuat Master Data Minuman (Sugar Tracker - 20 Item Baku)
        $beverageCategoriesData = [
            'Teh & Olahan Teh' => [
                ['name' => 'Teh manis kemasan', 'sugar_per_100ml' => 9.8],
                ['name' => 'Teh tarik', 'sugar_per_100ml' => 11.2],
                ['name' => 'Thai tea', 'sugar_per_100ml' => 13.5],
                ['name' => 'Matcha latte', 'sugar_per_100ml' => 12.0],
            ],
            'Kopi & Olahan Kopi' => [
                ['name' => 'Kopi susu', 'sugar_per_100ml' => 12.4],
                ['name' => 'Cappuccino sachet', 'sugar_per_100ml' => 10.5],
                ['name' => 'Es kopi gula aren', 'sugar_per_100ml' => 12.4],
            ],
            'Boba & Minuman Kekinian' => [
                ['name' => 'Boba', 'sugar_per_100ml' => 14.2],
                ['name' => 'Bubble drink', 'sugar_per_100ml' => 13.8],
                ['name' => 'Milkshake', 'sugar_per_100ml' => 14.5],
                ['name' => 'Minuman jelly', 'sugar_per_100ml' => 10.0],
            ],
            'Minuman Bersoda & Olahraga' => [
                ['name' => 'Minuman soda', 'sugar_per_100ml' => 10.6],
                ['name' => 'Minuman energi', 'sugar_per_100ml' => 11.3],
                ['name' => 'Minuman isotonik', 'sugar_per_100ml' => 6.4],
            ],
            'Susu & Olahan Dairy' => [
                ['name' => 'Susu rasa coklat', 'sugar_per_100ml' => 9.5],
                ['name' => 'Yogurt manis', 'sugar_per_100ml' => 11.0],
                ['name' => 'Minuman coklat', 'sugar_per_100ml' => 12.8],
            ],
            'Jus, Sirup & Kemasan Lain' => [
                ['name' => 'Jus kemasan', 'sugar_per_100ml' => 10.8],
                ['name' => 'Sirup', 'sugar_per_100ml' => 15.0],
                ['name' => 'Minuman kemasan lainnya', 'sugar_per_100ml' => 10.0],
            ],
        ];

        foreach ($beverageCategoriesData as $catName => $items) {
            $cat = BeverageCategory::firstOrCreate(['name' => $catName]);
            foreach ($items as $item) {
                Beverage::firstOrCreate(
                    ['name' => $item['name']],
                    [
                        'category_id' => $cat->id,
                        'sugar_per_100ml' => $item['sugar_per_100ml'],
                    ]
                );
            }
        }

        // 4. Membuat Master Tantangan (Gamifikasi & Subjective Norms)
        Challenge::firstOrCreate(
            ['title' => '3 Hari Tanpa Soda'], 
            ['description' => 'Jangan minum minuman bersoda selama 3 hari berturut-turut.', 'reward_points' => 50, 'is_active' => true]
        );
        Challenge::firstOrCreate(
            ['title' => 'Pejuang Air Putih'], 
            ['description' => 'Ganti minuman manismu dengan air putih hari ini.', 'reward_points' => 20, 'is_active' => true]
        );

        // 5. Membuat Akun Super Admin (Kendali Penuh)
        User::firstOrCreate(
            ['email' => 'admin@smartsip.id'],
            [
                'name' => 'Administrator Peneliti',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // (Data Guru dan Siswa dummy telah dihilangkan agar database siap untuk Go Live)

        // 8. Membuat Soal Kuesioner TPB (Theory of Planned Behavior - Instrumen Dokumen Baku 23 Item)
        $tpbQuestions = [
            // Attitude (Sikap - 6 Item)
            ['construct_type' => 'attitude', 'question_text' => 'Mengurangi konsumsi minuman manis bermanfaat bagi kesehatan saya.'],
            ['construct_type' => 'attitude', 'question_text' => 'Mengurangi konsumsi minuman manis merupakan keputusan yang baik.'],
            ['construct_type' => 'attitude', 'question_text' => 'Mengurangi konsumsi minuman manis membuat tubuh saya lebih sehat.'],
            ['construct_type' => 'attitude', 'question_text' => 'Mengurangi konsumsi minuman manis membantu mencegah obesitas.'],
            ['construct_type' => 'attitude', 'question_text' => 'Mengurangi konsumsi minuman manis layak saya lakukan.'],
            ['construct_type' => 'attitude', 'question_text' => 'Mengurangi konsumsi minuman manis penting bagi masa depan kesehatan saya.'],

            // Subjective Norm (Norma Subjektif - 6 Item)
            ['construct_type' => 'subjective_norm', 'question_text' => 'Orang tua saya mendukung saya mengurangi minuman manis.'],
            ['construct_type' => 'subjective_norm', 'question_text' => 'Guru saya menyarankan saya membatasi minuman manis.'],
            ['construct_type' => 'subjective_norm', 'question_text' => 'Teman saya mendukung saya memilih air putih.'],
            ['construct_type' => 'subjective_norm', 'question_text' => 'Orang penting bagi saya ingin saya mengurangi minuman manis.'],
            ['construct_type' => 'subjective_norm', 'question_text' => 'Saya merasa lingkungan sekolah mendukung konsumsi minuman sehat.'],
            ['construct_type' => 'subjective_norm', 'question_text' => 'Saya merasa keluarga saya memberi contoh yang baik.'],

            // Perceived Behavioral Control (PBC - 6 Item)
            ['construct_type' => 'pbc', 'question_text' => 'Saya mampu menolak minuman manis.'],
            ['construct_type' => 'pbc', 'question_text' => 'Saya mampu memilih air putih.'],
            ['construct_type' => 'pbc', 'question_text' => 'Saya tetap dapat mengurangi minuman manis meskipun teman saya meminumnya.'],
            ['construct_type' => 'pbc', 'question_text' => 'Saya dapat mengontrol diri ketika ingin membeli minuman manis.'],
            ['construct_type' => 'pbc', 'question_text' => 'Saya memiliki kesempatan memilih minuman sehat.'],
            ['construct_type' => 'pbc', 'question_text' => 'Mengurangi minuman manis merupakan hal yang mudah bagi saya.'],

            // Behavioral Intention (Niat Perilaku - 5 Item)
            ['construct_type' => 'intention', 'question_text' => 'Saya berniat mengurangi minuman manis mulai minggu ini.'],
            ['construct_type' => 'intention', 'question_text' => 'Saya akan memilih air putih lebih sering.'],
            ['construct_type' => 'intention', 'question_text' => 'Saya akan mengurangi membeli minuman kemasan.'],
            ['construct_type' => 'intention', 'question_text' => 'Saya akan membaca kandungan gula sebelum membeli minuman.'],
            ['construct_type' => 'intention', 'question_text' => 'Saya berkomitmen membatasi konsumsi minuman manis.'],
        ];

        foreach ($tpbQuestions as $q) {
            TpbQuestion::firstOrCreate(
                ['question_text' => $q['question_text']],
                ['construct_type' => $q['construct_type'], 'is_active' => true]
            );
        }

        // 9. Membuat Soal Pengetahuan tentang Konsumsi Gula (10 Item Baku Dokumen)
        $knowledgeQuestions = [
            [
                'question_text' => 'WHO menganjurkan konsumsi gula bebas maksimal per hari untuk orang dewasa dan anak adalah....',
                'options' => ['A' => '25 gram (±6 sendok teh)', 'B' => '50 gram', 'C' => '75 gram', 'D' => 'Tidak tahu'],
                'correct_option' => 'A',
            ],
            [
                'question_text' => 'Minuman berikut yang umumnya mengandung gula paling tinggi adalah....',
                'options' => ['A' => 'Air putih', 'B' => 'Teh tawar', 'C' => 'Minuman bersoda', 'D' => 'Air mineral'],
                'correct_option' => 'C',
            ],
            [
                'question_text' => 'Konsumsi gula berlebihan dapat meningkatkan risiko....',
                'options' => ['A' => 'Obesitas', 'B' => 'Diabetes melitus tipe 2', 'C' => 'Penyakit jantung', 'D' => 'Semua jawaban benar'],
                'correct_option' => 'D',
            ],
            [
                'question_text' => 'Minuman yang paling sehat untuk dikonsumsi setiap hari adalah....',
                'options' => ['A' => 'Air putih', 'B' => 'Minuman bersoda', 'C' => 'Minuman energi', 'D' => 'Bubble tea'],
                'correct_option' => 'A',
            ],
            [
                'question_text' => 'Salah satu cara mengetahui kandungan gula dalam minuman kemasan adalah dengan....',
                'options' => ['A' => 'Melihat warna kemasan', 'B' => 'Membaca label informasi nilai gizi', 'C' => 'Melihat iklan di televisi', 'D' => 'Menanyakan kepada teman'],
                'correct_option' => 'B',
            ],
            [
                'question_text' => 'Mengonsumsi minuman berpemanis setiap hari dapat menyebabkan....',
                'options' => ['A' => 'Berat badan meningkat', 'B' => 'Kerusakan gigi', 'C' => 'Risiko diabetes meningkat', 'D' => 'Semua jawaban benar'],
                'correct_option' => 'D',
            ],
            [
                'question_text' => 'Berikut yang termasuk Sugar-Sweetened Beverage (SSB) adalah....',
                'options' => ['A' => 'Air putih', 'B' => 'Teh tanpa gula', 'C' => 'Minuman teh kemasan manis', 'D' => 'Air mineral'],
                'correct_option' => 'C',
            ],
            [
                'question_text' => 'Jika merasa haus setelah beraktivitas, pilihan minuman terbaik adalah....',
                'options' => ['A' => 'Air putih', 'B' => 'Minuman bersoda', 'C' => 'Minuman rasa buah dengan tambahan gula', 'D' => 'Minuman energi'],
                'correct_option' => 'A',
            ],
            [
                'question_text' => 'Mengurangi konsumsi minuman manis dapat membantu....',
                'options' => ['A' => 'Menjaga berat badan tetap ideal', 'B' => 'Mengurangi risiko diabetes', 'C' => 'Menjaga kesehatan tubuh', 'D' => 'Semua jawaban benar'],
                'correct_option' => 'D',
            ],
            [
                'question_text' => 'Salah satu kebiasaan yang dapat membantu mengurangi konsumsi gula adalah....',
                'options' => ['A' => 'Membawa botol air minum sendiri', 'B' => 'Membeli minuman manis setiap hari', 'C' => 'Menambahkan gula pada semua minuman', 'D' => 'Mengonsumsi minuman bersoda saat haus'],
                'correct_option' => 'A',
            ],
        ];

        foreach ($knowledgeQuestions as $kq) {
            \App\Models\KnowledgeQuestion::firstOrCreate(
                ['question_text' => $kq['question_text']],
                ['options' => $kq['options'], 'correct_option' => $kq['correct_option'], 'is_active' => true]
            );
        }

        // 10. Membuat Materi Edukasi Awal
        Education::firstOrCreate(
            ['title' => 'Fakta Gula Tersembunyi pada Minuman Kekinian'],
            [
                'type' => 'artikel',
                'content' => 'Tahukah kamu? Segelas brown sugar boba bisa mengandung hingga 50-60 gram gula! Jumlah ini setara dengan dua kali lipat rekomendasi harian WHO untuk remaja. Gula berlebih yang masuk ke tubuh tidak langsung diubah menjadi energi, melainkan disimpan sebagai lemak. Dampak jangka panjangnya bisa memicu kegemukan (obesitas), kerusakan gigi, hingga diabetes tipe 2 di usia muda. Jadi, yuk mulai perhatikan apa yang kita teguk!',
                'is_published' => true
            ]
        );
        Education::firstOrCreate(
            ['title' => 'Kenapa Gula Bikin Ketagihan?'],
            [
                'type' => 'video',
                'content' => 'Sebuah video animasi singkat yang menjelaskan efek gula di otak kita. Ketika kita mengonsumsi gula, otak melepaskan hormon dopamin yang membuat kita merasa senang sementara waktu, sehingga memicu keinginan untuk minum manis lagi. Pelajari cara memutus lingkaran kecanduan ini dengan membatasi asupan harianmu!',
                'media_url' => 'https://www.youtube.com/embed/epZtSnhEBg4',
                'is_published' => true
            ]
        );
        Education::firstOrCreate(
            ['title' => '3 Langkah Praktis Kurangi Boba & Kopi Susu'],
            [
                'type' => 'tips',
                'content' => "1. Kurangi level kemanisan (less sugar): Mulailah dengan meminta kadar gula 50% atau 25% saat memesan.\n2. Perkecil ukuran gelas (size down): Pilih ukuran small daripada large untuk memangkas asupan gula secara drastis.\n3. Atur jadwal khusus (cheat day): Batasi konsumsi minuman manis hanya 1 kali dalam seminggu sebagai reward.",
                'is_published' => true
            ]
        );
    }
}