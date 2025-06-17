<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Schedule PM Monthly</h3>
                    <div class="mt-2">
                        <select id="id_lini" class="form-control" required style="width: 300px;">
                            <?php foreach ($lini as $l): ?>
                                <option value="<?= $l['id_lini']; ?>"><?= $l['nama_lini']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select id="id_area" class="form-control" required style="width: 200px;" disabled>
            <option value="">Pilih Area</option>
        </select>
        
        <select id="id_mesin" class="form-control" required style="width: 200px;" disabled>
            <option value="">Pilih Mesin</option>
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
                                        <td><?= $row['user_name']; ?></td>
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
                                                    echo '<span class="badge bg-warning">Sudah Terjadwal</span>';
                                                    break;
                                                case 3:
                                                    echo '<span class="badge bg-success">Sudah Terjadwal</span>';
                                                    break;
                                                case 4:
                                                    echo '<span class="badge bg-warning">On Progress Checking</span>';
                                                    break;
                                                case 5:
                                                    echo '<span class="badge bg-warning">Waiting Approval Foreman</span>';
                                                    break;
                                                case 6:
                                                    echo '<span class="badge bg-success">Waiting Approval Supervisor</span>';
                                                    break;
                                                case 7:
                                                    echo '<span class="badge bg-danger">Rejected by Foreman</span>';
                                                    break;
                                                case 8:
                                                    echo '<span class="badge bg-success">Complete All</span>';
                                                    break;
                                                case 9:
                                                    echo '<span class="badge bg-danger">Rejected by Superviosr</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td><?= $row['foreman_name']; ?></td>
                                        <td><?= $row['supervisor_name']; ?></td>
                                        <?php if ($row['status'] == 1): ?>
                                            <td>
                                                <button class="btn btn-success btn-sm" onclick="editTanggalStatus(<?= $row['id_pmm']; ?>, <?= $row['bulan']; ?>, <?= $row['tahun']; ?>)">Setting</button>
                                            </td>
                                        <?php elseif (in_array($row['status'], [2, 3])): ?>
                                            <td>
                                                <button class="btn btn-warning btn-sm" onclick="editTanggal(<?= $row['id_pmm']; ?>, '<?= date('Y-m-d', strtotime($row['tanggal'])); ?>', '<?= $row['catatan']; ?>', <?= $row['bulan']; ?>, <?= $row['tahun']; ?>)">Tgl</button>
                                                <button class="btn btn-warning btn-sm" onclick="editMP(<?= $row['id_pmm']; ?>)">MP</button>
                                            </td>
                                        <?php elseif (in_array($row['status'], [7, 9])): ?>
                                            <td>
                                        <?php if($row['statusresc'] != 10): ?>
                                            <button class="btn btn-warning btn-sm" onclick="editTanggal2(<?= $row['id_pmm']; ?>, '<?= date('Y-m-d', strtotime($row['tanggal'])); ?>', '<?= $row['catatan']; ?>', <?= $row['bulan']; ?>, <?= $row['tahun']; ?>)">Tgl</button>
                                        <?php else: ?>
                                            <?php
                                        $rescheduled_date = $this->PmMonthly_model->get_rescheduled_date($row['id_pmm']);
                                        ?>
                                        <span class="badge bg-secondary">
                                            Telah Direschedule
                                            <?= $rescheduled_date ? "(" . date('d M Y', strtotime($rescheduled_date)) . ")" : "" ?>
                                        </span>
                                    <?php endif; ?>
                                    </td>   
                                        <?php else: ?>
                                            <td class="bg-secondary text-white text-center">No Action</td>
                                        <?php endif; ?>
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

