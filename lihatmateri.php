<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
$ac = dekripsi($ac);
echo $ac;
$materi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM materi WHERE id_materi='$ac'"));
function youtube($url)
{
    $link = str_replace('http://www.youtube.com/watch?v=', '', $url);
    $link = str_replace('https://www.youtube.com/watch?v=', '', $link);
    $data = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/' . $link . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    return $data;
}
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'><i class="fas fa-file-signature    "></i> Detail materi Siswa</h3>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <table class='table table-bordered table-striped'>
                    <tr>
                        <th width='150'>Mata Pelajaran</th>
                        <td width='10'>:</td>
                        <td><?= $materi['mapel'] ?></td>
                    </tr>
                    <tr>
                        <th>Tgl Publish</th>
                        <td width='10'>:</td>
                        <td><?= $materi['tgl_mulai'] ?></td>
                    </tr>
                </table>
                <center>
                    <div class="callout">
                        <strong>
                            <h3><?= $materi['judul'] ?></h3>
                        </strong>
                    </div>
                </center>
                <?php if ($materi['youtube'] <> null) {  ?>
                    <div class="col-md-3"></div>
                    <div class="callout col-md-6">
                        <?= youtube($materi['youtube']) ?>
                    </div>
                    <div class="col-md-3"></div>
                <?php } ?>
                <div class="col-md-12" style="font-size: 11pt;">
                    <?= $materi['materi'] ?>
                </div>
                <div class="col-md-12" style="font-size: 11pt; margin-top: 10px">
                    <?php if ($materi['file'] <> null) { ?>
                        Download Materi Pendukung <br>
                        <a target="_blank" href='<?= $homeurl ?>/berkas/<?= $materi['file'] ?>' class="btn btn-primary"><?= $materi['file'] ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>