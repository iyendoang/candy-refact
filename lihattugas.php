<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
$ac = dekripsi($ac);
echo $ac;
$tugas = mysqli_fetch_array(mysqli_query($koneksi, "select * from tugas where id_tugas='$ac'"))
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'><i class="fas fa-file-signature"></i> Detail Tugas Siswa</h3>
            </div>
            <div class='box-body'>
                <table class='table table-bordered table-striped'>
                    <tr>
                        <th width='150'>Mata Pelajaran</th>
                        <td width='10'>:</td>
                        <td><?= $tugas['mapel'] ?></td>
                    </tr>
                    <tr>
                        <th>Tgl Mulai</th>
                        <td width='10'>:</td>
                        <td><?= $tugas['tgl_mulai'] ?></td>
                    </tr>
                    <tr>
                        <th>Tgl Selesai</th>
                        <td width='10'>:</td>
                        <td><?= $tugas['tgl_selesai'] ?></td>
                    </tr>
                </table>
                <br>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bolder;">Materi & Soal</a></li>
                        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="font-weight: bolder;">Kirim Jawaban</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <?php if ($tugas['file'] <> null) { ?>
                            <?php } ?>
                            <center>
                                <h3><?= $tugas['judul'] ?></h3>
                            </center>
                            <p><?= $tugas['tugas'] ?></p>
                            <div class="row" style="margin-top: 20px; margin-left: 1px">
                                Download Materi Pendukung <br>
                                <a target="_blank" href='<?= $homeurl ?>/berkas/<?= $tugas['file'] ?>' class="btn btn-primary"><?= $tugas['file'] ?></a>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <?php
                            $kondisi = array(
                                'id_siswa' => $_SESSION['id_siswa'],
                                'id_tugas' => $tugas['id_tugas']
                            );
                            $jawab_tugas = fetch($koneksi, 'jawaban_tugas', $kondisi);
                            if ($jawab_tugas) {
                                $jawaban = $jawab_tugas['jawaban'];
                            } else {
                                $jawaban = "";
                            }
                            ?>
                            <?php if ($jawab_tugas['nilai'] <> '') { ?>
                                <div class="alert alert-success" role="alert">
                                    <strong>Jawaban telah dikoreksi dan dinilai</strong>
                                </div>
                                <h1>Nilai Kamu : <?= $jawab_tugas['nilai'] ?></h1>
                            <?php } else { ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Kerjakan dengan baik dan teliti.</strong>
                                </div>
                                <form id='formjawaban'>
                                    <input type="hidden" name="id_tugas" value="<?= $tugas['id_tugas'] ?>">
                                    <div class="form-group">
                                        <label for="">Lembar Jawaban</label>
                                        <textarea class="form-control" name="jawaban" id="txtjawaban" rows="10"><?= $jawaban ?></textarea>
                                    </div>
                                    <?php if ($jawab_tugas['file'] == '') { ?>
                                        <div class="form-group">
                                            <label for="">Upload Jawaban</label>
                                            <input type="file" class="form-control-file" name="file" aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text text-muted">jika jawaban diupload</small>
                                        </div>
                                    <?php } else { ?>

                                        <div class="alert alert-success" role="alert">
                                            <strong>file jawaban berhasil dikirim</strong>
                                            <a href='<?= $homeurl ?>/tugas/<?= $jawab_tugas['file'] ?>' target="_blank">Lihat file</a>
                                        </div>

                                    <?php  } ?>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                                    </div>
                                </form>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#formjawaban').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        var homeurl = '<?= $homeurl ?>';
        $.ajax({
            type: 'POST',
            url: homeurl + '/simpantugas.php',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data = 'ok') {
                    toastr.success("jawaban berhasil dikirim");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    toastr.error("jawaban gagal dikirim");
                }
            }
        });
        return false;
    });
</script>