<div id="modalTanggal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update PM Monthly</h5>
                <button type="button" class="close" onclick="$('#modalMP').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="tanggalUpdate" action="<?= base_url('pmmonthly/update_tanggal2') ?>" method="post">
                    <input type="hidden" name="id_pmm" id="id_pmm_tgl">
                    <input type="hidden" name="bulanU" id="bulanU">
                    <input type="hidden" name="tahunU" id="tahunU">
                    
                    <div class="form-group">
                        <label for="tanggal_tgllama">Tanggal lama</label>
                        <input type="date" id="tanggal_tgllama" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal Baru</label>
                        <input type="date" name="tanggal" id="tanggal_tgl" class="form-control">
                    </div>

                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modalTanggal2" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update PM Monthly</h5>
                <button type="button" class="close" onclick="$('#modalMP').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="tanggalUpdate" action="<?= base_url('pmmonthly/update_tanggal3') ?>" method="post">
                    <input type="hidden" name="id_pmm" id="id_pmm_tgl2">
                    <input type="hidden" name="bulanU" id="bulanU2">
                    <input type="hidden" name="tahunU" id="tahunU2">
                    
                    <div class="form-group">
                        <label for="tanggal_tgllama2">Tanggal lama</label>
                        <input type="date" id="tanggal_tgllama2" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal Baru</label>
                        <input type="date" name="tanggal" id="tanggal_tgl2" class="form-control">
                    </div>

                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modalTanggalStatus" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update PM Monthly</h5>
                <button type="button" class="close" onclick="$('#modalMP').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="tanggalStatus" action="<?= base_url('pmmonthly/update_tanggal') ?>" method="post">
                    <input type="hidden" name="id_pmm" id="id_pmm_tglstts">
                    <input type="hidden" name="bulan" id="bulan">
                    <input type="hidden" name="tahun" id="tahun">
                    
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control">
                    </div>

                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update MP -->
<div id="modalMP" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update PM Monthly</h5>
                <button type="button" class="close" onclick="$('#modalMP').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('pmmonthly/update_mp') ?>" method="post">
                    <input type="hidden" name="id_pmm" id="id_pmm_mp">
                    
                    <div class="form-group">
                        <label for="id_users">MP</label>
                        <select name="id_users" id="id_users" class="form-control">
                            <?php foreach ($manpower as $mp): ?>
                                <option value="<?= $mp['id_users']; ?>"><?= $mp['dipname']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("tanggalStatus").addEventListener("submit", function (event) {
        event.preventDefault(); // Mencegah submit langsung

        let tanggalInput = document.getElementById("tanggal");
        let bulan = document.getElementById("bulan").value;
        let tahun = document.getElementById("tahun").value;
        if (!tanggalInput.value) {
            Swal.fire({
                icon: "warning",
                title: "Isi Semua Data",
                text: "Tanggal tidak boleh kosong!",
            });
            return;
        }

        let selectedDate = new Date(tanggalInput.value);
        let selectedMonth = selectedDate.getMonth() + 1; // JS bulan dari 0
        let selectedYear = selectedDate.getFullYear();

        if (selectedYear != tahun || selectedMonth != bulan) {
            Swal.fire({
                icon: "warning",
                title: "Error",
                text: "Tanggal harus berada pada bulan dan tahun yang dipilih!",
            });
            return;
        }

        Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: "Data berhasil disimpan!",
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            event.target.submit(); // Submit form setelah validasi lolos
        });
    });

    document.getElementById("tanggalUpdate").addEventListener("submit", function (event) {
        event.preventDefault(); // Mencegah submit langsung

        let tanggalInput = document.getElementById("tanggal_tgl");
        let bulan = document.getElementById("bulanU").value;
        let tahun = document.getElementById("tahunU").value;
        if (!tanggalInput.value) {
            Swal.fire({
                icon: "warning",
                title: "Isi Semua Data",
                text: "Tanggal tidak boleh kosong!",
            });
            return;
        }

        let selectedDate = new Date(tanggalInput.value);
        let selectedMonth = selectedDate.getMonth() + 1; // JS bulan dari 0
        let selectedYear = selectedDate.getFullYear();

        if (selectedYear != tahun || selectedMonth != bulan) {
            Swal.fire({
                icon: "warning",
                title: "Error",
                text: "Tanggal harus berada pada bulan dan tahun yang dipilih!",
            });
            return;
        }

        Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: "Data berhasil disimpan!",
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            event.target.submit(); // Submit form setelah validasi lolos
        });
    });
});
</script>

