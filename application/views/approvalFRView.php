<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Schedule Monthly PM</h3>
                    <div class="mt-2">
                        <select id="id_lini" class="form-control" required style="width: 300px;">
                            <?php foreach ($lini as $l): ?>
                                <option value="<?= $l['id_lini']; ?>"><?= $l['nama_lini']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>MP</th>
                                    <th>Lini</th>
                                    <th>Area</th>
                                    <th>Mesin</th>
                                    <th>Status</th>
                                    <th>Cek FR</th>
                                    <th>Cek SPV</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table1-body">
                                <?php $no = 1; foreach ($pmmonthly as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td>
                                            <?= !empty($row['tanggal']) ? date('d M Y', strtotime($row['tanggal'])) : 'No Set'; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $bulan = $row['bulan']; // Misalnya nilai bulan adalah 1, 2, 3, dst.
                                            switch($bulan) {
                                                case 1: echo "Januari"; break;
                                                case 2: echo "Februari"; break;
                                                case 3: echo "Maret"; break;
                                                case 4: echo "April"; break;
                                                case 5: echo "Mei"; break;
                                                case 6: echo "Juni"; break;
                                                case 7: echo "Juli"; break;
                                                case 8: echo "Agustus"; break;
                                                case 9: echo "September"; break;
                                                case 10: echo "Oktober"; break;
                                                case 11: echo "November"; break;
                                                case 12: echo "Desember"; break;
                                                default: echo "Bulan tidak valid"; break;
                                            }
                                            ?>
                                        </td>
                                        <td><?= $row['tahun']; ?></td>
                                        <td><?= $row['dipname']; ?></td>
                                        <td><?= $row['nama_lini']; ?></td>
                                        <td><?= $row['nama_area']; ?></td>
                                        <td><?= $row['nama_mesin']; ?></td>
                                        <td>
                                            <?php 
                                            // Menentukan status berdasarkan angka
                                            switch ($row['status']) {
                                                case 1:
                                                    echo '<span class="badge bg-info">Terjadwal Tahunan</span>';
                                                    break;
                                                case 2:
                                                    echo '<span class="badge bg-warning">Belum Terlaksana</span>';
                                                    break;
                                                case 3:
                                                    echo '<span class="badge bg-success">Sudah Terjadwal</span>';
                                                    break;
                                                case 4:
                                                    echo '<span class="badge bg-success">Finish On Time</span>';
                                                    break;
                                                case 5:
                                                    echo '<span class="badge bg-danger">Finish On Delay</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="d-flex">
                                                <form action="<?= site_url('approvalFR/detail'); ?>" method="post" class="me-2">
                                                    <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                    <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                    <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm">Check</button>
                                                </form>
                                                <button class="btn btn-success btn-sm" onclick="printDocument(<?= $row['id_pmm']; ?>)">
                                                    <i class="fas fa-print"></i> Print
                                                </button>
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
    function editTanggal(id, tanggal, catatan) {
        document.getElementById("id_pmm_tgl").value = id;
        document.getElementById("tanggal_tgl").value = tanggal;
        $('#modalTanggal').modal('show');
    }

    function editMP(id) {
        document.getElementById("id_pmm_mp").value = id;
        $('#modalMP').modal('show'); // Menggunakan Bootstrap modal
    }

    function editTanggalStatus(id) {
        document.getElementById("id_pmm_tglstts").value = id;
        $('#modalTanggalStatus').modal('show'); // Menggunakan Bootstrap modal
    }

    $('#id_lini').on('change', filterData);

    function filterData() {
        $.post("<?= base_url('pmmonthly/filter'); ?>", {
            lini: $('#id_lini').val()
        }, function (data) {
            let rows = '';
            let result = JSON.parse(data);

            if (result.length === 0) {
                rows = `<tr>
                    <td colspan="12" class="text-center text-danger">Data Not Found</td>
                </tr>`;
            } else {
                result.forEach((row, index) => {

                    // Memastikan bulan dan status tidak null atau undefined
                    let bulan = '';
                    if (row.bulan !== undefined && row.bulan !== null) {
                        switch (parseInt(row.bulan)) {
                            case 1: bulan = "Januari"; break;
                            case 2: bulan = "Februari"; break;
                            case 3: bulan = "Maret"; break;
                            case 4: bulan = "April"; break;
                            case 5: bulan = "Mei"; break;
                            case 6: bulan = "Juni"; break;
                            case 7: bulan = "Juli"; break;
                            case 8: bulan = "Agustus"; break;
                            case 9: bulan = "September"; break;
                            case 10: bulan = "Oktober"; break;
                            case 11: bulan = "November"; break;
                            case 12: bulan = "Desember"; break;
                            default: bulan = "Bulan tidak valid"; break;
                        }
                    } else {
                        bulan = "Bulan tidak valid";
                    }

                    let status = '';
                    if (row.status !== undefined && row.status !== null) {
                        switch (parseInt(row.status)) {
                            case 1:
                                status = '<span class="badge bg-info">Terjadwal Tahunan</span>';
                                break;
                            case 2:
                                status = '<span class="badge bg-warning">Belum Terlaksana</span>';
                                break;
                            case 3:
                                status = '<span class="badge bg-success">Sudah Terjadwal</span>';
                                break;
                            case 4:
                                status = '<span class="badge bg-success">Finish On Time</span>';
                                break;
                            case 5:
                                status = '<span class="badge bg-danger">Finish On Delay</span>';
                                break;
                            default:
                                status = '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                                break;
                        }
                    } else {
                        status = '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                    }

                    // Menambahkan baris ke table
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${row.tanggal ? new Date(row.tanggal).toLocaleDateString('id-ID') : 'No Set'}</td>
                            <td>${bulan}</td>
                            <td>${row.tahun}</td>
                            <td>${row.dipname ? row.dipname : ''}</td>
                            <td>${row.nama_lini}</td>
                            <td>${row.nama_area}</td>
                            <td>${row.nama_mesin}</td>
                            <td>${status}</td>
                            <td></td>
                            <td></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="checkFile(<?= $row['id_pmm']; ?>)">
                                    <i class="fas fa-file"></i> Check
                                </button>
                                <button class="btn btn-success btn-sm" onclick="printDocument(<?= $row['id_pmm']; ?>)">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#table1-body').html(rows); // UPDATE HANYA TABLE1
        });
    }
</script>

<?php $this->load->view('layouts/footer'); ?>
