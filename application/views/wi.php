<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Work Instruction</h3>
                    <button class="btn btn-success" onclick="openModal()">Tambah Work Instruction</button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>View File</th>
                                    <th>Size (Kb)</th>
                                    <th>Uploaded</th>
                                </tr>
                            </thead>
                            <tbody id="data-manpower">
                                <?php $no = 1; foreach ($wi as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama_wi']; ?></td>
                                        <td>
                                            <a href="<?= base_url('uploads/wi_files/' . $row['nama_file']); ?>" download="<?= $row['nama_file']; ?>">
                                                <?= $row['nama_file']; ?>
                                            </a>
                                        </td>
                                        <td><?= $row['ukuran_file']; ?></td>
                                        <td><?= $row['dipname']; ?></td>
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
<div id="modalWi" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Work Instruction</h5>
                <button type="button" class="close" onclick="$('#modalWi').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formWi" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama_wi">Nama WI</label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="nama_wi" name="nama_wi" required>
                    </div>

                    <div class="form-group">
                        <label for="file_wi">Upload File</label> <label>(File harus berextensi .xls, .xlsx, atau .pdf)</label> <span class="text-danger">*</span>
                        <input type="file" class="form-control" id="file_wi" name="file_wi" accept=".xls,.xlsx" required>
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
    $('#modalWi').modal('show');
    $('#formWi')[0].reset();
    $('#modal-title').text('Tambah Work Instructions');
}
// Validasi ekstensi file
$('#file_wi').on('change', function () {
    const allowedExtensions = ['xls', 'xlsx', 'pdf'];
    const file = this.files[0];
    
    if (file) {
        const fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExtension)) {
            Swal.fire("Format Tidak Valid", "Hanya file dengan format .xls, .xlsx, atau .pdf yang diperbolehkan.", "error");
            this.value = ''; // reset file input
        }
    }
});


$('#formWi').submit(function(e) {
    e.preventDefault();

    let formData = new FormData(this); // Ambil data form termasuk file
    let url = "<?= site_url('settingwi/add'); ?>"; 

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            Swal.fire({
                title: "Mohon Tunggu",
                text: "Sedang mengunggah file...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            console.log(response); // Debugging

            let data = JSON.parse(response);
            if (data.status === "success") {
                Swal.fire("Berhasil!", "File berhasil diunggah.", "success").then(() => location.reload());
                $('#modalWi').modal('hide');
                $('#formWi')[0].reset(); // Reset form setelah sukses
            } else {
                Swal.fire("Error!", "Data dengan nama tersebut sudah tersedia!", "error");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error:", textStatus, errorThrown);
            Swal.fire("Error!", "Terjadi kesalahan pada server.", "error");
        }
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
