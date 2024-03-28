<?php
// config.database.php";
$host = 'localhost';
$user = 'root';
$pass = '';
// $debe = 'candy_refactor';
$debe = 'candy_test';
$koneksi = mysqli_connect($host, $user, $pass, "");
if ($koneksi) {
	$pilihdb = mysqli_select_db($koneksi, $debe);
	if ($pilihdb) {
		$query = mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'");
		if ($query) {
			$setting = mysqli_fetch_array($query);
			mysqli_set_charset($koneksi, 'utf8');
			$sess = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM session WHERE id='1'"));
			date_default_timezone_set($setting['waktu']);
			$avatar ='dist/img/avatar_default.jpg';
			$logo = $setting['logo'] != null ? $setting['logo'] : 'dist/img/book.ico';
			$image_background =  $setting['bc'] != null ? $setting['bc'] : './dist/img/bc.jpg';
		}
	}
}
