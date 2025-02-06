<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Master Mesin</h3>
                    <button class="btn btn-success" onclick="openModal()">Tambah Mesin</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mesin</th>
                                    <th>Tipe</th>
                                    <th>Kapasitas</th>
                                    <th>Area</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-mesin">
                                <?php $no = 1; foreach ($mesin as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama_mesin']; ?></td>
                                        <td><?= $row['tipe_mesin']; ?></td>
                                        <td><?= $row['kapasitas']; ?></td>
                                        <td><?= $row['nama_area']; ?></td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <button class="btn btn-warning btn-sm" onclick="editMesin(<?= $row['id_mesin']; ?>)">Edit</button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteMesin(<?= $row['id_mesin']; ?>)">Delete</button>
                                            <?php endif; ?>
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

<!-- Modal -->
<div id="modalMesin" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mesin</h5>
                <button type="button" class="close" onclick="$('#modalMesin').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formMesin">
                    <input type="hidden" id="id_mesin">
                    <div class="form-group">
                        <label>Nama Mesin</label>
                        <input type="text" id="nama_mesin" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tipe Mesin</label>
                        <input type="text" id="tipe_mesin" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kapasitas</label>
                        <input type="number" id="kapasitas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Area</label>
                        <select id="id_area" class="form-control">
                            <?php foreach ($areas as $area): ?>
                                <option value="<?= $area['id_area']; ?>"><?= $area['nama_area']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openModal() {
    $('#modalMesin').modal('show');
    $('#formMesin')[0].reset();
    $('#id_mesin').val('');
    $('#modal-title').text('Tambah Mesin');
}

$('#formMesin').submit(function(e) {
    e.preventDefault();
    let id = $('#id_mesin').val();
    let nama_mesin = $('#nama_mesin').val();
    let tipe_mesin = $('#tipe_mesin').val();
    let kapasitas = $('#kapasitas').val();
    let id_area = $('#id_area').val();
    let url = id ? '<?= site_url("mesin/update"); ?>' : '<?= site_url("mesin/add"); ?>';

    $.post(url, { id_mesin: id, nama_mesin: nama_mesin, tipe_mesin: tipe_mesin, kapasitas: kapasitas, id_area: id_area }, function(response) {
        console.log(response); // Untuk debugging
        $('#modalMesin').modal('hide');
        Swal.fire('Berhasil!', 'Data berhasil disimpan.', 'success').then(() => location.reload());
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error:", textStatus, errorThrown);
        Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
    });
});

function editMesin(id) {
    $.get('<?= site_url("mesin/edit/"); ?>' + id, function(data) {
        openModal();
        $('#id_mesin').val(data.id_mesin);
        $('#nama_mesin').val(data.nama_mesin);
        $('#tipe_mesin').val(data.tipe_mesin);
        $('#kapasitas').val(data.kapasitas);
        $('#id_area').val(data.id_area);
        $('#modal-title').text('Edit Mesin');
    }, 'json');
}

function deleteMesin(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.get('<?= site_url("mesin/delete/"); ?>' + id, function(response) {
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success').then(() => location.reload());
            }, 'json');
        }
    });
}
</script>


<?php $this->load->view('layouts/footer'); ?>
