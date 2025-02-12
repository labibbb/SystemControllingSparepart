<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Master Job Deskripsi</h3>
                    <button class="btn btn-success" onclick="openModal()">Tambah Job Deskripsi</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Job Deskripsi</th>
                                    <th>Periode</th>
                                    <th>Cycle Time (min) </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-job-deskripsi">
                                <?php $no = 1; foreach ($job_deskripsi as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['job_deskripsi']; ?></td>
                                        <td><?= $row['periode']; ?></td>
                                        <td><?= $row['cycle_time']; ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="editJobDeskripsi(<?= $row['id_job']; ?>)">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteJobDeskripsi(<?= $row['id_job']; ?>)">Delete</button>
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
<div id="modalJobDeskripsi" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Job Deskripsi</h5>
                <button type="button" class="close" onclick="$('#modalJobDeskripsi').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formJobDeskripsi">
                    <input type="hidden" id="id_job">
                    <div class="form-group">
                        <label>Job Deskripsi</label>
                        <input type="text" id="job_deskripsi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Periode</label>
                        <input type="text" id="periode" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Cycle Time (min) </label>
                        <input type="text" id="cycle_time" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openModal() {
    $('#modalJobDeskripsi').modal('show');
    $('#formJobDeskripsi')[0].reset();
    $('#id_job').val('');
    $('#modal-title').text('Tambah Job Deskripsi');
}

$('#formJobDeskripsi').submit(function(e) {
    e.preventDefault();
    let id = $('#id_job').val();
    let job_deskripsi = $('#job_deskripsi').val();
    let periode = $('#periode').val();
    let cycle_time = $('#cycle_time').val();
    let url = id ? '<?= site_url("jobdeskripsi/update"); ?>' : '<?= site_url("jobdeskripsi/add"); ?>';

    $.post(url, { id_job: id, job_deskripsi: job_deskripsi, periode: periode, cycle_time: cycle_time }, function(response) {
        $('#modalJobDeskripsi').modal('hide');
        Swal.fire('Berhasil!', 'Data berhasil disimpan.', 'success').then(() => location.reload());
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
    });
});

function editJobDeskripsi(id) {
    $.get('<?= site_url("jobdeskripsi/edit/"); ?>' + id, function(data) {
        openModal();
        $('#id_job').val(data.id_job);
        $('#job_deskripsi').val(data.job_deskripsi);
        $('#periode').val(data.periode);
        $('#cycle_time').val(data.cycle_time);
        $('#modal-title').text('Edit Job Deskripsi');
    }, 'json');
}

function deleteJobDeskripsi(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= site_url("jobdeskripsi/delete/"); ?>' + id, function(response) {
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success').then(() => location.reload());
            }, 'json');
        }
    });
}
</script>

<?php $this->load->view('layouts/footer'); ?>