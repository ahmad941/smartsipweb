import os
from fpdf import FPDF
from fpdf.enums import XPos, YPos

class SmartSipPDF(FPDF):
    def header(self):
        # Top Banner Navy Blue
        self.set_fill_color(30, 58, 138)  # Deep Navy
        self.rect(0, 0, 210, 24, 'F')
        
        self.set_font('Helvetica', 'B', 11)
        self.set_text_color(255, 255, 255)
        self.set_xy(12, 5)
        self.cell(186, 6, 'SMARTSIP WEB PLATFORM - DOKUMENTASI METODOLOGI RISET', new_x=XPos.LMARGIN, new_y=YPos.NEXT)
        
        self.set_font('Helvetica', '', 8.5)
        self.set_xy(12, 12)
        self.cell(186, 5, 'Perhitungan Rumus, Standar Kategori Gizi, dan Referensi Ilmiah Terakreditasi', new_x=XPos.LMARGIN, new_y=YPos.NEXT)
        
        self.set_y(28)

    def footer(self):
        self.set_y(-14)
        self.set_font('Helvetica', 'I', 8)
        self.set_text_color(148, 163, 184)
        self.cell(0, 8, f'SmartSip Web Platform | Dokumentasi Perhitungan Rumus | Halaman {self.page_no()}', new_x=XPos.RIGHT, new_y=YPos.TOP, align='C')

    def chapter_title(self, num, label):
        self.set_font('Helvetica', 'B', 10.5)
        self.set_fill_color(239, 246, 255)  # Light Ice Blue
        self.set_text_color(30, 58, 138)   # Dark Navy
        self.set_draw_color(191, 219, 254)
        self.cell(186, 7.5, f'  {num}. {label.upper()}', border=1, new_x=XPos.LMARGIN, new_y=YPos.NEXT, fill=True)
        self.ln(2)

    def body_text(self, text):
        self.set_font('Helvetica', '', 9)
        self.set_text_color(51, 65, 85)
        self.multi_cell(186, 4.8, text)
        self.ln(2)

    def formula_box(self, title, formula_str):
        self.set_fill_color(248, 250, 252) # Slate Light
        self.set_draw_color(226, 232, 240)
        start_y = self.get_y()
        self.rect(12, start_y, 186, 13.5, 'DF')
        
        self.set_xy(14, start_y + 1.2)
        self.set_font('Helvetica', 'B', 8)
        self.set_text_color(71, 85, 105)
        self.cell(182, 4, title, new_x=XPos.LMARGIN, new_y=YPos.NEXT)
        
        self.set_x(14)
        self.set_font('Courier', 'B', 9)
        self.set_text_color(15, 23, 42)
        self.cell(182, 5, formula_str, new_x=XPos.LMARGIN, new_y=YPos.NEXT)
        
        self.set_y(start_y + 16.5)

    def reference_box(self, refs):
        self.set_font('Helvetica', 'B', 8.5)
        self.set_text_color(15, 118, 110) # Teal Dark
        self.cell(186, 5, 'Standard & Referensi Ilmiah:', new_x=XPos.LMARGIN, new_y=YPos.NEXT)
        
        self.set_font('Helvetica', '', 8)
        self.set_text_color(71, 85, 105)
        for ref in refs:
            self.set_x(12)
            self.multi_cell(186, 4.2, f"- {ref}")
        self.ln(3)

