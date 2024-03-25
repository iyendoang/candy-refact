# candycbt
Merupakan aplikasi untuk ujian berbasis komputer 
bisa digunakan untuk PTS/PAS/USBN/SIMULASIUNBK

Repack Candy CBT

Thanks For Web Candy http://candycbt.id
SEMOGA BERMANFAAT

# FIX BUGS

Fix selesai pada status peserta di hasil nilai di admin
Fix selesai pada status peserta di jadwal di admin
Fix selesai pada status peserta di menu di admin

Fix selesai pada status peserta di hasil nilai di guru
Fix selesai pada status peserta di jadwal di guru
Fix selesai pada status peserta di menu di guru

Penambahan upload gambar pada pengumuman

FIX text editor tidak bisa upload gambar pada pengumuman

Penambahan kolom kementerian pada setting lembaga

FIX Kartu peserta

FIX Berita Acara

Penambahan Kolom Nilai Essai pada view dan eksport excel dan pada semua nilai

Perbaikan Edit essai dengan validasi nilai

Edit jadwal ujian ketika hasil tampil siswa dan perubahan tampilan hasil pada akun siswa

FIX Agama pada peserta, Banksoal dan ujian

Penambahan Validasi Banksoal Ketika jadwal berlangsung

FIX Copy Bank Soal

Penambahan Validasi pada tambah dan edit banksoal dibobot nilai harus 100%
Penambahan validasi jumlah soal PG/Essai tidak boleh melebihi soal tampil
Hapus Image pada table banksoal

Perbaikan pada penamaan title input edit imort banksoal

Penambahan .env pada aplikasi

Penambahan Elearning
Materi dan tugas baik di admin, guru dan siswa

ALTER TABLE `server` ADD UNIQUE(`kode_server`); 
[2.59 PM, 25/3/2024] Iyen: 
ALTER TABLE materi CHANGE judul judul VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
[3.01 PM, 25/3/2024] Iyen: 
ALTER TABLE tugas CHANGE judul judul VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;