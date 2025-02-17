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
                                    <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
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
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-success">Sudah Terlaksana</button>
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
                                        <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
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
                                                <td><?= $row['nama_lini']; ?></td>
                                                <td><?= $row['nama_area']; ?></td>
                                                <td><?= $row['nama_mesin']; ?></td>
                                                <td>
                                                    <?php if ($row['status'] == 1): ?>
                                                        <button class="btn btn-sm btn-primary">Belum Terlaksana</button>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm btn-success">Sudah Terlaksana</button>
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
                <h5 class="modal-title">Tambah Setting</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formSetting">
                    <!-- Baris pertama: Tahun dan Bulan sebelahan -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Tahun</label>
                            <select id="tahun" class="form-control" required>
                                <option value="">Pilih Tahun</option>
                                <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Bulan</label>
                            <select id="bulan" class="form-control" required>
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
                            <label>Lini</label>
                            <select id="id_lini" class="form-control" required>
                                <option value="">Pilih Lini</option>
                                <?php foreach ($lini as $l): ?>
                                    <option value="<?= $l['id_lini']; ?>"><?= $l['nama_lini']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Area</label>
                            <select id="id_area" class="form-control" required disabled></select>
                        </div>
                    </div>
                    
                    <!-- Baris ketiga: Mesin -->
                    <div class="form-group">
                        <label>Mesin</label>
                        <select id="id_mesin" class="form-control" required disabled></select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table1').DataTable({
            "ordering": true, // Mengaktifkan sorting
            "paging": true,   // Mengaktifkan paginasi
            "searching": true // Mengaktifkan fitur pencarian
        });

        $('#table2').DataTable({
            "ordering": true,
            "paging": true,
            "searching": true
        });

        function filterData() {
            $.post("<?= base_url('pmyearly/filter'); ?>", {
                tahun: $('#filterTahun1').val(),
                bulan: $('#filterBulan1').val(),
                area: $('#filterArea1').val()
            }, function (data) {
                let rows = '';
                let result = JSON.parse(data);

                if (result.length === 0) {
                    rows = `<tr>
                        <td colspan="6" class="text-center text-danger">Data Not Found</td>
                    </tr>`;
                } else {
                    result.forEach((row, index) => {
                        let statusButton = row.status == 1
                            ? `<button class="btn btn-sm btn-primary">Belum Terlaksana</button>`
                            : `<button class="btn btn-sm btn-success">Sudah Terlaksana</button>`;

                        rows += `<tr>
                            <td>${index + 1}</td>
                            <td>${row.tahun}</td>
                            <td>${row.bulan}</td>
                            <td>${row.nama_mesin}</td>
                            <td>${statusButton}</td>
                            <td class="bg-secondary text-white text-center">No Action</td>
                        </tr>`;
                    });
                }

                $('#table1-body').html(rows); // UPDATE HANYA TABLE1
            });
        }


        // Event listener hanya untuk filter yang berkaitan dengan table1
        $('#filterTahun1, #filterBulan1, #filterArea1').on('change', filterData);

        function filterData2() {
            $.post("<?= base_url('pmyearly/filter2'); ?>", {
                tahun: $('#filterTahun2').val(),
                bulan: $('#filterBulan2').val(),
                area: $('#filterArea2').val()
            }, function (data) {
                let rows = '';
                let result = JSON.parse(data);

                if (result.length === 0) {
                    rows = `<tr>
                        <td colspan="6" class="text-center text-danger">Data Not Found</td>
                    </tr>`;
                } else {
                    result.forEach((row, index) => {
                        let statusButton = row.status == 1
                            ? `<button class="btn btn-sm btn-primary">Belum Terlaksana</button>`
                            : `<button class="btn btn-sm btn-success">Sudah Terlaksana</button>`;

                        rows += `<tr>
                            <td>${index + 1}</td>
                            <td>${row.tahun}</td>
                            <td>${row.bulan}</td>
                            <td>${row.nama_mesin}</td>
                            <td>${statusButton}</td>
                            <td class="bg-secondary text-white text-center">No Action</td>
                        </tr>`;
                    });
                }

                $('#table2-body').html(rows);
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
            $.post('<?= site_url("settingfwm/get_mesin"); ?>', { id_area: idArea }, function(data) {
                $('#id_mesin').html('<option value="">Pilih Mesin</option>');
                $.each(JSON.parse(data), function(index, value) {
                    $('#id_mesin').append('<option value="' + value.id_mesin + '">' + value.nama_mesin + '</option>');
                });
            });
        });
    });

    function openModal() {
        $('#modalSetting').modal('show'); // Perbaiki ID modal
    }
</script>

<script>
    $('#formSetting').submit(function(e) {
        e.preventDefault();
        let idLini = $('#id_lini').val();
        let idArea = $('#id_area').val();
        let idMesin = $('#id_mesin').val();
        let tahun = $('#tahun').val();
        let bulan = $('#bulan').val();

        $.post('<?= site_url("pmyearly/add"); ?>', { id_lini: idLini, id_area: idArea, id_mesin: idMesin, tahun:tahun, bulan:bulan }, function(response) {
            let res = JSON.parse(response);
            if (res.status === 'success') {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Schedule PM Yearly berhasil ditambahkan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => location.reload());
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: res.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>


<?php $this->load->view('layouts/footer'); ?>
