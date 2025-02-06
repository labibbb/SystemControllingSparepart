<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Master Manpower</h3>
                    <button class="btn btn-success" onclick="openModal()">Tambah Manpower</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Posisi</th>
                                    <th>Shift</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-manpower">
                                <?php $no = 1; foreach ($manpower as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['posisi']; ?></td>
                                        <td><?= $row['shift']; ?></td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <button class="btn btn-warning btn-sm" onclick="editmanpower(<?= $row['id_manpower']; ?>)">Edit</button>
                                                <button class="btn btn-danger btn-sm" onclick="deletemanpower(<?= $row['id_manpower']; ?>)">Delete</button>
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

<!-- Modal Form -->
<div id="modalManpower" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Manpower</h5>
                <button type="button" class="close" onclick="$('#modalManpower').modal('hide')">&times;</button>
                </div>
            <div class="modal-body">
                <form id="formManpower">
                    <input type="hidden" id="id_manpower">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" id="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Posisi</label>
                        <input type="text" id="posisi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Shift</label>
                        <input type="number" id="shift" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openModal() {
    $('#modalManpower').modal('show');
    $('#formManpower')[0].reset();
    $('#id_manpower').val('');
    $('#modal-title').text('Tambah Manpower');
}

$('#formManpower').submit(function(e) {
    e.preventDefault();
    let id = $('#id_manpower').val();
    let nama = $('#nama').val();
    let posisi = $('#posisi').val();
    let shift = $('#shift').val();
    let url = id ? '<?= site_url("manpower/update"); ?>' : '<?= site_url("manpower/add"); ?>';

    $.post(url, { id_manpower:  id, nama: nama, posisi: posisi, shift: shift }, function(response) {
        console.log(response); // Tambahkan ini untuk debugging
        $('#modalManpower').modal('hide');
        Swal.fire('Berhasil!', 'Data berhasil disimpan.', 'success').then(() => location.reload());
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error:", textStatus, errorThrown);
        Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
    });
});


function editmanpower(id) {
    $.get('<?= site_url("manpower/edit/"); ?>' + id, function(data) {
        openModal();
        $('#id_manpower').val(data.id_manpower);
        $('#nama').val(data.nama);
        $('#posisi').val(data.posisi);
        $('#shift').val(data.shift);
        $('#modal-title').text('Edit Manpower');
    }, 'json');
}

function deletemanpower(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= site_url("manpower/delete/"); ?>' + id, function(response) {
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success').then(() => location.reload());
            }, 'json');
        }
    });
}
</script>

<?php $this->load->view('layouts/footer'); ?>
