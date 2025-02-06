<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Master Area</h3>
                    <button class="btn btn-success" onclick="openModal()">Tambah Area</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Area</th>
                                    <th>Lini</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-area">
                                <?php $no = 1; foreach ($area as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama_area']; ?></td>
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
                                                <button class="btn btn-warning btn-sm" onclick="editArea(<?= $row['id_area']; ?>)">Edit</button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteArea(<?= $row['id_area']; ?>)">Delete</button>
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
<div id="modalArea" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Area</h5>
                <button type="button" class="close" onclick="$('#modalArea').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formArea">
                    <input type="hidden" id="id_area">
                    <div class="form-group">
                        <label>Lini</label>
                        <select id="id_lini" class="form-control" required>
                            <?php foreach ($lini as $l): ?>
                                <option value="<?= $l['id_lini']; ?>"><?= $l['nama_lini']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Area</label>
                        <input type="text" id="nama_area" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openModal() {
    $('#modalArea').modal('show');
    $('#formArea')[0].reset();
    $('#id_area').val('');
    $('#modal-title').text('Tambah Area');
}

$('#formArea').submit(function(e) {
    e.preventDefault();
    let id = $('#id_area').val();
    let id_lini = $('#id_lini').val();
    let nama_area = $('#nama_area').val();
    let url = id ? '<?= site_url("area/update"); ?>' : '<?= site_url("area/add"); ?>';

    $.post(url, { id_area: id, id_lini: id_lini, nama_area: nama_area }, function(response) {
        Swal.fire('Berhasil!', 'Data berhasil disimpan.', 'success').then(() => location.reload());
    }, 'json');
});

function editArea(id) {
    $.get('<?= site_url("area/edit/"); ?>' + id, function(data) {
        openModal();
        $('#id_area').val(data.id_area);
        $('#id_lini').val(data.id_lini);
        $('#nama_area').val(data.nama_area);
        $('#modal-title').text('Edit Area');
    }, 'json');
}

function deleteArea(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= site_url("area/delete/"); ?>' + id, function() {
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success').then(() => location.reload());
            });
        }
    });
}
</script>

<?php $this->load->view('layouts/footer'); ?>
