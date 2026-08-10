import os
import sys
from reportlab.lib.pagesizes import letter
from reportlab.lib import colors
from reportlab.platypus import (
    SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, PageBreak, KeepTogether, HRFlowable
)
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.pdfgen import canvas

class NumberedCanvas(canvas.Canvas):
    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self._saved_page_states = []

    def showPage(self):
        self._saved_page_states.append(dict(self.__dict__))
        self._startPage()

    def save(self):
        num_pages = len(self._saved_page_states)
        for state in self._saved_page_states:
            self.__dict__.update(state)
            self.draw_page_decorations(num_pages)
            super().showPage()
        super().save()

    def draw_page_decorations(self, page_count):
        self.saveState()
        self.setFont("Helvetica-Bold", 8)
        self.setFillColor(colors.HexColor("#64748b"))
        
        # Header (Only on page 2+)
        if self._pageNumber > 1:
            self.drawString(54, 11 * 72 - 36, "SmartSip Web — Manual Pengguna & Riset Intervensi Gula")
            self.setStrokeColor(colors.HexColor("#e2e8f0"))
            self.setLineWidth(0.5)
            self.line(54, 11 * 72 - 42, 8.5 * 72 - 54, 11 * 72 - 42)
        
        # Footer (All pages)
        self.setStrokeColor(colors.HexColor("#e2e8f0"))
        self.setLineWidth(0.5)
        self.line(54, 48, 8.5 * 72 - 54, 48)
        
        page_str = f"Halaman {self._pageNumber} dari {page_count}"
        self.drawRightString(8.5 * 72 - 54, 34, page_str)
        self.drawString(54, 34, "© 2026 SmartSip Web — Tim Peneliti Theory of Planned Behavior (TPB)")
        self.restoreState()


