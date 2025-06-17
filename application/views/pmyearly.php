<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Schedule Yearly PM</h3>
                    <button class="btn btn-success" onclick="openModal()">Tambah Schedule</button>
                </div>
                <div class="box-body">
                    <div class="row">
                        <!-- Tabel Kiri -->
                        <div class="col-md-6">
                        <h3 class="text-center">Painting 1</h3>

                        <!-- Filter Tahun, Bulan, dan Area -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="filterTahun1">Tahun</label>
                                <select id="filterTahun1" class="form-control">
                                    <?php for ($i = date('Y'); $i <= date('Y') + 4; $i++): ?>
                                        <option value="<?= $i; ?>" <?= ($i == $tahun_selected) ? 'selected' : ''; ?>><?= $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filterBulan1">Bulan</label>
                                <select id="filterBulan1" class="form-control">
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= $i; ?>" <?= ($i == $bulan_selected) ? 'selected' : ''; ?>>
                                            <?= date('F', mktime(0, 0, 0, $i, 1)); ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filterArea1">Area</label>
                                <select id="filterArea1" class="form-control">
                                    <?php foreach ($areas as $area): ?>
                                        <option value="<?= $area['id_area']; ?>" <?= ($area['id_area'] == $area_selected) ? 'selected' : ''; ?>>
                                            <?= $area['nama_area']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Tabel Data -->
                        <div class="table-responsive">
                            <table id="table1" class="table table-bordered table-striped">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Y</th>
                                        <th>M</th>
                                        <th>Mesin</th>
                                        <th>Status PM</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table1-body">
                                    <?php $no = 1; foreach ($pmyearly as $row): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['tahun']; ?></td>
                                            <td><?= $row['bulan']; ?></td>
                                            <td><?= $row['nama_mesin']; ?></td>
                                            <td>
                                                <?php if ($row['status'] == 1): ?>
                                                    <button class="btn btn-sm btn-primary">Belum Terlaksana</button>
                                                <?php elseif ($row['status'] == 2): ?>
                                                    <button class="btn btn-sm btn-danger">Finish On Delay</button>
                                                <?php elseif ($row['status'] == 3): ?>
                                                    <button class="btn btn-sm btn-success">Finish On Time</button>
                                                <?php endif; ?>
                                            </td>
                                            <td class="bg-secondary text-white text-center">No Action</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        </div>

                        <!-- Tabel Kanan -->
                        <div class="col-md-6">
                            <h3 class="text-center">Painting 2</h3>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="filterTahun2">Tahun</label>
                                    <select id="filterTahun2" class="form-control">
                                        <?php for ($i = date('Y'); $i <= date('Y') + 4; $i++): ?>
                                            <option value="<?= $i; ?>" <?= ($i == $tahun_selected) ? 'selected' : ''; ?>><?= $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="filterBulan2">Bulan</label>
                                    <select id="filterBulan2" class="form-control">
                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option value="<?= $i; ?>" <?= ($i == $bulan_selected) ? 'selected' : ''; ?>>
                                                <?= date('F', mktime(0, 0, 0, $i, 1)); ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="filterArea2">Area</label>
                                    <select id="filterArea2" class="form-control">
                                        <?php foreach ($areas2 as $area): ?>
                                            <option value="<?= $area['id_area']; ?>" <?= ($area['id_area'] == $area_selected) ? 'selected' : ''; ?>>
                                                <?= $area['nama_area']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="table2" class="table table-bordered table-striped">
                                <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Y</th>
                                            <th>M</th>
                                            <th>Mesin</th>
                                            <th>Status PM</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table2-body">
                                        <?php 
                                        $no = 1;
                                        foreach ($pmyearly2 as $row): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $row['tahun']; ?></td>
                                                <td><?= $row['bulan']; ?></td>
                                                <td><?= $row['nama_mesin']; ?></td>
                                                <td>
                                                    <?php if ($row['status'] == 1): ?>
                                                        <button class="btn btn-sm btn-primary">Belum Terlaksana</button>
                                                    <?php elseif ($row['status'] == 2): ?>
                                                        <button class="btn btn-sm btn-danger">Finish On Delay</button>
                                                    <?php elseif ($row['status'] == 3): ?>
                                                        <button class="btn btn-sm btn-success">Finish On Time</button>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="bg-secondary text-white text-center">No Action</td>
                                            </tr>
                                        <?php endforeach; ?>
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
       