<script>
    function editTanggal(id, tanggal, catatan, bulan, tahun) {
        document.getElementById("id_pmm_tgl").value = id;
        document.getElementById("tanggal_tgllama").value = tanggal;
        document.getElementById("bulanU").value = bulan;
        document.getElementById("tahunU").value = tahun;
        $('#modalTanggal').modal('show');
    }

    function editTanggal2(id, tanggal, catatan, bulan, tahun) {
    document.getElementById("id_pmm_tgl2").value = id;
    document.getElementById("tanggal_tgllama2").value = tanggal;
    document.getElementById("bulanU2").value = bulan;
    document.getElementById("tahunU2").value = tahun;

    $('#modalTanggal2 form').off('submit').on('submit', function(e) {
        e.preventDefault();
        
        let tanggalInput = document.getElementById("tanggal_tgl2");
        let tanggalLama = document.getElementById("tanggal_tgllama2").value;
        let today = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
        
        // Validasi 1: Tanggal tidak boleh kosong
        if (!tanggalInput.value) {
            Swal.fire({
                icon: "warning",
                title: "Isi Semua Data",
                text: "Tanggal tidak boleh kosong!",
            });
            return;
        }
                // Validasi 3: Tanggal baru tidak boleh sama dengan tanggal lama
        if (tanggalInput.value === tanggalLama) {
            Swal.fire({
                icon: "warning",
                title: "Tanggal Tidak Valid",
                text: "Tanggal baru tidak boleh sama dengan tanggal lama!",
            });
            return;
        }


        // // Validasi 2: Tanggal baru tidak boleh sama dengan hari ini
        // if (tanggalInput.value === today) {
        //     Swal.fire({
        //         icon: "warning",
        //         title: "Tanggal Tidak Valid",
        //         text: "Tanggal baru tidak boleh sama dengan hari ini!",
        //     });
        //     return;
        // }

        // Validasi 3: Tanggal baru tidak boleh kurang dari tanggal lama
        if (new Date(tanggalInput.value) < new Date(tanggalLama)) {
            Swal.fire({
                icon: "warning",
                title: "Tanggal Tidak Valid",
                text: "Tanggal baru tidak boleh kurang dari tanggal lama!",
            });
            return;
        }
        

        let selectedDate = new Date(tanggalInput.value);
        let selectedMonth = selectedDate.getMonth() + 1; // JS bulan dari 0
        let selectedYear = selectedDate.getFullYear();

        if (selectedYear != tahun || selectedMonth != bulan) {
            Swal.fire({
                icon: "warning",
                title: "Error",
                text: "Tanggal harus berada pada bulan dan tahun yang dipilih!",
            });
            return;
        }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#modalTanggal2').modal('hide');
                
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Penjadwalan ulang berhasil dilakukan!",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            },
            error: function() {
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: "Terjadi kesalahan saat menyimpan data",
                });
            }
        });
    }); 
    
    $('#modalTanggal2').modal('show');
}

    function editMP(id) {
        document.getElementById("id_pmm_mp").value = id;
        $('#modalMP').modal('show'); // Menggunakan Bootstrap modal
    }


    function editTanggalStatus(id, bulan, tahun) {
        document.getElementById("id_pmm_tglstts").value = id;
        document.getElementById("bulan").value = bulan;
        document.getElementById("tahun").value = tahun;
        $('#modalTanggalStatus').modal('show'); // Menggunakan Bootstrap modal
    }

    $(document).ready(function() {
    // Handle perubahan lini
    $('#id_lini').on('change', function() {
        let id_lini = $(this).val();
        
        // Reset dan disable area dan mesin
        $('#id_area').val('').prop('disabled', !id_lini);
        $('#id_mesin').val('').prop('disabled', true);
        
        if (id_lini) {
            // Load area berdasarkan lini
            $.post("<?= base_url('pmmonthly/get_area_options') ?>", {id_lini: id_lini}, function(data) {
                let options = '<option value="">Pilih Area</option>';
                $.each(JSON.parse(data), function(index, area) {
                    options += `<option value="${area.id_area}">${area.nama_area}</option>`;
                });
                $('#id_area').html(options).prop('disabled', false);
            });
            
            filterData();
        } else {
            filterData();
        }
    });
    
    // Handle perubahan area
    $('#id_area').on('change', function() {
        let id_area = $(this).val();
        
        // Reset dan disable mesin
        $('#id_mesin').val('').prop('disabled', !id_area);
        
        if (id_area) {
            // Load mesin berdasarkan area
            $.post("<?= base_url('pmmonthly/get_mesin_options') ?>", {id_area: id_area}, function(data) {
                let options = '<option value="">Pilih Mesin</option>';
                $.each(JSON.parse(data), function(index, mesin) {
                    options += `<option value="${mesin.id_mesin}">${mesin.nama_mesin}</option>`;
                });
                $('#id_mesin').html(options).prop('disabled', false);
            });
            
            filterData();
        } else {
            filterData();
        }
    });
    
    // Handle perubahan mesin
    $('#id_mesin').on('change', filterData);
});

    function filterData() {
    $.post("<?= base_url('pmmonthly/filter') ?>", {
        lini: $('#id_lini').val(),
        area: $('#id_area').val(),
        mesin: $('#id_mesin').val()
    }, function (data) {
        let rows = '';
        let result = JSON.parse(data);

        if (result.length === 0) {
            rows = `<tr>
                <td colspan="12" class="text-center text-danger">Data Tidak Ditemukan</td>
            </tr>`;
        } else {
            result.forEach((row, index) => {
                // Format bulan
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

                // Format status
                let status = '';
                if (row.status !== undefined && row.status !== null) {
                    switch (parseInt(row.status)) {
                        case 1: status = '<span class="badge bg-info">Terjadwal Tahunan</span>'; break;
                        case 2: status = '<span class="badge bg-warning">Sudah Terjadwal</span>'; break;
                        case 3: status = '<span class="badge bg-success">Sudah Terjadwal</span>'; break;
                        case 4: status = '<span class="badge bg-warning">On Progress Checking</span>'; break;
                        case 5: status = '<span class="badge bg-warning">Waiting Approval Foreman</span>'; break;
                        case 6: status = '<span class="badge bg-success">Waiting Approval Supervisor</span>'; break;
                        case 7: status = '<span class="badge bg-danger">Rejected by Foreman</span>'; break;
                        case 8: status = '<span class="badge bg-success">Complete All</span>'; break;
                        case 9: status = '<span class="badge bg-danger">Rejected by Supervisor</span>'; break;
                        default: status = '<span class="badge bg-secondary">Status Tidak Diketahui</span>'; break;
                    }
                } else {
                    status = '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                }

                // Format tanggal untuk tampilan di tabel
                let formattedDate = 'No Set';
                if (row.tanggal) {
                    let dateObj = new Date(row.tanggal);
                    formattedDate = dateObj.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                }

                // Format tanggal untuk modal (YYYY-MM-DD)
                let modalDate = row.tanggal ? new Date(row.tanggal).toISOString().split('T')[0] : '';

                // Menentukan aksi yang tersedia
                let actionCell = '';
                if (row.status == 1) {
                    actionCell = `
                        <td>
                            <button class="btn btn-success btn-sm" onclick="editTanggalStatus(${row.id_pmm}, ${row.bulan}, ${row.tahun})">Setting</button>
                        </td>
                    `;
                } else if (row.status == 2 || row.status == 3) {
                    actionCell = `
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editTanggal(${row.id_pmm}, '${modalDate}', '${row.catatan ? row.catatan.replace(/'/g, "\\'") : ''}', ${row.bulan}, ${row.tahun})">Tgl</button>
                            <button class="btn btn-warning btn-sm" onclick="editMP(${row.id_pmm})">MP</button>
                        </td>
                    `;
                } else if (row.status == 7 || row.status == 9) {
                    if (row.statusresc != 10) {
                        actionCell = `
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editTanggal2(${row.id_pmm}, '${modalDate}', '${row.catatan ? row.catatan.replace(/'/g, "\\'") : ''}', ${row.bulan}, ${row.tahun})">Tgl</button>
                            </td>
                        `;
                    } else {
                         // Format tanggal reschedule
                        let rescheduleDate = row.rescheduled_date ? 
                            new Date(row.rescheduled_date).toLocaleDateString('id-ID', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            }) : '';
                            
                        actionCell = `
                            <td>
                                <span class="badge bg-secondary reschedule-badge" data-id="${row.id_pmm}">
                                    Telah Direschedule ${rescheduleDate ? '('+rescheduleDate+')' : ''}
                                </span>
                            </td>
                        `;
                    }
                } else {
                    actionCell = `
                        <td class="bg-secondary text-white text-center">No Action</td>
                    `;
                }

                // Membuat baris tabel
                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${formattedDate}</td>
                        <td>${bulan}</td>
                        <td>${row.tahun}</td>
                        <td>${row.user_name ? row.user_name : ''}</td>
                        <td>${row.nama_lini}</td>
                        <td>${row.nama_area}</td>
                        <td>${row.nama_mesin}</td>
                        <td>${status}</td>
                        <td>${row.foreman_name ? row.foreman_name : ''}</td>
                        <td>${row.supervisor_name ? row.supervisor_name : ''}</td>
                        ${actionCell}
                    </tr>
                `;
            });
        }

        $('#table1-body').html(rows);
    });
}
</script>

<?php $this->load->view('layouts/footer'); ?>