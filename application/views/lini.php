<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Master Lini</h3>
                    <button class="btn btn-success" onclick="openModal()">Tambah Lini</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lini</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-lini">
                                <?php $no = 1; foreach ($lini as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama_lini']; ?></td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <button class="btn btn-warning btn-sm" onclick="editLini(<?= $row['id_lini']; ?>)">Edit</button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteLini(<?= $row['id_lini']; ?>)">Delete</button>
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
<div id="modalLini" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Lini</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formLini">
                    <input type="hidden" id="id_lini">
                    <div class="form-group">
                        <label>Nama Lini</label>
                        <input type="text" id="nama_lini" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openModal() {
    $('#modalLini').modal('show');
    $('#formLini')[0].reset();
    $('#id_lini').val('');
    $('#modal-title').text('Tambah Lini');
}

$('#formLini').submit(function(e) {
    e.preventDefault();
    let id = $('#id_lini').val();
    let nama_lini = $('#nama_lini').val();
    let url = id ? '<?= site_url("lini/update"); ?>' : '<?= site_url("lini/add"); ?>';

    $.post(url, { id_lini: id, nama_lini: nama_lini }, function(response) {
        console.log(response); // Tambahkan ini untuk debugging
        $('#modalLini').modal('hide');
        Swal.fire('Berhasil!', 'Data berhasil disimpan.', 'success').then(() => location.reload());
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error:", textStatus, errorThrown);
        Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
    });
});


function editLini(id) {
    $.get('<?= site_url("lini/edit/"); ?>' + id, function(data) {
        openModal();
        $('#id_lini').val(data.id_lini);
        $('#nama_lini').val(data.nama_lini);
        $('#modal-title').text('Edit Lini');
    }, 'json');
}

function deleteLini(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= site_url("lini/delete/"); ?>' + id, function(response) {
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success').then(() => location.reload());
            }, 'json');
        }
    });
}
</script>

<?php $this->load->view('layouts/footer'); ?>
