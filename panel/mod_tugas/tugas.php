<?php defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); ?>
<?php if ($ac == '') { ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header with-border '>
                    <h3 class='box-title'> Daftar Tugas</h3>
                    <div class='box-tools pull-right '>
                    </div>
                </div>
                <div class='box-body'>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary mb-5" data-toggle="modal" data-target="#modaltugas">
                            <i class="fas fa-plus-circle"></i> Buat Tugas
                        </button>
                    </div>
                    <div class="modal fade" id="modaltugas" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formtugasadd">
                                    <div class="modal-body">
                                        <input type="hidden" class="form-control" name="id_mapel" value="<?= $id_mapel ?>">
                                        <div class="form-group">
                                            <select name='mapel' class='form-control' style='width:100%' required>
                                                <option value="">Pilih Mapel</option>
                                                <?php $que = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran"); ?>
                                                <?php while ($mapel = mysqli_fetch_array($que)) : ?>
                                                    <option value="<?= $mapel['nama_mapel'] ?>"><?= $mapel['nama_mapel'] ?></option>
                                                <?php endwhile ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="judul" aria-describedby="helpId" placeholder="Judul Tugas" required>
                                        </div>
                                        <div class="form-group">
                                            <textarea name='isitugas' class='editor1' rows='10' cols='80' style='width:100%;'></textarea>
                                        </div>
                                        <div class='form-group'>
                                            <div class='row'>
                                                <div class='col-md-4'>
                                                    <label>Pilih Kelas</label><br>
                                                    <select name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                                                        <option value='semua'>Semua</option>
                                                        <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
                                                        <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                                                            <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
                                                        <?php endwhile ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-4'>
                                                    <label>Tanggal Mulai</label>
                                                    <input type='text' name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' />
                                                </div>
                                                <div class='col-md-4'>
                                                    <label>Tanggal Selesai</label>
                                                    <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="file">File Pendukung</label>
                                            <input type="file" class="form-control-file" name="file" placeholder="" aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text text-muted">format file (doc/docx/xls/xlsx/pdf)</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id='tabletugas' class='table-responsive'>
                        <table id="example1" class='table table-bordered table-striped  table-hover'>
                            <thead>
                                <tr>
                                    <th width='5px'>#</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Judul Tugas</th>
                                    <th>Tgl Mulai</th>
                                    <th>Tgl Selesai</th>
                                    <th>Kelas</th>
                                    <th>File</th>
                                    <th width='200px'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pengawas['level'] == 'guru') {
                                    $tugasQ = mysqli_query($koneksi, "SELECT * FROM tugas where id_guru='$_SESSION[id_pengawas]'");
                                } else {
                                    $tugasQ = mysqli_query($koneksi, "SELECT * FROM tugas ");
                                }
                                ?>
                                <?php while ($tugas = mysqli_fetch_array($tugasQ)) : ?>
                                    <?php
                                    $guru = mysqli_fetch_array(mysqli_query($koneksi, "select * from pengawas where id_pengawas='$tugas[id_guru]'"));
                                    $no++
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td>
                                            <?= $tugas['mapel'] ?>
                                        </td>
                                        <td>
                                            <?= $guru['nama'] ?>
                                        </td>
                                        <td>
                                            <?= $tugas['judul'] ?>
                                        </td>

                                        <td style="text-align:center">
                                            <?= $tugas['tgl_mulai'] ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?= $tugas['tgl_selesai'] ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?php $kelas = unserialize($tugas['kelas']);
                                            foreach ($kelas as $kelas) {
                                                echo $kelas . " ";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($tugas['file'] <> '0') { ?>
                                                <a href="../berkas/<?= $tugas['file'] ?>" target="_blank">Lihat</a>
                                            <?php } ?>
                                        </td>
                                        <td style="text-align:center">
                                            <div class=''>
                                                <a href='?pg=tugas&ac=jawaban&id=<?= $tugas['id_tugas'] ?>' class='btn btn-sm btn-success '><i class='fas fa-eye'></i> Lihat</a>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modaledit<?= $tugas['id_tugas'] ?>">
                                                    <i class="fas fa-edit    "></i>
                                                </button>


                                                <button data-id='<?= $tugas['id_tugas'] ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt    "></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modaledit<?= $tugas['id_tugas'] ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="formedittugas<?= $tugas['id_tugas'] ?>">
                                                    <div class="modal-body">
                                                        <input type="hidden" value="<?= $tugas['id_tugas'] ?>" name='id'>
                                                        <div class="form-group">
                                                            <select name='mapel' class='form-control' style='width:100%' required>
                                                                <option value='<?= $tugas['mapel'] ?>' selected><?= $tugas['mapel'] ?></option>
                                                                <?php $que = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran"); ?>
                                                                <?php while ($mapel = mysqli_fetch_array($que)) : ?>
                                                                    <option value="<?= $mapel['nama_mapel'] ?>"><?= $mapel['nama_mapel'] ?></option>"
                                                                <?php endwhile ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="judul" aria-describedby="helpId" placeholder="Judul Tugas" value="<?= $tugas['judul'] ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea name='isitugas' class='editoredit<?= $tugas['id_tugas'] ?>' rows='10' cols='80' style='width:100%;'><?= $tugas['tugas'] ?></textarea>
                                                        </div>
                                                        <div class='form-group'>
                                                            <div class='row'>
                                                                <div class='col-md-4'>
                                                                    <label>Pilih Kelas</label><br>
                                                                    <select name='kelas[]' id="kelas-select<?= $tugas['id_materi'] ?>" class='form-control select2' style='width:100%' multiple required='true'>
                                                                        <option value='semua' <?= in_array('semua', unserialize($tugas['kelas'])) ? 'selected' : '' ?>>Semua</option>
                                                                        <?php
                                                                        $lev = mysqli_query($koneksi, "SELECT * FROM kelas");
                                                                        while ($kelas = mysqli_fetch_array($lev)) :
                                                                            $selected = in_array($kelas['id_kelas'], unserialize($tugas['kelas'])) ? 'selected' : '';
                                                                        ?>
                                                                            <option value="<?= $kelas['id_kelas'] ?>" <?= $selected ?>><?= $kelas['id_kelas'] ?></option>
                                                                        <?php endwhile ?>
                                                                    </select>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <label>Tanggal Mulai</label>
                                                                    <input type='text' name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' value="<?= $tugas['tgl_mulai'] ?>" />
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <label>Tanggal Selesai</label>
                                                                    <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' value="<?= $tugas['tgl_selesai'] ?>" />
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="file">File Pendukung</label>
                                                            <input type="file" class="form-control-file" name="file" id="file" placeholder="" aria-describedby="fileHelpId">
                                                            <small id="fileHelpId" class="form-text text-muted">format file (doc/docx/xls/xlsx/pdf)</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        tinymce.init({
                                            selector: '.editoredit<?= $tugas['id_tugas'] ?>',
                                            menubar: false,
                                            plugins: [
                                                'advlist autolink lists link charmap print preview hr anchor pagebreak',
                                                'searchreplace wordcount visualblocks visualchars code fullscreen',
                                                'insertdatetime media nonbreaking save table contextmenu directionality',
                                                'emoticons template paste textcolor colorpicker textpattern paste formula'
                                            ],
                                            toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist backcolor forecolor | formula code | link paste',
                                            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                                            paste_data_images: false,
                                            images_upload_handler: function(blobInfo, success, failure) {
                                                success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
                                            },
                                            image_class_list: [{
                                                title: 'Responsive',
                                                value: 'img-responsive'
                                            }],
                                            paste_data_image: false, // Mematikan paste gambar
                                            setup: function(editor) {
                                                editor.on('init', function() {
                                                    editor.on('change', function() {
                                                        changed = true; // Tandai perubahan saat terjadi event 'change'
                                                    });
                                                });

                                                editor.on('paste', function(e) {
                                                    var clipboard = e.clipboardData || window.clipboardData;
                                                    var items = clipboard.items;
                                                    for (var i = 0; i < items.length; i++) {
                                                        if (items[i].type.indexOf('image') !== -1) {
                                                            e.preventDefault();
                                                            return;
                                                        }
                                                    }
                                                });
                                                $('#formedittugas<?= $tugas['id_tugas'] ?>').submit(function(e) {
                                                    e.preventDefault();
                                                    var isitugasValue = editor.getContent();
                                                    var data = new FormData(this);
                                                    data.append('isitugas', isitugasValue);
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'mod_tugas/crud_tugas.php?pg=ubah',
                                                        enctype: 'multipart/form-data',
                                                        data: data,
                                                        cache: false,
                                                        contentType: false,
                                                        processData: false,
                                                        success: function(response) {
                                                            if (response == "ok") {
                                                                $('#modaledit<?= $tugas['id_tugas'] ?>').modal('hide');
                                                                iziToast.success({
                                                                    title: 'OKEY!',
                                                                    message: 'Tugas berhasil dirubah',
                                                                    position: 'topRight'
                                                                });
                                                                setTimeout(function() {
                                                                    window.location.reload();
                                                                }, 2000);
                                                            } else {
                                                                iziToast.error({
                                                                    title: 'Gagal!',
                                                                    message: response,
                                                                    position: 'topRight'
                                                                });
                                                            }
                                                        },
                                                        error: function(xhr, status, error) {
                                                            iziToast.error({
                                                                title: 'Error!',
                                                                message: 'Terjadi kesalahan. Silakan coba lagi.',
                                                                position: 'topRight'
                                                            });
                                                        }
                                                    });
                                                    return false;
                                                });
                                            }
                                        });
                                    </script>
                                <?php endwhile ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } elseif ($ac == 'jawaban') { ?>
    <?php $id = $_GET['id']; ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header with-border '>
                    <h3 class='box-title'> Daftar Jawaban Siswa</h3>
                    <div class='box-tools pull-right '>
                        <button onclick="frames['printtugas'].print()" class='btn btn-sm btn-flat btn-success'><i class='fa fa-print'></i> Print</button>
                        <iframe name='printtugas' src='mod_tugas/print_jawaban.php?id=<?= $id ?>' style='display:none'></iframe>
                    </div>
                </div>
                <div class='box-body' id="tablejawaban">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>File</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $jawabx = mysqli_query($koneksi, "select * from jawaban_tugas where id_tugas='$id'");
                            $no = 0;
                            while ($jawab = mysqli_fetch_array($jawabx)) {
                                $no++;
                                $siswa = fetch($koneksi, 'siswa', ['id_siswa' => $jawab['id_siswa']]);
                            ?>
                                <tr>
                                    <td scope="row"><?= $no ?></td>
                                    <td><?= $siswa['nama'] ?></td>
                                    <td><?= $siswa['id_kelas'] ?></td>
                                    <td>
                                        <?php if ($jawab['file'] <> null) { ?>
                                            <a href="../tugas/<?= $jawab['file'] ?>" target="_blank">Lihat</a>
                                        <?php } ?>
                                    </td>
                                    <td><?= $jawab['nilai'] ?></td>

                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalnilai<?= $no ?>">
                                            <i class="fas fa-edit    "></i> Input Nilai
                                        </button>
                                        <button data-id='<?= $jawab['id_jawaban'] ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt    "></i></button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalnilai<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form id="formEditNilai<?= $jawab['id_jawaban'] ?>">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" class="form-control" name="id_jawaban" value="<?= $jawab['id_jawaban'] ?>">
                                                            <div class="form-group">
                                                                <label for="nilai<?= $jawab['id_jawaban'] ?>">Input Nilai</label>
                                                                <input type="number" class="form-control" id="beri_nilai<?= $jawab['id_jawaban'] ?>" name="nilai" aria-describedby="helpId" placeholder="">
                                                                <small id="helpId" class="form-text text-muted">Masukkan nilai (hanya angka).</small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Jawaban Siswa</label>
                                                                <p><?= $jawab['jawaban'] ?></p>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <script>
                                                        $("#formEditNilai<?= $jawab['id_jawaban'] ?>").submit(function(e) {
                                                            e.preventDefault();
                                                            var beri_nilai = $('#beri_nilai<?= $jawab['id_jawaban'] ?>').val();
                                                            if (beri_nilai === '' || isNaN(beri_nilai)) {
                                                                alert('Masukkan hanya angka untuk nilai');
                                                                return false;
                                                            }

                                                            $.ajax({
                                                                type: "POST",
                                                                url: 'mod_tugas/crud_tugas.php?pg=simpan_nilai',
                                                                data: $(this).serialize(),
                                                                success: function(result) {
                                                                    $('#modaledit<?= $jawab['id_jawaban'] ?>').modal('hide');
                                                                    iziToast.success({
                                                                        title: 'OKEY!',
                                                                        message: 'Tugas berhasil dirubah',
                                                                        position: 'topRight'
                                                                    });
                                                                    setTimeout(function() {
                                                                        window.location.reload();
                                                                    }, 2000);
                                                                },
                                                                error: function(xhr, status, error) {
                                                                    iziToast.error({
                                                                        title: 'Gagal!',
                                                                        message: 'Tugas gagal dirubah',
                                                                        position: 'topRight'
                                                                    });
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    tinymce.init({
        selector: '.editor1',
        menubar: false,
        plugins: [
            'advlist autolink lists link charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern paste formula'
        ],
        toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist backcolor forecolor | formula code | link paste',
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        paste_data_images: false,
        images_upload_handler: function(blobInfo, success, failure) {
            success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
        },
        image_class_list: [{
            title: 'Responsive',
            value: 'img-responsive'
        }],
        setup: function(editor) {
            var changed = false; // Tambahkan variabel untuk menandai perubahan editor

            editor.on('init', function() {
                editor.on('change', function() {
                    changed = true; // Tandai perubahan saat terjadi event 'change'
                });
            });

            editor.on('paste', function(e) {
                var clipboard = e.clipboardData || window.clipboardData;
                var items = clipboard.items;
                for (var i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf('image') !== -1) {
                        e.preventDefault();
                        return;
                    }
                }
            });

            $('#formtugasadd').submit(function(e) {
                e.preventDefault();
                if (changed) { // Hanya submit jika ada perubahan pada editor
                    var isitugasValueAdd = tinymce.activeEditor.getContent();
                    var data = new FormData(this);
                    data.append('isitugas', isitugasValueAdd);
                    $.ajax({
                        type: 'POST',
                        url: 'mod_tugas/crud_tugas.php?pg=tambah',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#modaltugas').modal('hide');
                            if (response == 'ok') {
                                iziToast.success({
                                    title: 'OKEY!',
                                    message: 'Data berhasil disimpan',
                                    position: 'topRight'
                                });
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                iziToast.error({
                                    title: 'Maaf!',
                                    message: 'Tugas gagal dibuat',
                                    position: 'topRight'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    });
                }
            });
        }
    });

    $('#tabletugas').on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Apa anda yakin?',
            text: "akan menghapus tugas ini!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'mod_tugas/crud_tugas.php?pg=hapus_tugas',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        iziToast.success({
                            title: 'OKEY!',
                            message: 'Tugas berhasil dihapus',
                            position: 'topRight'
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                });
            }
        })
    });
    $('#tablejawaban').on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Apa anda yakin?',
            text: "akan menghapus nilai ini!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'mod_tugas/crud_tugas.php?pg=hapus_nilai',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        toastr.success('tugas berhasil dihapus');
                        $("#tablejawaban").load(window.location + " #tablejawaban");
                    }
                });
            }
        })
    });
</script>
<script>
    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });
</script>