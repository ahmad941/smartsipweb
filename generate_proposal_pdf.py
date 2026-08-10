import os
import shutil
from fpdf import FPDF

class PDF(FPDF):
    def header(self):
        # Header banner
        self.set_fill_color(30, 58, 138) # Navy Blue
        self.rect(0, 0, 210, 25, 'F')
        
        self.set_font('Helvetica', 'B', 14)
        self.set_text_color(255, 255, 255)
        self.set_xy(10, 5)
        self.cell(190, 8, 'SMARTSIP - DOKUMEN USULAN ARSITEKTUR', 0, 1, 'L')
        
        self.set_font('Helvetica', '', 10)
        self.set_xy(10, 13)
        self.cell(190, 6, 'Kajian Teknis: Akses Aktivitas Siswa Tanpa Perlu Login (Email/Password)', 0, 1, 'L')
        
        self.ln(12)

    def footer(self):
        self.set_y(-15)
        self.set_font('Helvetica', 'I', 8)
        self.set_text_color(148, 163, 184)
        self.cell(0, 10, f'Dokumen Usulan SmartSip System Development | Halaman {self.page_no()}', 0, 0, 'C')

    def section_title(self, txt):
        self.set_font('Helvetica', 'B', 11)
        self.set_fill_color(239, 246, 255) # Light Blue
        self.set_text_color(30, 58, 138) # Navy
        self.cell(190, 8, f'  {txt}', 0, 1, 'L', fill=True)
        self.ln(2)

    def body_text(self, txt):
        self.set_font('Helvetica', '', 9.5)
        self.set_text_color(51, 65, 85)
        self.multi_cell(190, 5, txt)
        self.ln(2)

    def option_box(self, title, desc, pros, cons):
        self.set_font('Helvetica', 'B', 10)
        self.set_text_color(29, 78, 216)
        self.cell(190, 6, title, 0, 1, 'L')
        
        self.set_font('Helvetica', '', 9)
        self.set_text_color(51, 65, 85)
        self.multi_cell(190, 4.5, f"Deskripsi: {desc}")
        self.multi_cell(190, 4.5, f"Kelebihan: {pros}")
        self.multi_cell(190, 4.5, f"Catatan: {cons}")
        self.ln(3)

