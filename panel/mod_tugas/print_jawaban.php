<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");

$id_pengawas = $_SESSION['id_pengawas'] ?? 0;
if ($id_pengawas == 0) {
	header('location:login.php');
	exit;
}
$id_tugas = $_GET['id'] ?? 0;
if ($id_tugas == 0) {
	echo "ID Tugas tidak valid";
	exit;
}
$tugas = fetch($koneksi, 'tugas', ['id_tugas' => $id_tugas]);
$guru = fetch($koneksi, 'pengawas', ['id_pengawas' => $tugas['id_guru']]);
if (date('m') >= 7 and date('m') <= 12) {
	$ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
	$ajaran = (date('Y') - 1) . "/" . date('Y');
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>LAPORAN</title>
	<style>
		* {
			margin: auto;
			padding: 0;
			line-height: 100%;
		}

		body {
			max-width: 793.700787402px;
		}

		td {
			padding: 1px 3px 1px 3px;
		}

		.garis {
			border: 1px solid #000;
			border-left: 0px;
			border-right: 0px;
			padding: 1px;
			margin-top: 5px;
			margin-bottom: 5px;
		}
	</style>
</head>

<body>
	<div align='center'>
		<b>LAPORAN PENUGASAN SISWA</b><br />
		<b>MATA PELAJARAN <?= strtoupper($tugas['mapel']) ?></b><br />
		<b>TAHUN PELAJARAN <?= $ajaran ?></b><br />
	</div>
	<table border='1' width='100%' align='center' cellspacing='0' cellpadding='0' style="margin-top: 10px;">
		<tr>
			<td style="font-weight: bold;">
				Judul : <?= ucfirst(strtolower($tugas['judul'])) ?>
			</td>
		</tr>
	</table>
	<table border='1' width='100%' align='center' cellspacing='0' cellpadding='0' style="margin-top: 10px;">
		<thead>
			<tr>
				<th>No</th>
				<th>NIS</th>
				<th>Nama</th>
				<th>Kelas</th>
				<th>Nilai</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$tugasQ = select($koneksi, 'jawaban_tugas', ['id_tugas' => $id_tugas]);
			$no = 0;
			foreach ($tugasQ as $jtugas) {
				$no++;
				$siswa = fetch($koneksi, 'siswa', ['id_siswa' => $jtugas['id_siswa']]);
			?>
				<tr>
					<td align='center'><?= $no ?></td>
					<td align='center'><?= $siswa['nis'] ?></td>
					<td><?= $siswa['nama'] ?></td>
					<td align='center'><?= $siswa['id_kelas'] ?></td>
					<td align='center'><?= $jtugas['nilai'] ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<br />
	<table border='0' width='100%' align='center' cellspacing='0' cellpadding='0'>
		<tr>
			<td>
				Mengetahui, <br />
				Kepala Sekolah <br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<u><?= $setting['kepsek'] ?></u><br />
				NIP. <?= $setting['nip'] ?>
			</td>
			<td width='40%'>
				<?= ucfirst(strtolower($setting['kota'])); ?>, .................................<br />
				<!-- <?= tanggal_indo($tugas['tgl_selesai']) ?><br /> -->
				Guru Mapel<br />
				<br />
				<br />
				<br />
				<br />
				<u><?= $guru['nama'] ?></u><br />
				NIP. <?= $guru['nip'] ?>
			</td>
		</tr>
	</table>
</body>

</html>