def create_pdf(filename, title, subtitle, target_user, primary_color, sections):
    pdf_path = os.path.join("public", "panduan", filename)
    os.makedirs(os.path.dirname(pdf_path), exist_ok=True)
    
    doc = SimpleDocTemplate(
        pdf_path,
        pagesize=letter,
        leftMargin=54,
        rightMargin=54,
        topMargin=54,
        bottomMargin=60
    )
    
    styles = getSampleStyleSheet()
    
    # Custom styles
    style_cover_title = ParagraphStyle(
        'CoverTitle',
        parent=styles['Heading1'],
        fontName='Helvetica-Bold',
        fontSize=22,
        leading=26,
        textColor=colors.HexColor(primary_color),
        spaceAfter=8
    )
    
    style_cover_sub = ParagraphStyle(
        'CoverSub',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=11,
        leading=15,
        textColor=colors.HexColor("#475569"),
        spaceAfter=15
    )

    style_badge = ParagraphStyle(
        'BadgeText',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=9,
        leading=11,
        textColor=colors.white
    )
    
    style_h1 = ParagraphStyle(
        'SectionH1',
        parent=styles['Heading2'],
        fontName='Helvetica-Bold',
        fontSize=13,
        leading=16,
        textColor=colors.HexColor(primary_color),
        spaceBefore=14,
        spaceAfter=6,
        keepWithNext=True
    )

    style_h2 = ParagraphStyle(
        'SectionH2',
        parent=styles['Heading3'],
        fontName='Helvetica-Bold',
        fontSize=10.5,
        leading=14,
        textColor=colors.HexColor("#1e293b"),
        spaceBefore=10,
        spaceAfter=4,
        keepWithNext=True
    )
    
    style_body = ParagraphStyle(
        'BodyTextCustom',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=9.5,
        leading=13.5,
        textColor=colors.HexColor("#334155"),
        spaceAfter=6
    )

    style_bullet = ParagraphStyle(
        'BulletCustom',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=9,
        leading=13,
        textColor=colors.HexColor("#334155"),
        leftIndent=12,
        firstLineIndent=-8,
        spaceAfter=3
    )

    style_callout = ParagraphStyle(
        'CalloutText',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=9,
        leading=13,
        textColor=colors.HexColor("#1e293b")
    )

    elements = []
    
    # Cover Header Banner Table
    badge_table = Table(
        [[Paragraph(f"MANUAL PENGGUNA: {target_user.upper()}", style_badge)]],
        colWidths=[504]
    )
    badge_table.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,-1), colors.HexColor(primary_color)),
        ('PADDING', (0,0), (-1,-1), 6),
        ('ALIGN', (0,0), (-1,-1), 'LEFT'),
        ('VALIGN', (0,0), (-1,-1), 'MIDDLE'),
        ('BOTTOMPADDING', (0,0), (-1,-1), 6),
        ('TOPPADDING', (0,0), (-1,-1), 6),
    ]))
    
    elements.append(badge_table)
    elements.append(Spacer(1, 10))
    elements.append(Paragraph(title, style_cover_title))
    elements.append(Paragraph(subtitle, style_cover_sub))
    elements.append(HRFlowable(width="100%", thickness=1.5, color=colors.HexColor(primary_color), spaceBefore=0, spaceAfter=12))

    # Credential Box (Default Login info)
    if "credentials" in sections:
        cred = sections["credentials"]
        cred_table = Table([
            [Paragraph("🔑 <b>KREDENSIAL LOGIN BAWAAN</b>", ParagraphStyle('H', parent=style_body, fontName='Helvetica-Bold', textColor=colors.HexColor("#1e293b")))],
            [Paragraph(f"<b>URL Aplikasi:</b> <font color='#5c62f9'><u>http://127.0.0.1:8000</u></font><br/><b>Email:</b> {cred['email']}<br/><b>Password:</b> {cred['password']}<br/><b>Peran / Hak Akses:</b> {cred['role']}", style_body)]
        ], colWidths=[504])
        cred_table.setStyle(TableStyle([
            ('BACKGROUND', (0,0), (-1,-1), colors.HexColor("#f8fafc")),
            ('BOX', (0,0), (-1,-1), 1, colors.HexColor("#cbd5e1")),
            ('PADDING', (0,0), (-1,-1), 10),
        ]))
        elements.append(cred_table)
        elements.append(Spacer(1, 12))

    # Content Sections
    for sec in sections["content"]:
        elements.append(Paragraph(sec["h1"], style_h1))
        
        if "intro" in sec:
            elements.append(Paragraph(sec["intro"], style_body))
            
        for sub in sec.get("subsections", []):
            if "h2" in sub:
                elements.append(Paragraph(sub["h2"], style_h2))
            if "text" in sub:
                elements.append(Paragraph(sub["text"], style_body))
            if "bullets" in sub:
                for b in sub["bullets"]:
                    elements.append(Paragraph(f"• {b}", style_bullet))
            if "table" in sub:
                t_data = sub["table"]
                formatted_data = []
                for row_idx, row in enumerate(t_data):
                    formatted_row = []
                    for cell in row:
                        if row_idx == 0:
                            formatted_row.append(Paragraph(f"<b>{cell}</b>", ParagraphStyle('TH', parent=style_body, fontSize=8.5, textColor=colors.white)))
                        else:
                            formatted_row.append(Paragraph(cell, ParagraphStyle('TD', parent=style_body, fontSize=8.5)))
                    formatted_data.append(formatted_row)
                
                table_obj = Table(formatted_data, colWidths=sub.get("colWidths", None))
                table_obj.setStyle(TableStyle([
                    ('BACKGROUND', (0,0), (-1,0), colors.HexColor(primary_color)),
                    ('TEXTCOLOR', (0,0), (-1,0), colors.white),
                    ('GRID', (0,0), (-1,-1), 0.5, colors.HexColor("#cbd5e1")),
                    ('ROWBACKGROUNDS', (0,1), (-1,-1), [colors.white, colors.HexColor("#f8fafc")]),
                    ('PADDING', (0,0), (-1,-1), 5),
                    ('VALIGN', (0,0), (-1,-1), 'TOP'),
                ]))
                elements.append(Spacer(1, 4))
                elements.append(table_obj)
                elements.append(Spacer(1, 6))

        elements.append(Spacer(1, 4))

    doc.build(elements, canvasmaker=NumberedCanvas)
    print(f"[SUCCESS] Document created: {pdf_path}")


