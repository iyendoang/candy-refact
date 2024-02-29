<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$debe = 'candy_refactor';
$koneksi = mysqli_connect($host, $user, $pass, "");
if (!$koneksi) {
	die("Koneksi database gagal: " . mysqli_connect_error());
}
$pilihdb = mysqli_select_db($koneksi, $debe);
if (!$pilihdb) {
	die("Gagal memilih database: " . mysqli_error($koneksi));
}

$query = mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'");
if ($query) {
	$setting = mysqli_fetch_array($query);
	mysqli_set_charset($koneksi, 'utf8');
	date_default_timezone_set('Asia/Jakarta');	$sess = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM session WHERE id='1'"));
} else {
	die("Gagal mengambil data setting: " . mysqli_error($koneksi));
}
