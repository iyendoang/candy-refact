<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>

<?php if ($ac == '') : ?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'><i class="fas fa-file-signature fa-fw   "></i> DATA UJIAN</h3>
					<div class='box-tools pull-right btn-group'>
					</div>
				</div>
				<div class='box-body'><?= $info ?>
					<div class='form-group'>
						<div class='row'>
							<div class='col-md-4'>
								<label>Pilih Jenis Penilaian</label>
								<select id='jenisuk' class='select2 form-control' required='true'>
									<?php $jq = mysqli_query($koneksi, "SELECT * FROM jenis");
									while ($jenis = mysqli_fetch_array($jq)) : ?>
										<option value='<?= $jenis['id_jenis'] ?>'><?= $jenis['nama'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
							<div class='col-md-4'>
								<label>Pilih Kelas</label>
								<?php if ($pengawas['level'] == 'admin') { ?>
									<select id='kelasuk' class='select2 form-control' required='true'>
										<?php $jq = mysqli_query($koneksi, "SELECT * FROM kelas");
										while ($kelas = mysqli_fetch_array($jq)) : ?>
											<option value='<?= $kelas['id_kelas'] ?>'><?= $kelas['nama'] ?></option>
										<?php endwhile; ?>
									</select>
								<?php } else { ?>
								<input type="text" id="kelasuk" value="<?= $pengawas['jabatan'] ?>" class="form-control" readonly>
								<?php } ?>
							</div>
							<div class='col-md-4'>
								<p style="margin-bottom: 20px;"></p>
								<button type="button" id="btncari" class="btn btn-primary"><span class="fa fa-search"></span> Cari</button>
							</div>
						</div>
					</div>
					<script>
						document.getElementById('btncari').addEventListener('click', function() {
							var jenis = document.getElementById('jenisuk').value;
							var kelas = document.getElementById('kelasuk').value;
							var url = '?pg=<?= $pg ?>&ac=lihat&idk=' + encodeURIComponent(kelas) + '&idj=' + encodeURIComponent(jenis);
							window.location.href = url;
						});
					</script>
				</div>
			</div>
		</div>
	<?php elseif ($ac == 'lihat') : ?>
		<?php
		$id_kelas = $_GET['idk'];
		$id_penilaian = $_GET['idj'];
		$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel")); ?>
		<div class='row'>
			<div class='col-md-12'>
				<div class='box box-solid'>
					<div class='box-header with-border'>
						<h3 class='box-title'>
							<a href="?pg=semuanilai" class="btn btn-sm btn-warning me-1">
								<i class="fa fa-arrow-left"></i>
							</a>
							REKAP NILAI KELAS <?= $id_kelas ?>
						</h3>
						<div class='box-tools pull-right'>
							<a class='btn btn-sm btn-primary' href='mod_nilai/report_excel_all.php?k=<?= $id_kelas ?>&idj=<?= $id_penilaian ?>'><i class='fa fa-download'></i> Excel</a>
						</div>
					</div>
					<div class='box-body'>
						<div class='table-responsive'>
							<table id='example' class='table table-bordered table-striped'>
								<thead>
									<tr>
										<th rowspan='3' style="vertical-align:middle; width:5px">#</th>
										<th style='text-align:center;vertical-align:middle' rowspan='3'>No Peserta</th>
										<th style='text-align:center;vertical-align:middle' rowspan='3'>Nama Peserta</th>
										<th style='text-align:center;vertical-align:middle' rowspan='3'>Kelas</th>
										<?php
										$kodeujian = mysqli_fetch_array(mysqli_query($koneksi, "select * from jenis where status='aktif'"));
										$mapelQ = mysqli_query($koneksi, "SELECT a.kode, b.id_mapel, a.nama
									FROM mapel a
									JOIN nilai b ON a.id_mapel = b.id_mapel
									WHERE b.kode_ujian = '$id_penilaian'
									AND (a.kelas LIKE '%\"$id_kelas\"%' OR a.kelas LIKE '%\"semua\"%') GROUP BY b.id_mapel ");
										while ($mapel = mysqli_fetch_array($mapelQ)) :
											echo "<th style='text-align:center' colspan='4'>" . strtoupper($mapel['kode']) . "-$mapel[nama]</th>";
										endwhile;
										?>
									</tr>
									<tr>
										<?php
										$kode = mysqli_query($koneksi, "SELECT * FROM mapel a JOIN nilai b ON a.id_mapel=b.id_mapel WHERE b.kode_ujian = '$id_penilaian'
										AND (a.kelas LIKE '%\"$id_kelas\"%' OR a.kelas LIKE '%\"semua\"%') GROUP BY b.id_mapel ");
										while ($mapel = mysqli_fetch_array($kode)) :
											echo "<th style='text-align:center' colspan='4'>$mapel[kode_ujian]</th>";
										endwhile;
										?>
									</tr>
									<tr>
										<?php $mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel a JOIN nilai b ON a.id_mapel=b.id_mapel where b.kode_ujian='$id_penilaian' AND (a.kelas LIKE '%\"$id_kelas\"%' OR a.kelas LIKE '%\"semua\"%')  GROUP BY b.id_mapel "); ?>
										<?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
											<th style='text-align:center'>B</th>
											<th style='text-align:center'>S</th>
											<th style='text-align:center'>Essai</th>
											<th style='text-align:center'>SKOR</th>
										<?php endwhile; ?>
									</tr>
								</thead>
								<tbody>
									<?php $siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$id_kelas' ORDER BY nama ASC"); ?>
									<?php while ($siswa = mysqli_fetch_array($siswaQ)) : ?>
										<?php
										$no++;
										$ket = '';
										$esai = $lama = $jawaban = $skor = $total = '--';
										?>
										<tr>
											<td><?= $no ?></td>
											<td style="text-align:center"><?= $siswa['no_peserta'] ?></td>
											<td><?= $siswa['nama'] ?></td>
											<td style="text-align:center"><?= $siswa['id_kelas'] ?></td>
											<?php $mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel a JOIN nilai b ON a.id_mapel=b.id_mapel where b.kode_ujian='$id_penilaian' AND (a.kelas LIKE '%\"$id_kelas\"%' OR a.kelas LIKE '%\"semua\"%')  GROUP BY b.id_mapel "); ?>
											<?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
												<?php
												$nilaiQ = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_mapel='$mapel[id_mapel]' AND id_siswa='$siswa[id_siswa]' ");
												$nilaiC = mysqli_num_rows($nilaiQ);
												$nilai = mysqli_fetch_array($nilaiQ);
												?>
												<td style="text-align:center"><?= $nilai['jml_benar'] ?></td>
												<td style="text-align:center"><?= $nilai['jml_salah'] ?></td>
												<td style="text-align:center"><?= $nilai['nilai_esai'] ?></td>
												<td style="text-align:center"><?= number_format($nilai['total'], 2) ?></td>
											<?php endwhile; ?>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>