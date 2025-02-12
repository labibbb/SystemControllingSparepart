<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Master Setting FWM</h3>
                    <button class="btn btn-success" onclick="openModal()">Tambah Setting</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Lini</th>
                                    <th>Area</th>
                                    <th>Mesin</th>
                                    <th>Frekuensi</th>
                                    <th>Instruksi Kerja</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($settings as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama_lini']; ?></td>
                                        <td><?= $row['nama_area']; ?></td>
                                        <td><?= $row['nama_mesin']; ?></td>
                                        <td><?= $row['frekuensi']; ?></td>
                                        <td><?= $row['instruksi_kerja']; ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="updateFrekuensi(<?= $row['id_fwp']; ?>)">Update Frekuensi</button>
                                            <button class="btn btn-primary btn-sm" onclick="updateInstruksi(<?= $row['id_fwp']; ?>)">Update Instruksi</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal Form -->
<div id="modalSetting" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Setting</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formSetting">
                    <div class="form-group">
                        <label>Lini</label>
                        <select id="id_lini" class="form-control" required>
                            <option value="">Pilih Lini</option>
                            <?php foreach ($lini as $l): ?>
                                <option value="<?= $l['id_lini']; ?>"><?= $l['nama_lini']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Area</label>
                        <select id="id_area" class="form-control" required disabled></select>
                    </div>
                    <div class="form-group">
                        <label>Mesin</label>
                        <select id="id_mesin" class="form-control" required disabled></select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Frekuensi -->
<div id="modalFrekuensi" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Frekuensi</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formFrekuensi">
                    <input type="hidden" id="id_fwp" name="id_fwp">
                    <div class="form-group">
                        <label>Frekuensi</label>
                        <select name="frekuensi" class="form-control">
                            <option value="1 month">1 Month</option>
                            <option value="2 month">2 Month</option>
                            <option value="3 month">3 Month</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Instruksi -->
<div id="modalInstruksi" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Instruksi Kerja</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formInstruksi">
                    <input type="hidden" id="id_instruksi" name="id_fwp">
                    <div class="form-group">
                        <label>Instruksi Kerja</label>
                        <select name="instruksi_kerja" class="form-control">
                            <option value="start">Start</option>
                            <option value="stop">Stop</option>
                            <option value="end">End</option>
                            <option value="not started">Not Started</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#id_lini').change(function() {
            let idLini = $(this).val();
            $('#id_area').prop('disabled', false);
            $.post('<?= site_url("settingfwm/get_area"); ?>', { id_lini: idLini }, function(data) {
                $('#id_area').html('<option value="">Pilih Area</option>');
                $.each(JSON.parse(data), function(index, value) {
                    $('#id_area').append('<option value="' + value.id_area + '">' + value.nama_area + '</option>');
                });
            });
        });

        $('#id_area').change(function() {
            let idArea = $(this).val();
            $('#id_mesin').prop('disabled', false);
            $.post('<?= site_url("settingfwm/get_mesin"); ?>', { id_area: idArea }, function(data) {
                $('#id_mesin').html('<option value="">Pilih Mesin</option>');
                $.each(JSON.parse(data), function(index, value) {
                    $('#id_mesin').append('<option value="' + value.id_mesin + '">' + value.nama_mesin + '</option>');
                });
            });
        });
    });

    function updateFrekuensi(id) {
        $('#modalFrekuensi').modal('show');
        $('#id_fwp').val(id);
    }

    function updateInstruksi(id) {
        $('#modalInstruksi').modal('show');
        $('#id_instruksi').val(id);
    }

    function openModal() {
        $('#modalSetting').modal('show'); // Perbaiki ID modal
    }
</script>

<script>
    $('#formSetting').submit(function(e) {
        e.preventDefault();
        let idLini = $('#id_lini').val();
        let idArea = $('#id_area').val();
        let idMesin = $('#id_mesin').val();

        $.post('<?= site_url("settingfwm/add"); ?>', { id_lini: idLini, id_area: idArea, id_mesin: idMesin }, function(response) {
            let res = JSON.parse(response);
            if (res.status === 'success') {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Setting FWM berhasil ditambahkan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => location.reload());
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: res.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    $('#formFrekuensi').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('settingfwm/update_frekuensi') ?>",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Frekuensi Berhasil Diubah',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => location.reload());
            },
            error: function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: res.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    $('#formInstruksi').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('settingfwm/update_instruksi') ?>",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Instruksi Berhasil Diubah',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => location.reload());
            },
            error: function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: res.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>


<?php $this->load->view('layouts/footer'); ?>
