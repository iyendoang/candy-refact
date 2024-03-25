<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'>
                    <i class="fas fa-edit"></i>
                    Profile <?= ucfirst(strtolower($siswa['nama'])); ?>
                </h3>
            </div>
            <div class='box-body'>
                <form id="form-edit" method='post'>
                    <div class='box-body'>
                        <input type='hidden' name='idu' value="<?= $siswa['id_siswa'] ?>" />
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label>NIS</label>
                                    <input type='text' name='nis' class='form-control' value="<?= $siswa['nis'] ?>" required='true' readonly='true' />
                                </div>
                                <div class='col-md-6'>
                                    <label>Nomor Peserta</label>
                                    <input type='text' name='no_peserta' class='form-control' value="<?= $siswa['no_peserta'] ?>" required='true' readonly='true' />
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Nama</label>
                                    <input type='text' name='nama' class='form-control' value="<?= $siswa['nama'] ?>" required='true' readonly='true' />
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>No hp</label>
                                    <input type='text' name='hp' class='form-control' value="<?= $siswa['hp'] ?>" />
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label>Password</label>
                                    <input type='password' name='pass1' class='form-control' />
                                </div>
                                <div class='col-md-6'>
                                    <label>Konfirmasi Password</label>
                                    <input type='password' name='pass2' class='form-control' />
                                </div>
                            </div>
                        </div>
                        <div class='box-tools pull-right btn-group'>
                            <button type="submit" class="btn btn-sm btn-flat btn-primary">
                                simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#form-edit').submit(function(e) {
            console.log($(this).serialize());
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'profilecontroller.php',
                data: $(this).serialize(),
                success: function(data) {
                    console.log(data);
                    if (data == 'OK') {
                        swal({
                            type: 'success',
                            title: 'Berhasil...',
                            html: 'Pengaturan akun anda berhasil diubah!!',
                        })
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else {
                        swal({
                            type: 'error',
                            title: 'Gagal...',
                            html: data,
                        })
                    }
                }
            });
            return false;
        });
    });
</script>