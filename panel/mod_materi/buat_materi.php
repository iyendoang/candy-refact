<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
$id_mapel = addslashes($_POST['mapel']);
$id_guru = $_SESSION['id_pengawas'];
$materi = addslashes($_POST['isimateri']);
$judul = addslashes($_POST['judul']);
$tgl_mulai = $_POST['tgl_mulai'];
$youtube = $_POST['youtube'];
$kelas = serialize($_POST['kelas']);

$data = array(
    'mapel' => $id_mapel,
    'kelas' => $kelas,
    'id_guru' => $id_guru,
    'judul' => $judul,
    'materi' => $materi,
    'tgl_mulai' => $tgl_mulai,
    'youtube' => $youtube
);

if ($_FILES['file']['name'] <> '') {
    $ektensi = ['jpg', 'png', 'docx', 'pdf', 'xlsx', 'pptx', 'ppt', 'doc', 'wmv', 'mpg', 'mpeg', 'mp4'];
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext = explode('.', $file);
    $ext = strtolower(end($ext));
    if (in_array($ext, $ektensi)) {
        $dest = '../../berkas/';
        $path = $dest . $file;
        $upload = move_uploaded_file($temp, $path);
        if ($upload) {
            $data['file'] = $file;
        } else {
            echo "gagal";
            exit;
        }
    }
}

insert($koneksi, 'materi', $data);
echo "ok";