def generate_pdf():
    pdf = SmartSipPDF(orientation='P', unit='mm', format='A4')
    pdf.set_margins(12, 12, 12) # Left: 12mm, Top: 12mm, Right: 12mm. EPW = 186mm
    pdf.add_page()
    pdf.set_auto_page_break(auto=True, margin=15)

    # Date info
    pdf.set_font('Helvetica', 'I', 8)
    pdf.set_text_color(100, 116, 139)
    pdf.cell(186, 4, 'Tanggal: 16 Agustus 2026 | Versi Dokumen: 2.0 (Final Re-Formatted)', new_x=XPos.LMARGIN, new_y=YPos.NEXT, align='R')
    pdf.ln(2)

    # 1. IMT / BMI
    pdf.chapter_title(1, 'Indeks Massa Tubuh (IMT / BMI)')
    pdf.body_text(
        "Indeks Massa Tubuh (IMT) digunakan untuk mengukur status gizi fisik dan antropometri responden siswa "
        "berdasarkan rasio berat badan terhadap kuadrat tinggi badan."
    )
    pdf.formula_box(
        "RUMUS PERHITUNGAN IMT:",
        "BMI = Berat_Badan (kg) / ( Tinggi_Badan (cm) / 100 ) ^ 2"
    )
    pdf.reference_box([
        "Permenkes RI No. 2 Tahun 2020 tentang Standar Antropometri Anak (IMT/U Usia 5-18 Tahun).",
        "WHO Technical Report Series 854: Physical Status: The Use and Interpretation of Anthropometry."
    ])

    # 2. Semi-Quantitative FFQ
    pdf.chapter_title(2, 'Asupan Gula Harian (Semi-Quantitative FFQ)')
    pdf.body_text(
        "Survei Food Frequency Questionnaire (FFQ) mengukur estimasi konsumsi gula harian responden dari 20 jenis "
        "minuman manis standar baku selama 7 hari terakhir."
    )
    pdf.formula_box(
        "RUMUS ESTIMASI ASUPAN GULA HARIAN (SQ-FFQ):",
        "Total Gula (g/hari) = SUM[ Porsi_ml * (Gula_100ml / 100) * Faktor_Frekuensi_Harian ]"
    )
    
    # Table Frekuensi (Total Width = 186mm: 20 + 66 + 50 + 50)
    pdf.set_font('Helvetica', 'B', 8)
    pdf.set_fill_color(241, 245, 249)
    pdf.set_text_color(30, 41, 59)
    pdf.cell(20, 5.5, 'Kode', border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='C', fill=True)
    pdf.cell(66, 5.5, 'Frekuensi Konsumsi 7 Hari', border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='L', fill=True)
    pdf.cell(50, 5.5, 'Rata-rata / Minggu', border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='C', fill=True)
    pdf.cell(50, 5.5, 'Faktor Harian (f)', border=1, new_x=XPos.LMARGIN, new_y=YPos.NEXT, align='C', fill=True)

    pdf.set_font('Helvetica', '', 8)
    freq_data = [
        ("0", "Tidak Pernah", "0 hari / minggu", "0.000"),
        ("1", "1 - 2 kali per minggu", "1.5 hari / minggu", "1.5 / 7 = 0.214"),
        ("2", "3 - 4 kali per minggu", "3.5 hari / minggu", "3.5 / 7 = 0.500"),
        ("3", "5 - 6 kali per minggu", "5.5 hari / minggu", "5.5 / 7 = 0.786"),
        ("4", "Setiap hari", "7.0 hari / minggu", "1.000"),
    ]
    for code, desc, avg, factor in freq_data:
        pdf.cell(20, 5, code, border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='C')
        pdf.cell(66, 5, desc, border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='L')
        pdf.cell(50, 5, avg, border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='C')
        pdf.cell(50, 5, factor, border=1, new_x=XPos.LMARGIN, new_y=YPos.NEXT, align='C')
    pdf.ln(3)

    # Table Kategori Gula (Total Width = 186mm: 36 + 50 + 100)
    pdf.set_font('Helvetica', 'B', 8)
    pdf.set_fill_color(241, 245, 249)
    pdf.cell(36, 5.5, 'Kategori Gula', border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='L', fill=True)
    pdf.cell(50, 5.5, 'Batas Asupan (g/hari)', border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='C', fill=True)
    pdf.cell(100, 5.5, 'Keterangan Standar Kesehatan', border=1, new_x=XPos.LMARGIN, new_y=YPos.NEXT, align='L', fill=True)

    pdf.set_font('Helvetica', '', 8)
    cat_data = [
        ("Baik", "< 25 gram / hari", "Memenuhi rekomendasi ideal WHO (< 5% energi harian)."),
        ("Sedang", "25 - 50 gram / hari", "Batas sedang toleransi konsumsi gula harian."),
        ("Tinggi", "> 50 gram / hari", "Melebihi Batas Maksimum Konsumsi Gula Kemenkes RI."),
    ]
    for cat, limit, note in cat_data:
        pdf.cell(36, 5, cat, border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='L')
        pdf.cell(50, 5, limit, border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='C')
        pdf.cell(100, 5, note, border=1, new_x=XPos.LMARGIN, new_y=YPos.NEXT, align='L')
    pdf.ln(3)

    pdf.reference_box([
        "WHO Guideline (2015): Sugars intake for adults and children. World Health Organization, Geneva.",
        "Permenkes RI No. 30 Tahun 2013: Batas maksimal konsumsi gula harian per orang adalah 50 gram.",
        "Gibson, R. S. (2005): Principles of Nutritional Assessment (2nd ed.). Oxford University Press."
    ])

    # 3. Pengetahuan Konsumsi Gula
    pdf.chapter_title(3, 'Pengetahuan Konsumsi Gula (Knowledge Score)')
    pdf.body_text(
        "Kuesioner pengetahuan gizi terdiri dari 10 soal pilihan ganda (skor total 0 - 10). Setiap jawaban benar "
        "bernilai 1, dan salah bernilai 0."
    )
    pdf.formula_box(
        "RUMUS SKOR PENGETAHUAN GULA:",
        "Skor Pengetahuan = SUM[ Jawaban_Benar (1 Poin) ]  (Maksimal 10 Poin)"
    )

    # Table Knowledge (Total Width = 186mm: 36 + 50 + 100)
    pdf.set_font('Helvetica', 'B', 8)
    pdf.set_fill_color(241, 245, 249)
    pdf.cell(36, 5.5, 'Kategori', border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='L', fill=True)
    pdf.cell(50, 5.5, 'Syarat Skor', border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='C', fill=True)
    pdf.cell(100, 5.5, 'Persentase Nilai', border=1, new_x=XPos.LMARGIN, new_y=YPos.NEXT, align='C', fill=True)

    pdf.set_font('Helvetica', '', 8)
    know_data = [
        ("Baik", "8 - 10 Soal Benar", "80% - 100%"),
        ("Cukup", "6 - 7 Soal Benar", "60% - 70%"),
        ("Kurang", "< 6 Soal Benar", "< 60%"),
    ]
    for k_cat, k_score, k_pct in know_data:
        pdf.cell(36, 5, k_cat, border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='L')
        pdf.cell(50, 5, k_score, border=1, new_x=XPos.RIGHT, new_y=YPos.TOP, align='C')
        pdf.cell(100, 5, k_pct, border=1, new_x=XPos.LMARGIN, new_y=YPos.NEXT, align='C')
    pdf.ln(3)

    pdf.reference_box([
        "Arikunto, S. (2010): Prosedur Penelitian Suatu Pendekatan Praktik. Jakarta: Rineka Cipta."
    ])

    # 4. TPB
    pdf.chapter_title(4, 'Theory of Planned Behavior (TPB)')
    pdf.body_text(
        "Kuesioner TPB mengukur 4 domain psikologi perilaku (Attitude, Subjective Norm, Perceived Behavioral Control, "
        "dan Intention) menggunakan Skala Likert 5 Tingkat (1 = Sangat Tidak Setuju s/d 5 = Sangat Setuju)."
    )
    pdf.reference_box([
        "Ajzen, I. (1991): The Theory of Planned Behavior. Organizational Behavior and Human Decision Processes.",
        "Ajzen, I. (2006): Constructing a Theory of Planned Behavior Questionnaire. University of Massachusetts."
    ])

    # 5. SUS Usability
    pdf.chapter_title(5, 'Evaluasi Usability Aplikasi (System Usability Scale - SUS)')
    pdf.body_text(
        "Kuesioner SUS mengukur tingkat kebergunaan aplikasi SmartSip dengan 10 instrumen standar. "
        "Kategori: Sangat Baik (41-50), Baik (31-40), Cukup (21-30), Kurang (<21)."
    )
    pdf.reference_box([
        "Brooke, J. (1996): SUS-A quick and dirty usability scale. Usability Evaluation in Industry."
    ])

    # 6. Gamifikasi
    pdf.chapter_title(6, 'Sistem Gamifikasi & Reward Poin')
    pdf.body_text(
        "Poin gamifikasi diberikan untuk meningkatkan keterlibatan siswa: Kuesioner Awal Publik T0 (+60 Poin), "
        "Kuesioner per fase (+20 Poin per kuesioner), Evaluasi Usability SUS (+30 Poin)."
    )
    pdf.reference_box([
        "Chou, Y. K. (2015): Actionable Gamification: Beyond Points, Badges, and Leaderboards. Octalysis Media."
    ])

    # Output path
    output_dir = os.path.join(os.getcwd(), 'document')
    os.makedirs(output_dir, exist_ok=True)
    primary_path = os.path.join(output_dir, 'Dokumentasi_Perhitungan_Rumus_SmartSip.pdf')
    fallback_path = os.path.join(output_dir, 'Dokumentasi_Perhitungan_Rumus_SmartSip_Fix.pdf')
    
    try:
        pdf.output(primary_path)
        print(f"PDF successfully re-generated without clipping at: {primary_path}")
    except PermissionError:
        pdf.output(fallback_path)
        print(f"Primary file was locked. PDF saved without clipping at: {fallback_path}")

if __name__ == '__main__':
    generate_pdf()