# DATA SECTION FOR SISWA
siswa_sections = {
    "credentials": {
        "email": "siswa@smartsip.id",
        "password": "password123",
        "role": "Siswa Responden (Gen Z)"
    },
    "content": [
        {
            "h1": "1. Registrasi & Alur Memulai Akun Siswa",
            "intro": "Responden Siswa dapat mendaftarkan akun baru atau menggunakan akun yang telah disiapkan oleh tim peneliti.",
            "subsections": [
                {
                    "h2": "A. Cara Mendaftar Akun Baru",
                    "bullets": [
                        "Buka peramban (browser) dan akses alamat <b>http://127.0.0.1:8000/register</b>.",
                        "Isi formulir pendaftaran: Nama Lengkap, Alamat Email Aktif, dan Kata Sandi (Password min. 8 karakter).",
                        "Klik tombol <b>Daftar / Register</b>. Sistem akan mendaftarkan akun dengan peran otomatis sebagai <b>Siswa Responden</b>.",
                        "Setelah pendaftaran berhasil, Anda akan secara otomatis diarahkan ke halaman <b>Setup Profil Responden (/setup-profil)</b>."
                    ]
                },
                {
                    "h2": "B. Cara Login Akun Siswa",
                    "bullets": [
                        "Akses <b>http://127.0.0.1:8000/login</b>.",
                        "Masukkan Email: <b>siswa@smartsip.id</b> dan Password: <b>password123</b>.",
                        "Klik tombol <b>Masuk / Login</b>."
                    ]
                }
            ]
        },
        {
            "h1": "2. Pengisian Profil Awal (Bagian A - Identitas & Antropometri)",
            "intro": "Sebelum mengakses instrumen riset dan mencatat asupan gula harian, Siswa wajib melengkapi 10 poin data demografi & fisik pada halaman <b>/setup-profil</b>:",
            "subsections": [
                {
                    "table": [
                        ["No", "Variabel Demografi & Fisik", "Keterangan Pengisian"],
                        ["1", "Kode Responden / Nickname", "Nama samaran unik untuk kerahasiaan identitas di leaderboard."],
                        ["2", "Asal Sekolah & Kelas", "Pilih Sekolah Mitra (misal: SMAN 1 Intervensi) dan Kelas Belajar."],
                        ["3", "Jenis Kelamin & Tanggal Lahir", "Pilih Laki-laki / Perempuan dan tanggal lahir untuk kalkulasi usia."],
                        ["4", "Tinggi (cm) & Berat (kg)", "Input tinggi & berat badan untuk menghitung otomatis Indeks Massa Tubuh (IMT)."],
                        ["5", "Lemak Tubuh (% BIA)", "Input persentase lemak tubuh hasil pengukuran BIA (opsional/didampingi peneliti)."],
                        ["6", "Uang Saku per Hari", "Pilihan opsi uang saku harian (< Rp10rb s.d. > Rp30rb)."],
                        ["7", "Pendidikan Ayah & Ibu", "Pilihan jenjang pendidikan terakhir orang tua."],
                        ["8", "Informed Consent", "Centang lembar persetujuan sukarela partisipasi riset."]
                    ],
                    "colWidths": [30, 160, 314]
                }
            ]
        },
        {
            "h1": "3. Fitur Pemantauan Asupan Gula Harian (Sugar Tracker)",
            "subsections": [
                {
                    "h2": "A. Pencatatan Konsumsi Minuman",
                    "bullets": [
                        "Pada <b>Dashboard Siswa</b>, klik tombol <b>+ Catat Minum Hari Ini</b>.",
                        "Pilih kategori minuman (Bersoda, Boba & Kopi Susu, Teh Kemasan, dll.) dan pilih varian minuman.",
                        "Masukkan porsi / jumlah konsumsi (ml). Sistem akan menghitung otomatis total kandungan gula dalam gram.",
                        "Klik <b>Simpan Konsumsi</b>. Poin gamifikasi akan bertambah secara otomatis!"
                    ]
                },
                {
                    "h2": "B. Sistem Peringatan Cerdas (Smart Warning TPB)",
                    "bullets": [
                        "<b>Warna Hijau (Aman):</b> Konsumsi gula hari ini <= 15 gram.",
                        "<b>Warna Kuning (Waspada):</b> Konsumsi gula mendekati batas WHO (16 - 25 gram).",
                        "<b>Warna Merah (Bahaya WHO):</b> Konsumsi gula melebihi batas rekomendasi WHO (> 25 gram/hari). Notifikasi dorongan TPB (Perceived Behavioral Control) akan otomatis aktif."
                    ]
                }
            ]
        },
        {
            "h1": "4. Pengisian Kuesioner Riset (Pusat Kuesioner /survey)",
            "intro": "Siswa wajib menyelesaikan 5 bagian instrumen riset baku sesuai tahapan intervensi:",
            "subsections": [
                {
                    "table": [
                        ["Bagian", "Nama Instrumen", "Jumlah Soal & Deskripsi"],
                        ["Bagian A", "Identitas Responden", "10 Poin data demografi, uang saku, & antropometri."],
                        ["Bagian B", "FFQ 7 Hari", "Frekuensi konsumsi 20 jenis minuman berpemanis dalam sepekan."],
                        ["Bagian C", "Kuesioner TPB", "23 Item Likert (Attitude, Subjective Norm, PBC, Intention)."],
                        ["Bagian D", "Pengetahuan Gula", "10 Soal Pilihan Ganda seputar fakta & dampak gula."],
                        ["Bagian E", "Usability Web (SUS)", "10 Item evaluasi kemudahan dan kenyamanan web SmartSip."]
                    ],
                    "colWidths": [60, 140, 304]
                }
            ]
        },
        {
            "h1": "5. Fitur Gamifikasi, Leaderboard, & Edukasi",
            "subsections": [
                {
                    "bullets": [
                        "<b>Misi Harian:</b> Selesaikan tantangan sehat seperti '3 Hari Tanpa Soda' atau 'Pejuang Air Putih' untuk mengumpulkan Poin.",
                        "<b>Papan Peringkat (Leaderboard):</b> Lihat peringkat keaktifan antar-siswa berdasarkan nama samaran (Nickname).",
                        "<b>Modul Edukasi:</b> Akses artikel, video animasi, dan tips praktis pengurangan gula pada menu Edukasi."
                    ]
                }
            ]
        }
    ]
}


