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
                    <div class="row">
                        <!-- Tabel Painting 1 -->
                        <div class="col-md-6">
                            <h4 class="text-center">Painting 1</h4>
                            <div class="table-responsive">
                                <table id="tabel-mesin1" class="table table-bordered table-striped">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mesin</th>
                                            <th>Tipe</th>
                                            <th>Kapasitas</th>
                                            <th>Area</th>
                                            <th>Lini</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no1 = 1;
                                        foreach ($mesin as $row): 
                                            if ($row['nama_lini'] == 'Painting 1'): ?>
                                                <tr>
                                                    <td><?= $no1++; ?></td>
                                                    <td><?= $row['nama_mesin']; ?></td>
                                                    <td><?= $row['tipe_mesin']; ?></td>
                                                    <td><?= $row['kapasitas']; ?></td>
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
                                                            <button class="btn btn-warning btn-sm" onclick="editMesin(<?= $row['id_mesin']; ?>)">Edit</button>
                                                            <button class="btn btn-danger btn-sm" onclick="deleteMesin(<?= $row['id_mesin']; ?>)">Delete</button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                        <?php 
                                            endif;
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tabel Painting 2 -->
                        <div class="col-md-6">
                            <h4 class="text-center">Painting 2</h4>
                            <div class="table-responsive">
                                <table id="tabel-mesin2" class="table table-bordered table-striped">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mesin</th>
                                            <th>Tipe</th>
                                            <th>Kapasitas</th>
                                            <th>Area</th>
                                            <th>Lini</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no2 = 1;
                                        foreach ($mesin as $row): 
                                            if ($row['nama_lini'] == 'Painting 2'): ?>
                                                <tr>
                                                    <td><?= $no2++; ?></td>
                                                    <td><?= $row['nama_mesin']; ?></td>
                                                    <td><?= $row['tipe_mesin']; ?></td>
                                                    <td><?= $row['kapasitas']; ?></td>
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
                                                            <button class="btn btn-warning btn-sm" onclick="editMesin(<?= $row['id_mesin']; ?>)">Edit</button>
                                                            <button class="btn btn-danger btn-sm" onclick="deleteMesin(<?= $row['id_mesin']; ?>)">Delete</button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                        <?php 
                                            endif;
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- End Row -->
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
                <label>Painting 1</label>
                <select id="id_area1" class="form-control area-select" name="id_area">
                    <option value="">-- Pilih Area Painting 1 --</option>
                    <?php foreach ($areas_painting1 as $area): ?>
                        <option value="<?= $area['id_area']; ?>"><?= $area['nama_area']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Painting 2</label>
                <select id="id_area2" class="form-control area-select" name="id_area">
                    <option value="">-- Pilih Area Painting 2 --</option>
                    <?php foreach ($areas_painting2 as $area): ?>
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

<!-- Tambahkan DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>



<script>
    
    
    $(document).ready(function() {
    $('#tabel-mesin1').DataTable({
        "ordering": true, // Mengaktifkan sorting
        "paging": true,   // Mengaktifkan paginasi
        "searching": true // Mengaktifkan fitur pencarian
    });

    $('#tabel-mesin2').DataTable({
        "ordering": true,
        "paging": true,
        "searching": true
    });
});



function openModal() {
    $('#modalMesin').modal('show');
    $('#formMesin')[0].reset();
    $('#id_mesin').val('');
    $('#modal-title').text('Tambah Mesin');
}
$(document).ready(function () {
        $('.area-select').on('change', function () {
            var selectedId = $(this).val();
            var otherSelect = $(this).attr('id') === 'id_area1' ? '#id_area2' : '#id_area1';

            // Kosongkan dropdown lain jika memilih area
            $(otherSelect).val('');
        });

        $('#formMesin').submit(function(e) {
            e.preventDefault();
            
            let id = $('#id_mesin').val();
            let nama_mesin = $('#nama_mesin').val();
            let tipe_mesin = $('#tipe_mesin').val();
            let kapasitas = $('#kapasitas').val();
            let id_area = $('select[name="id_area"]').filter(function() { return $(this).val() !== ''; }).val(); // Ambil area yang dipilih
            let url = id ? '<?= site_url("mesin/update"); ?>' : '<?= site_url("mesin/add"); ?>';

            $.post(url, { id_mesin: id, nama_mesin: nama_mesin, tipe_mesin: tipe_mesin, kapasitas: kapasitas, id_area: id_area }, function(response) {
                console.log(response); // Debugging
                $('#modalMesin').modal('hide');
                Swal.fire('Berhasil!', 'Data berhasil disimpan.', 'success').then(() => location.reload());
            }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
                Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
            });
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