<!-- Modal Form -->
<div id="modalSetting" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Schedule</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formSetting">
                    <!-- Baris pertama: Tahun dan Bulan sebelahan -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Tahun</label> <span class="text-danger">*</span>
                            <select id="tahun" class="form-control">
                                <option value="">Pilih Tahun</option>
                                <?php for ($i = date('Y'); $i <= date('Y') + 4; $i++): ?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Bulan</label> <span class="text-danger">*</span>
                            <select id="bulan" class="form-control">
                                <option value="">Pilih Bulan</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i; ?>"><?= date('F', mktime(0, 0, 0, $i, 1)); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Baris kedua: Lini dan Area sebelahan -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Lini</label> <span class="text-danger">*</span>
                            <select id="id_lini" class="form-control">
                                <option value="">Pilih Lini</option>
                                <?php foreach ($lini as $l): ?>
                                    <option value="<?= $l['id_lini']; ?>"><?= $l['nama_lini']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Area</label> <span class="text-danger">*</span>
                            <select id="id_area" class="form-control" disabled></select>
                        </div>
                    </div>
                    
                    <!-- Baris ketiga: Mesin -->
                    <!-- Baris ketiga: Mesin dengan search box -->
                    <div class="form-group">
                        <label>Mesin</label> <span class="text-danger">*</span>
                        <div class="input-group mb-2">
                            <input type="text" id="searchMesin" class="form-control" placeholder="Cari mesin..." disabled>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <select id="id_mesin" class="form-control" size="5" disabled required></select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#formSetting").submit(function(e) {
            e.preventDefault(); // Mencegah submit default

            let idLini = $("#id_lini").val();
            let idArea = $("#id_area").val();
            let idMesin = $("#id_mesin").val();
            let tahun = $("#tahun").val();
            let bulan = $("#bulan").val();
            let pesan = "";

            // Validasi input
            if (tahun === "") pesan += "Tahun harus dipilih.<br>";
            if (bulan === "") pesan += "Bulan harus dipilih.<br>";
            if (idLini === "") pesan += "Lini harus dipilih.<br>";
            if (idArea === "") pesan += "Area harus dipilih.<br>";
            if (idMesin === "" || idMesin === null) {
        pesan += "Mesin harus dipilih.<br>";
        $("#id_mesin").css("border", "1px solid red");
        $("#searchMesin").css("border", "1px solid red");
        isValid = false;
    }

            if (pesan !== "") {
                // Jika ada input yang kosong, tampilkan peringatan
                Swal.fire({
                    icon: "warning",
                    title: "Isi Semua Data",
                    html: pesan, // Menampilkan pesan dengan break line
                    confirmButtonText: "Tutup",
                    confirmButtonColor: "#d33"
                });
            } else {
                // Jika semua terisi, kirim data ke server
                $.post("<?= site_url('pmyearly/add'); ?>", {
                    id_lini: idLini,
                    id_area: idArea,
                    id_mesin: idMesin,
                    tahun: tahun,
                    bulan: bulan
                }, function(response) {
                    let res = JSON.parse(response);
                    if (res.status === "success") {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Schedule PM Yearly berhasil ditambahkan",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Schedule PM Yearly mesin tersebut sudah ada!",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                });
            }
        });

        $('#table1').DataTable({
    "ordering": true,
    "paging": true,
    "searching": true,
    "info": true,
    "lengthChange": true,
    "columnDefs": [
        { "orderable": false, "targets": [0,5] } // Kolom No dan Aksi tidak bisa di-sort
    ],
    "order": [[1, 'asc']], // Default sort by tahun
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
            }
        }
});