def generate_pdf():
    pdf = PDF()
    pdf.add_page()
    pdf.set_auto_page_break(auto=True, margin=15)

    # Date and status
    pdf.set_font('Helvetica', 'I', 8.5)
    pdf.set_text_color(100, 116, 139)
    pdf.cell(190, 5, 'Tanggal: 4 Agustus 2026 | Status: Rekomendasi Arsitektur Perangkat Lunak', 0, 1, 'R')
    pdf.ln(3)

    # 1. Latar Belakang
    pdf.section_title('1. LATAR BELAKANG & TUJUAN')
    pdf.body_text(
        "Berdasarkan arahan pimpinan/atasan, aplikasi SmartSip akan disesuaikan agar siswa dapat langsung "
        "mengakses dan melakukan berbagai aktivitas (Log Gula Harian, Edukasi & Kuis, Challenge, serta Pengisian Survei FFQ/TPB/Knowledge/SUS) "
        "tanpa harus melalui proses registrasi atau login (Email & Password) yang rumit.\n\n"
        "Tujuan dokumen ini adalah menyajikan analisis pilihan solusi teknis beserta kelebihan dan dampaknya "
        "terhadap integritas data riset penelitian SmartSip."
    )

    # 2. Pilihan Solusi Arsitektur
    pdf.section_title('2. PILIHAN SOLUSI ARSITEKTUR')
    
    pdf.option_box(
        "OPSI A: Mode Guest / Auto-Session (Rekomendasi Utama)",
        "Siswa membuka tautan web -> Sistem otomatis menetapkan ID Sesi unik di browser HP. Pertama kali buka, siswa hanya perlu mengisi Form Identitas Singkat (Nama/Inisial, Sekolah, Kelas, Umur, Jenis Kelamin).",
        "Sangat ramah siswa (Zero-login), tidak ada risiko lupa password. Data riset (demografi, log gula, kuis, survei) TETAP TERINPUT RAPI per siswa dan dapat di-export lengkap ke Excel oleh Admin/Peneliti.",
        "Sesi terikat pada browser HP siswa."
    )

    pdf.option_box(
        "OPSI B: Login Akses Cepat via Kode Kelas / QR Code",
        "Guru membagikan Kode Kelas atau QR Code. Siswa membuka web lalu memasukkan Kode Kelas & No. Absen / Nama Singkat (tanpa password).",
        "Sangat terstruktur per sekolah & kelas. Jika siswa ganti HP, data dapat dibuka kembali hanya dengan memasukkan Kode Kelas & No. Absen.",
        "Membutuhkan pembuatan Kode Kelas oleh Guru/Admin terlebih dahulu."
    )

    pdf.option_box(
        "OPSI C: Akses Formulir Publik Bebas (Public Access)",
        "Menonaktifkan proteksi autentikasi pada seluruh fitur siswa.",
        "Akses tercepat tanpa rintangan awal.",
        "Fitur akumulasi harian (Leaderboard, Log Gula Berkelanjutan, dan Challenge) tidak dapat mencatat progres individu secara akurat."
    )

    # 3. Matriks Perbandingan
    pdf.section_title('3. MATRIKS PERBANDINGAN FITUR')
    
    # Table Header
    pdf.set_font('Helvetica', 'B', 8.5)
    pdf.set_fill_color(226, 232, 240)
    pdf.set_text_color(15, 23, 42)
    
    pdf.cell(50, 7, 'Kriteria Evaluasi', 1, 0, 'C', fill=True)
    pdf.cell(46, 7, 'Opsi A (Guest Auto-Session)', 1, 0, 'C', fill=True)
    pdf.cell(46, 7, 'Opsi B (Kode Kelas/QR)', 1, 0, 'C', fill=True)
    pdf.cell(48, 7, 'Opsi C (Publik Bebas)', 1, 1, 'C', fill=True)

    # Table Rows
    pdf.set_font('Helvetica', '', 8)
    rows = [
        ('Kemudahan Akses Siswa', 'Sangat Mudah (Tanpa Login)', 'Mudah (Input Kode Kelas)', 'Sangat Mudah'),
        ('Kualitas Data Riset Peneliti', 'Lengkap & Valid Per Siswa', 'Sangat Rapi per Kelas', 'Anonim / Terpisah'),
        ('Fitur Leaderboard & Poin', 'Berjalan di HP Siswa', 'Berjalan Penuh (Per Kelas)', 'Tidak Berkelanjutan'),
        ('Ekspor Data ke Excel', 'Tersedia Lengkap', 'Tersedia Lengkap', 'Terbatas')
    ]

    for row in rows:
        pdf.cell(50, 6, row[0], 1, 0, 'L')
        pdf.cell(46, 6, row[1], 1, 0, 'C')
        pdf.cell(46, 6, row[2], 1, 0, 'C')
        pdf.cell(48, 6, row[3], 1, 1, 'C')

    pdf.ln(4)

    # 4. Rekomendasi Tim Pengembang
    pdf.section_title('4. REKOMENDASI TIM PENGEMBANG')
    pdf.body_text(
        "Tim pengembang merekomendasikan OPSI A (Guest Auto-Session) atau OPSI B (Kode Kelas/QR). "
        "Kedua solusi ini berhasil memenuhi 100% arahan pimpinan untuk menghilangkan beban login siswa, "
        "sekaligus memastikan seluruh instrumen penelitian kesehatan SmartSip tetap dapat diolah dan di-export secara ilmiah."
    )

    output_path = "c:/laragon/www/smartsip/Analisis_Siswa_Tanpa_Login_SmartSip.pdf"
    pdf.output(output_path)
    print(f"PDF Output created successfully at: {output_path}")

    # Copy to public/panduan
    public_path = "c:/laragon/www/smartsip/public/panduan/Analisis_Siswa_Tanpa_Login_SmartSip.pdf"
    os.makedirs(os.path.dirname(public_path), exist_ok=True)
    shutil.copyfile(output_path, public_path)
    print(f"Copied PDF to public folder at: {public_path}")

if __name__ == '__main__':
    generate_pdf()