# DATA SECTION FOR GURU
guru_sections = {
    "credentials": {
        "email": "guru@smartsip.id",
        "password": "password123",
        "role": "Guru / Tim Pemantau UKS Sekolah"
    },
    "content": [
        {
            "h1": "1. Registrasi & Penetapan Akun Guru UKS",
            "intro": "Akun Guru Pemantau dapat dibuat secara mandiri atau ditetapkan langsung oleh Admin Peneliti Utama melalui menu Manajemen Akun.",
            "subsections": [
                {
                    "h2": "A. Login Akun Guru",
                    "bullets": [
                        "Buka <b>http://127.0.0.1:8000/login</b>.",
                        "Masukkan Email: <b>guru@smartsip.id</b> dan Password: <b>password123</b>.",
                        "Sistem akan langsung mengarahkan Anda ke <b>Dashboard Pemantau UKS / Guru</b>."
                    ]
                },
                {
                    "h2": "B. Sistem Hak Akses Terisolasi (School Scoping)",
                    "bullets": [
                        "Setiap akun Guru dihubungkan secara spesifik ke <b>Sekolah Tempat Mengajar</b> (misal: SMAN 1 Intervensi).",
                        "<b>Keamanan & Privasi Data:</b> Guru HANYA dapat melihat data statistik, tren, dan daftar siswa dari sekolah tempatnya mengajar. Data sekolah lain secara otomatis terisolasi demi kerahasiaan etika penelitian."
                    ]
                }
            ]
        },
        {
            "h1": "2. Penjelasan Fitur Dashboard Pemantau UKS",
            "subsections": [
                {
                    "h2": "A. Ringkasan Kartu Metrik Utama",
                    "table": [
                        ["Kartu Metrik", "Keterangan & Indikator"],
                        ["Siswa Terpantau", "Jumlah total siswa responden aktif terdaftar di sekolah Anda."],
                        ["Rerata Gula Hari Ini", "Rata-rata konsumsi gula harian siswa (gram/siswa/hari)."],
                        ["Melebihi Batas WHO (>25g)", "Persentase siswa yang mengonsumsi gula di atas ambang batas WHO (25g) hari ini."],
                        ["Rerata Poin Gamifikasi", "Rata-rata poin keaktifan misi sehat yang dikumpulkan siswa."]
                    ],
                    "colWidths": [150, 354]
                },
                {
                    "h2": "B. Grafik Interaktif Tren 7 Hari Terakhir",
                    "bullets": [
                        "Menampilkan kurva tren rata-rata konsumsi gula harian seluruh siswa di sekolah Anda selama 7 hari terakhir.",
                        "Gunakan grafik ini untuk mengevaluasi efektivitas intervensi edukasi dari minggu ke minggu."
                    ]
                }
            ]
        },
        {
            "h1": "3. Pemantauan Statistik Per Kelas & Detail Siswa",
            "subsections": [
                {
                    "h2": "A. Statistik Per Kelas",
                    "bullets": [
                        "Tabel perbandingan jumlah siswa, rata-rata konsumsi gula harian, dan poin gamifikasi untuk tiap kelas yang Anda ampu."
                    ]
                },
                {
                    "h2": "B. Daftar Keaktifan & Kesehatan Siswa",
                    "bullets": [
                        "Memuat data individual siswa: <b>Nama Samaran (Pseudonym)</b>, <b>Gender</b>, <b>Kelas</b>, <b>Nilai IMT</b>, <b>Konsumsi Gula Hari Ini</b>, <b>Total Poin</b>, serta <b>Status Pengisian Kuesioner (Sudah Isi / Belum)</b>.",
                        "Warna angka gula otomatis berubah menjadi merah jika siswa mengonsumsi lebih dari 25 gram gula hari ini."
                    ]
                }
            ]
        },
        {
            "h1": "4. Pelaporan & Rekapitulasi Sekolah",
            "subsections": [
                {
                    "bullets": [
                        "Guru UKS dapat menggunakan data dashboard untuk memberikan konseling gizi bagi siswa berisiko tinggi (gula >25g & IMT berlebih).",
                        "Data rekapitulasi dapat dijadikan bahan laporan bulanan kesehatan sekolah."
                    ]
                }
            ]
        }
    ]
}


