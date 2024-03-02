<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");

if (isset($_GET['pg']) && $_GET['pg'] == 'insert') {
    $judul = $_POST['judul'];
    $pengumuman = $_POST['pengumuman'];
    $tipe = $_POST['tipe'];
    $exec = false; // inisialisasi variabel $exec
    if (!empty($_FILES['photo']['name'])) {
        $ektensi = ['jpg', 'png'];
        $photo = $_FILES['photo']['name'];
        $temp = $_FILES['photo']['tmp_name'];
        $ext = pathinfo($photo, PATHINFO_EXTENSION);
        if (in_array($ext, $ektensi)) {
            $dest = 'foto/pengumuman/' . rand(1, 100000) . '.' . $ext;
            $upload = move_uploaded_file($temp, '../../' . $dest);
            if ($upload) {
                $exec = mysqli_query($koneksi, "INSERT INTO pengumuman (judul, text, user, type, photo) VALUES ('$judul', '$pengumuman', '$pengawas[id_pengawas]', '$tipe', '$dest')");
                if (!$exec) {
                    echo "Gagal menyimpan pengumuman.";
                }
            } else {
                echo "Gagal mengupload foto.";
            }
        } else {
            echo "Ekstensi file tidak valid.";
        }
    } else {
        $exec = mysqli_query($koneksi, "INSERT INTO pengumuman (judul, text, user, type) VALUES ('$judul', '$pengumuman', '$pengawas[id_pengawas]', '$tipe')");
        if (!$exec) {
            echo "Gagal menyimpan pengumuman.";
        }
    }

    if ($exec) {
        // Tampilkan success message atau lakukan aksi lainnya
        echo "Data berhasil disimpan.";
    } else {
        // Tampilkan error message atau lakukan aksi lainnya
        echo "Terjadi kesalahan saat menyimpan pengumuman.";
    }
}
?>