$('#table2').DataTable({
    "ordering": true,
    "paging": true,
    "searching": true,
    "info": true,
    "lengthChange": true,
    "columnDefs": [
        { "orderable": false, "targets": [0,5] }
    ],
    "order": [[1, 'asc']],
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
            }
        }
});

        function filterData() {
    $.post("<?= base_url('pmyearly/filter'); ?>", {
        tahun: $('#filterTahun1').val(),
        bulan: $('#filterBulan1').val(),
        area: $('#filterArea1').val()
    }, function(data) {
        let result = JSON.parse(data);
        let table = $('#table1').DataTable();
        
        table.clear();
        
        if (result.length === 0) {
            table.row.add(['1', '', '', 'Data Tidak Ditemukan', '', '']).draw();
        } else {
            result.forEach((row, index) => {  // Tambahkan parameter index
                let statusButton = '';
                if (row.status == 1) {
                    statusButton = `<button class="btn btn-sm btn-primary">Belum Terlaksana</button>`;
                } else if (row.status == 2) {
                    statusButton = `<button class="btn btn-sm btn-danger">Finish On Delay</button>`;
                } else if (row.status == 3) {
                    statusButton = `<button class="btn btn-sm btn-success">Finish On Time</button>`;
                }

                table.row.add([
                    index + 1,  // Gunakan index + 1 untuk nomor urut
                    row.tahun,
                    row.bulan,
                    row.nama_mesin,
                    statusButton,
                    '<span class="bg-secondary text-white text-center">No Action</span>'
                ]);
            });
        }
        
        table.draw();
    });
}


        // Event listener hanya untuk filter yang berkaitan dengan table1
        $('#filterTahun1, #filterBulan1, #filterArea1').on('change', filterData);

        function filterData2() {
    $.post("<?= base_url('pmyearly/filter2'); ?>", {
        tahun: $('#filterTahun2').val(),
        bulan: $('#filterBulan2').val(),
        area: $('#filterArea2').val()
    }, function(data) {
        let result = JSON.parse(data);
        let table = $('#table2').DataTable();
        
        table.clear();
        
        if (result.length === 0) {
            table.row.add(['1', '', '', 'Data Tidak Ditemukan', '', '']).draw();
        } else {
            result.forEach((row, index) => {  // Tambahkan parameter index
                let statusButton = '';
                if (row.status == 1) {
                    statusButton = `<button class="btn btn-sm btn-primary">Belum Terlaksana</button>`;
                } else if (row.status == 2) {
                    statusButton = `<button class="btn btn-sm btn-danger">Finish On Delay</button>`;
                } else if (row.status == 3) {
                    statusButton = `<button class="btn btn-sm btn-success">Finish On Time</button>`;
                }

                table.row.add([
                    index + 1,  // Gunakan index + 1 untuk nomor urut
                    row.tahun,
                    row.bulan,
                    row.nama_mesin,
                    statusButton,
                    '<span class="bg-secondary text-white text-center">No Action</span>'
                ]);
            });
        }
        
        table.draw();
    });
}

        // Event listener hanya untuk filter yang berkaitan dengan table1
        $('#filterTahun2, #filterBulan2, #filterArea2').on('change', filterData2);

        $('#id_lini').change(function() {
            let idLini = $(this).val();
            $('#id_area').prop('disabled', false);
            $.post('<?= site_url("settingfwm/get_area"); ?>', { id_lini: idLini }, function(data) {
                $('#id_area').html('<option value="">Pilih Area</option>');
                $.each(JSON.parse(data), function(index, value) {
                    $('#id_area').append('<option value="' + value.id_area + '">' + value.nama_area + '</option>');
                });
            });
        });

       $('#id_area').change(function() {
            let idArea = $(this).val();
            $('#id_mesin').prop('disabled', false);
            $('#searchMesin').prop('disabled', false);
            $.post('<?= site_url("settingfwm/get_mesin"); ?>', { id_area: idArea }, function(data) {
                $('#id_mesin').html('<option value="">Pilih Mesin</option>');
                $.each(JSON.parse(data), function(index, value) {
                    $('#id_mesin').append('<option value="' + value.id_mesin + '">' + value.nama_mesin + '</option>');
                });
            });
        });

        // Fungsi untuk mencari mesin
        $('#searchMesin').on('input', function() {
            let searchText = $(this).val().toLowerCase();
            $('#id_mesin option').each(function() {
                let optionText = $(this).text().toLowerCase();
                if (optionText.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });

    function openModal() {
        $('#modalSetting').modal('show'); // Perbaiki ID modal
    }
</script>
<?php $this->load->view('layouts/footer'); ?>
