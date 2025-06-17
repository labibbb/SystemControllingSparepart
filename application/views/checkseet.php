<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Master Checkseet</h3>
                    <button class="btn btn-success" onclick="window.location.href='<?= site_url('checkseet/add'); ?>'">
                        Tambah Checkseet
                    </button>
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-checkseet">
                                <?php $no = 1; foreach ($checkseet as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama_lini']; ?></td>
                                        <td><?= $row['nama_area']; ?></td>
                                        <td><?= $row['nama_mesin']; ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <form action="<?= site_url('checkseet/edit'); ?>" method="post">
                                                    <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                    <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                                                </form>
                                                <form action="<?= site_url('checkseet/view'); ?>" method="post">
                                                    <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                    <button type="submit" class="btn btn-sm" style="background-color: yellow; color: black;">View</button>
                                                </form>
                                            </div>
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
</script>

<?php $this->load->view('layouts/footer'); ?>
