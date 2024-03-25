<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<link rel='stylesheet' href='<?= $homeurl ?>/plugins/datatables/dataTables.bootstrap.css' />
<link rel='stylesheet' href='<?= $homeurl ?>/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css' />
<link rel='stylesheet' href='<?= $homeurl ?>/plugins/datatables/extensions/Select/css/select.bootstrap.css' />
<script src='<?= $homeurl ?>/plugins/datatables/jquery.dataTables.min.js'></script>
<script src='<?= $homeurl ?>/plugins/datatables/dataTables.bootstrap.min.js'></script>
<script src='<?= $homeurl ?>/plugins/datatables/extensions/Select/js/dataTables.select.min.js'></script>
<script src='<?= $homeurl ?>/plugins/datatables/extensions/Select/js/select.bootstrap.min.js'></script>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'><i class="fas fa-edit"></i> Materi Siswa</h3>
            </div>
            <!-- <div class='box-body'>
                <?php
                $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$_SESSION[id_siswa]'"));
                $mapelQ = mysqli_query($koneksi, "SELECT * FROM materi");
                ?>
                <?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
                    <?php
                    if ($mapel['tgl_mulai'] < date('Y-m-d H:i:s')) {
                        $datakelas = unserialize($mapel['kelas']);
                        $guru = fetch($koneksi, 'pengawas', ['id_pengawas' => $mapel['id_guru']]);
                    ?>
                        <?php if (in_array($siswa['id_kelas'], $datakelas) or in_array('semua', $datakelas)) :
                            $warna = array('bg-red', 'bg-blue',  'bg-green', 'bg-gray', 'bg-purple');
                        ?>
                            <div class="col-md-4">
                                <a href="<?= $homeurl . '/lihatmateri/' . enkripsi($mapel['id_materi']) ?>">
                                    <div class="box box-widget widget-user-2">
                                        <div class="widget-user-header <?= $warna[rand(0, count($warna) - 1)] ?> " style="padding: 6px">
                                            <div class="widget-user-image">
                                                <img src="dist/img/soal.png" alt="">
                                            </div>
                                            <span style="font-size: 20px"> <b>
                                                    <?php
                                                    if (strlen($mapel['mapel']) > 30) {
                                                        echo substr($mapel['mapel'], 0, 30) . "...";
                                                    } else {
                                                        echo $mapel['mapel'];
                                                    }
                                                    ?>
                                                </b></span>
                                            <p>Guru : <?= $guru['nama'] ?></p>
                                            <?= $mapel['tgl_mulai'] ?>
                                        </div>
                                        <div class="box-footer">
                                            <center style="font-weight: bold; font-size: 14px; color: black">
                                               <?= $mapel['judul'] ?>
                                            </center>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php } ?>
                <?php endwhile; ?>
            </div> -->
            <div class='box-body'>
                <?php
                $no = 1;
                $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$_SESSION[id_siswa]'"));
                $mapelQ = mysqli_query($koneksi, "SELECT * FROM materi ORDER BY id_materi DESC");
                ?>
                <table id="example1" class='table table-bordered table-striped  table-hover'>
                    <thead>
                        <tr>
                            <th style="width: 3px;">No</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Tanggal Mulai</th>
                            <th>Judul</th>
                            <th style="text-align: center;">Lihat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
                            <?php
                            if ($mapel['tgl_mulai'] < date('Y-m-d H:i:s')) {
                                $datakelas = unserialize($mapel['kelas']);
                                $guru = fetch($koneksi, 'pengawas', ['id_pengawas' => $mapel['id_guru']]);
                            ?>
                                <?php if (in_array($siswa['id_kelas'], $datakelas) or in_array('semua', $datakelas)) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= strlen($mapel['mapel']) > 30 ? substr($mapel['mapel'], 0, 30) . "..." : $mapel['mapel'] ?></td>
                                        <td><?= $guru['nama'] ?></td>
                                        <td><?= $mapel['tgl_mulai'] ?></td>
                                        <td><?= $mapel['judul'] ?></td>
                                        <td style="text-align: center;">
                                            <a href="<?= $homeurl . '/lihatmateri/' . enkripsi($mapel['id_materi']) ?>">
                                                <button class='btn btn-sm btn-success'><i class='fa fa-search'></i> Lihat</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php } ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#example1').DataTable({
            select: true
        });
        // Filter pada kolom "Mapel" dengan dropdown select
        var table = $('#example1').DataTable();
        var mapelOptions = [];
        table.column(1).data().unique().sort().each(function(value, index) {
            mapelOptions.push(value);
        });
        var select = $('<select class="form-control form-control-sm" style="margin: 5px"><option value="">Pilih Mapel</option></select>')
            .appendTo($('#example1_filter'))
            .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );
                table.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
            });
        $.each(mapelOptions, function(i, item) {
            select.append('<option value="' + item + '">' + item + '</option>')
        });
    });
</script>