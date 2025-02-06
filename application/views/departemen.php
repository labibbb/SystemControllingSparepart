<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Master Departemen</h3>
                    <button class="btn btn-success" onclick="openModal()">Tambah Departemen</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Init</th>
                                    <th>Departemen</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-departemen">
                                <?php $no = 1; foreach ($departemen as $row): ?>
                                    <tr>
                                         <td><?= $no++; ?></td>
                                        <td><?= $row['init']; ?></td>
                                        <td><?= $row['dept']; ?></td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($row['sysdate'])); ?></td>
                                        <td>
                                                <button class="btn btn-warning btn-sm" onclick="editdepartemen(<?= $row['id']; ?>)">Edit</button>
                                                <button class="btn btn-danger btn-sm" onclick="deletedepartemen(<?= $row['id']; ?>)">Delete</button>
                                              
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
<div id="modalDepartemen" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Departemen</h5>
                <button type="button" class="close" onclick="$('#modalDepartemen').modal('hide')">&times;</button>
                </div>
            <div class="modal-body">
                <form id="formDepartemen">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label>init</label>
                        <input type="text" id="init" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Departemen</label>
                        <input type="text" id="dept" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openModal() {
    $('#modalDepartemen').modal('show');
    $('#formDepartemen')[0].reset();
    $('#id').val('');
    $('#modal-title').text('Tambah Departemen');
}

$('#formDepartemen').submit(function(e) {
    e.preventDefault();
    let id = $('#id').val();
    let init = $('#init').val();
    let dept = $('#dept').val();
    let url = id ? '<?= site_url("departemen/update"); ?>' : '<?= site_url("departemen/add"); ?>';

    $.post(url, { id:  id, init: init, dept: dept }, function(response) {
        console.log(response); // Tambahkan ini untuk debugging
        $('#modalDepartemen').modal('hide');
        Swal.fire('Berhasil!', 'Data berhasil disimpan.', 'success').then(() => location.reload());
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error:", textStatus, errorThrown);
        Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
    });
});


function editdepartemen(id) {
    $.get('<?= site_url("departemen/edit/"); ?>' + id, function(data) {
        openModal();
        $('#id').val(data.id);
        $('#init').val(data.init);
        $('#dept').val(data.dept);
        $('#modal-title').text('Edit Departemen');
    }, 'json');
}

function deletedepartemen(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= site_url("departemen/delete/"); ?>' + id, function(response) {
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success').then(() => location.reload());
            }, 'json');
        }
    });
}
</script>

<?php $this->load->view('layouts/footer'); ?>
