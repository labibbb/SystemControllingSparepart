<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Master Users</h3>
                    <button class="btn btn-success" onclick="openModal()">Tambah User</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Departemen</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-users">
                                <?php $no = 1; foreach ($users as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td><?= $row['dept']; ?></td>
                                        <td><?= $row['level']; ?></td>
                                        <td>
                                            <?php if ($row['active'] == 1): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($row['sysdate'])); ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="editUser(<?= $row['id_users']; ?>)">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $row['id_users']; ?>)">Delete</button>
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
<div id="modalUsers" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah User</h5>
                <button type="button" class="close" onclick="$('#modalUsers').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formUsers">
                    <input type="hidden" id="id_users">
                    <div class="form-group">
                        <label>Username</label> <span class="text-danger">*</span>
                        <input type="text" id="username" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>Password</label> <span class="text-danger">*</span>
                        <input type="password" id="password" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>Display Name</label> <span class="text-danger">*</span>
                        <input type="text" id="dipname" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>Level</label> <span class="text-danger">*</span>
                        <select id="level" class="form-control" required>
                            <option value="1">Supervisor</option>
                            <option value="2">Foreman</option>
                            <option value="3">Operator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Departemen</label> <span class="text-danger">*</span>
                        <select id="id" class="form-control" required>
                            <?php foreach ($departemen as $l): ?>
                                <option value="<?= $l['id']; ?>"><?= $l['dept']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Plant</label> <span class="text-danger">*</span>
                        <input type="text" id="plant" class="form-control" >
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#example1').DataTable({
        "responsive": true,
        "autoWidth": false,
        "ordering": true,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
            "infoFiltered": "(disaring dari _MAX_ total data)",
            "zeroRecords": "Tidak ada data yang ditemukan",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            },
            "emptyTable": "Tidak ada data yang tersedia",
            "loadingRecords": "Memuat...",
            "processing": "Memproses..."
        }
    });
});


function openModal() {
    $('#modalUsers').modal('show');
    $('#formUsers')[0].reset();
    $('#id_users').val('');
    $('#modal-title').text('Tambah User');
}

$('#formUsers').submit(function(e) {
    e.preventDefault();
    let id = $('#id_users').val();
    let username = $('#username').val();
    let password = $('#password').val();
    let dipname = $('#dipname').val();
    let level = $('#level').val();
    let role = $('#id').val();
    let plant = $('#plant').val();
    // Validasi manual (kecuali level dan departemen)
    if (!username || !password || !dipname || !plant) {
        Swal.fire({
            icon: 'warning',
            title: 'Validasi Gagal',
            text: 'Semua kolom harus diisi.'
        });
        return;
    }

    let url = id ? '<?= site_url("user/update"); ?>' : '<?= site_url("user/add"); ?>';

    // Kirim data ke server
    $.post(url, { id_users: id, username: username, password: password, dipname: dipname, level: level, id: role, plant: plant  }, function(response) {
        // Handle response dari controller
        if (response.status === 'error') {
            // Ini akan terpanggil ketika controller mengembalikan status error
            Swal.fire('Peringatan!', ' username sudah ada dalam database.', 'warning');
        } else {
            // Jika sukses
            $('#modalUsers').modal('hide');
            Swal.fire('Berhasil!', 'Data berhasil disimpan.', 'success').then(() => location.reload());
        }
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error:", textStatus, errorThrown);
        Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
    });
});

function editUser(id) {
    $.get('<?= site_url("user/edit/"); ?>' + id, function(data) {
        openModal();
        $('#id_users').val(data.id_users);
        $('#username').val(data.username);
        $('#password').val(''); // Tidak menampilkan password saat edit
        $('#dipname').val(data.dipname);
        $('#level').val(data.level);
        $('#id').val(data.role);
        $('#plant').val(data.plant);
        $('#modal-title').text('Edit User');
    }, 'json');
}

function deleteUser(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= site_url("user/delete/"); ?>' + id, function(response) {
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success').then(() => location.reload());
            }, 'json');
        }
    });
}
</script>

<?php $this->load->view('layouts/footer'); ?>