# DATA SECTION FOR ADMIN
admin_sections = {
    "credentials": {
        "email": "admin@smartsip.id",
        "password": "password123",
        "role": "Administrator Peneliti Utama"
    },
    "content": [
        {
            "h1": "1. Login & Panel Kontrol Utama Administrator",
            "intro": "Administrator memiliki hak akses tertinggi untuk mengelola instrumen riset TPB, master data sekolah/minuman, serta manajemen akun pengguna.",
            "subsections": [
                {
                    "h2": "A. Akses Panel Admin",
                    "bullets": [
                        "Akses <b>http://127.0.0.1:8000/login</b>.",
                        "Gunakan Email: <b>admin@smartsip.id</b> dan Password: <b>password123</b>.",
                        "Dashboard Admin menampilkan 7 Ringkasan Master Data Riset serta Grafik Tren Analitis Keseluruhan Responden."
                    ]
                }
            ]
        },
        {
            "h1": "2. Manajemen Sekolah Mitra & Pembagian Kelas",
            "subsections": [
                {
                    "h2": "A. Kelola Sekolah Mitra (/admin/schools)",
                    "bullets": [
                        "Tambah/Edit/Hapus Sekolah Mitra.",
                        "Tentukan Klasifikasi Kelompok Penelitian: <b>Intervensi</b> (menerima edukasi & gamifikasi) atau <b>Kontrol</b> (kelompok pembanding)."
                    ]
                },
                {
                    "h2": "B. Kelola Kelas Belajar (/admin/classes)",
                    "bullets": [
                        "Tambah dan distribusikan kelas belajar (misal: X-IPA 1, XI-IPS 2) sesuai Sekolah Mitra masing-masing."
                    ]
                }
            ]
        },
        {
            "h1": "3. Manajemen Akun Pengguna & Penetapan Guru (/admin/users)",
            "subsections": [
                {
                    "bullets": [
                        "<b>Tambah Akun Baru:</b> Buat akun untuk Siswa, Guru, atau Admin tambahan.",
                        "<b>Penetapan Sekolah Guru:</b> Saat membuat/mengedit akun Guru, wajib memilih <b>Sekolah Mengajar</b> agar Guru tersebut hanya dapat memantau siswa di sekolahnya sendiri.",
                        "<b>Reset Password & Hapus Akun:</b> Fasilitas reset password dan penghapusan pengguna."
                    ]
                }
            ]
        },
        {
            "h1": "4. Pengelolaan Master Minuman & Tantangan Gamifikasi",
            "subsections": [
                {
                    "table": [
                        ["Menu Admin", "Fungsi Utama Pengelolaan"],
                        ["Kelola Kategori Minuman", "Manajemen kategori (Bersoda, Boba, Kopi Susu, Teh Kemasan, dll.)."],
                        ["Kelola Produk Minuman", "Input merk minuman, foto produk, dan takaran gula per 100ml."],
                        ["Kelola Misi Gamifikasi", "Buat tantangan sehat baru (misal: '3 Hari Tanpa Soda') & atur reward poin."]
                    ],
                    "colWidths": [160, 344]
                }
            ]
        },
        {
            "h1": "5. Pengelolaan Instrumen Kuesioner Riset TPB",
            "subsections": [
                {
                    "bullets": [
                        "<b>Kelola Soal TPB (/admin/tpb-questions):</b> Manajemen 23 item soal baku TPB (Konstruk Sikap/Attitude, Norma Subjektif, Control/PBC, & Niat/Intention).",
                        "<b>Kelola Soal Pengetahuan (/admin/knowledge-questions):</b> Manajemen 10 soal pilihan ganda pengetahuan gizi & gula.",
                        "<b>Kelola Edukasi (/admin/educations):</b> Publikasi artikel, video interaktif, dan tips sehat."
                    ]
                }
            ]
        },
        {
            "h1": "6. Ekspor Data Mentah Riset (SPSS / Excel / CSV)",
            "subsections": [
                {
                    "bullets": [
                        "Ekspor seluruh data mentah penelitian: Identitas Responden (Bagian A), Frekuensi FFQ (Bagian B), Skor Jawaban TPB (Bagian C), Skor Pengetahuan (Bagian D), Usability SUS (Bagian E), serta Log Konsumsi Gula.",
                        "Format file siap olah untuk analisis statistik SPSS, R, maupun Jamovi."
                    ]
                }
            ]
        }
    ]
}

if __name__ == "__main__":
    create_pdf(
        "Panduan_Pengguna_Siswa.pdf",
        "PANDUAN PENGGUNA SMARTSIP WEB",
        "Modul Petunjuk Penggunaan Aplikasi Pemantauan Asupan Gula & Instrumen Riset TPB untuk Siswa Responden",
        "Siswa Responden",
        "#5c62f9",
        siswa_sections
    )
    
    create_pdf(
        "Panduan_Pengguna_Guru.pdf",
        "PANDUAN PENGGUNA SMARTSIP WEB",
        "Modul Petunjuk Pemantauan Kesehatan Siswa, Konsumsi Gula, & Evaluasi Sekolah untuk Guru / Tim UKS",
        "Guru / Tim UKS",
        "#059669",
        guru_sections
    )

    create_pdf(
        "Panduan_Pengguna_Admin.pdf",
        "PANDUAN PENGGUNA SMARTSIP WEB",
        "Manual Pengelolaan Terpusat Instrumen Riset TPB, Master Data, & Manajemen Akun untuk Admin Peneliti Utama",
        "Admin Peneliti Utama",
        "#4f46e5",
        admin_sections
    )
