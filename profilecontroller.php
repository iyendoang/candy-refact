<?php
// profilecontroller.php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");
cek_session_siswa();
$id = isset($_POST['idu']) ? $_POST['idu'] : '';
if ($id != '') {
    $hp = isset($_POST['hp']) ? $_POST['hp'] : '';
    $pass1 = isset($_POST['pass1']) ? $_POST['pass1'] : '';
    $pass2 = isset($_POST['pass2']) ? $_POST['pass2'] : '';
    if ($pass1 != '' && $pass1 == $pass2) {
        $data = [
            'hp' => $hp
        ];
        if ($pass2 != '') {
            $data['password'] = $pass1;
        }
        $exec = update($koneksi, 'siswa', $data, ['id_siswa' => $id]);
        if ($exec) {
            echo 'OK';
        } else {
            echo 'Gagal melakukan pembaruan profil';
        }
    } else {
        echo "Password tidak boleh kosong dan harus sama dengan konfirmasi password";
    }
} else {
    echo "ID siswa tidak valid";
}
