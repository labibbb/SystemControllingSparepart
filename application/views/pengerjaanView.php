<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>
<style>
    /* CSS untuk DataTables controls */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: inline-block;
        margin-bottom: 10px;
    }

    .dataTables_wrapper .dataTables_length {
        margin-right: 30px; /* Jarak antara Show Entries dan Search */
    }

    .dataTables_wrapper .dataTables_filter {
        margin-left: 15px;
    }

    .dataTables_wrapper .dataTables_filter input {
        margin-left: 10px;
        width: 180px; /* Lebar input search */
    }

    /* Responsive untuk tablet */
    @media (max-width: 991px) {
        .dataTables_wrapper .dataTables_length {
            margin-right: 20px; /* Jarak lebih kecil di tablet */
        }
        
        .dataTables_wrapper .dataTables_filter input {
            width: 140px; /* Lebar lebih kecil di tablet */
        }
    }

    /* Untuk mobile sangat kecil */
    @media (max-width: 576px) {
        .dataTables_wrapper .dataTables_length {
            margin-right: 15px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            width: 120px;
        }
    }
</style>
<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <!-- Input Filter Tanggal -->
                        <div class="col-md-12 text-center mb-3">
                            <label for="filterTanggalMulai"><strong>Filter Tanggal:</strong></label>
                            <input type="date" id="filterTanggalMulai" class="form-control d-inline-block" style="width: 200px;" value="<?= date('Y-m-01'); ?>">
                            <span class="mx-2">s/d</span>
                            <input type="date" id="filterTanggalSampai" class="form-control d-inline-block" style="width: 200px;" value="<?= date('Y-m-d'); ?>">
                            <button id="btnFilter" class="btn btn-primary ml-2">Filter</button>
                        </div>

                        <!-- Tabel Kiri -->
                        <div class="col-md-6">
                            <h3 class="text-center">Today PM: Painting 1</h3>
                            <div class="table-responsive">
                                <table id="table1" class="table table-bordered table-striped">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Area</th>
                                            <th>Mesin</th>
                                            <th>Check</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table1-body">
                                    <?php $no = 1; ?>
                                    <?php foreach ($pmmonthly as $row): ?>
                                        <?php
                                        // Hitung jumlah pmBefore yang sama dengan id_pmm saat ini
                                        $countSamePmBefore = 0;
                                        foreach ($pmmonthly as $checkRow) {
                                            if ($checkRow['pmBefore'] == $row['id_pmm']) {
                                                $countSamePmBefore++;
                                            }
                                        }
                                        
                                        // Hanya tampilkan jika status 3 atau 4
                                        if (in_array($row['status'], [3, 4])): 
                                            $rowDate = date('Y-m-d', strtotime($row['tanggal']));
                                            $today = date('Y-m-d');
                                            $isFutureDate = $rowDate > $today;
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td class="tanggal"><?= $rowDate; ?></td>
                                                <td><?= $row['nama_area']; ?></td>
                                                <td><?= $row['nama_mesin']; ?></td>
                                                <td>
                                                    <?php if ($isFutureDate): ?>
                                                        <!-- No button for future dates -->
                                                        <span class="text-muted">Belum waktunya</span>
                                                    <?php elseif ($countSamePmBefore > 0): ?>
                                                        <button class="btn btn-danger btn-sm" disabled>Rejected</button>
                                                    <?php elseif ($row['pmBefore'] != null): ?>
                                                        <form action="<?= site_url('pengerjaan/DetailRes'); ?>" method="post">
                                                            <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                            <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                            <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                            <input type="hidden" name="pmBefore" value="<?= $row['pmBefore']; ?>">
                                                            <button type="submit" class="btn btn-warning btn-sm">Ubah</button>
                                                        </form>
                                                    <?php else: ?>
                                                        <form action="<?= site_url('pengerjaan/Detail'); ?>" method="post">
                                                            <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                            <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                            <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                            <button type="submit" class="btn btn-warning btn-sm">Buka</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tabel Kanan -->
                        <div class="col-md-6">
                            <h3 class="text-center">Today PM: Painting 2</h3>
                            <div class="table-responsive">
                                <table id="table2" class="table table-bordered table-striped">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Area</th>
                                            <th>Mesin</th>
                                            <th>Check</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table2-body">
                                        <?php $no = 1; ?>
                                        <?php foreach ($pmmonthly2 as $row): ?>
                                            <?php
                                            // Hitung jumlah pmBefore yang sama dengan id_pmm saat ini
                                            $countSamePmBefore = 0;
                                            foreach ($pmmonthly as $checkRow) {
                                                if ($checkRow['pmBefore'] == $row['id_pmm']) {
                                                    $countSamePmBefore++;
                                                }
                                            }
                                            
                                            // Hanya tampilkan jika status 3 atau 4
                                            if (in_array($row['status'], [3, 4])): 
                                                $rowDate = date('Y-m-d', strtotime($row['tanggal']));
                                                $today = date('Y-m-d');
                                                $isFutureDate = $rowDate > $today;
                                            ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td class="tanggal"><?= $rowDate; ?></td>
                                                    <td><?= $row['nama_area']; ?></td>
                                                    <td><?= $row['nama_mesin']; ?></td>
                                                    <td>
                                                        <?php if ($isFutureDate): ?>
                                                            <!-- No button for future dates -->
                                                            <span class="text-muted">Belum waktunya</span>
                                                        <?php elseif ($countSamePmBefore > 0): ?>
                                                            <button class="btn btn-danger btn-sm" disabled>Rejected</button>
                                                        <?php elseif ($row['pmBefore'] != null): ?>
                                                            <form action="<?= site_url('pengerjaan/DetailRes'); ?>" method="post">
                                                                <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                                <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                                <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                                <input type="hidden" name="pmBefore" value="<?= $row['pmBefore']; ?>">
                                                                <button type="submit" class="btn btn-warning btn-sm">Ubah</button>
                                                            </form>
                                                        <?php else: ?>
                                                            <form action="<?= site_url('pengerjaan/Detail'); ?>" method="post">
                                                                <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                                <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                                <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                                <button type="submit" class="btn btn-warning btn-sm">Buka</button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div> <!-- End Row -->
                </div>
            </div>
            <div class="box-body">
                <div class="row d-flex">
                    <!-- Status Description -->
                    <div class="col-md-3">
                        <div class="card border p-3">
                            <h5>Status Description</h5>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-2">
                                    <span class="status-box" style="background-color: blue;"></span> Belum terlaksana
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <span class="status-box" style="background-color: red;"></span> ⚠️ / Abnormality
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <span class="status-box" style="background-color: orange;"></span> Pengerjaan Delay
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <span style="font-size: 1.2em;">⏳</span> Delay sudah dikerjakan
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <span class="status-box" style="background-color: lightseagreen;"></span> Complete All
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Calendar -->
                    <div class="col-md-9">
                        <div class="card border p-3">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: <?= json_encode(array_map(function ($row) {
                $today = date("Y-m-d");
                $eventDate = date("Y-m-d", strtotime($row["tanggal"]));
                $status = $row["status"];
                
                // Cek kondisi delay
                $isDelayed = (in_array($status, [4, 7, 9, 5, 6,8]) && $eventDate < $today);
                $isAbnormal = (in_array($status, [7, 9]) && $eventDate < $today);
                $isRegularDelay = (in_array($status, [3, 4, 5, 6]) && $eventDate < $today);

                // Tentukan warna berdasarkan status
                if ($isRegularDelay) {
                    $color = "orange"; // Warna untuk delay biasa (status 3,4)
                } elseif ($isAbnormal || $status == 9) {
                    $color = "red"; // Warna untuk abnormality (status 7,9)
                } elseif ($status == 8) {
                    $color = "lightseagreen";
                } else {
                    $color = "blue"; // Default warna biru
                }

                return [
                    "title" => ($isDelayed ? "⏳ " : "") . "P" . $row["id_lini"] . " | " . $row["nama_mesin"],
                    "start" => date("Y-m-d\TH:i:s", strtotime($row["tanggal"])),
                    "allDay" => true,
                    "backgroundColor" => $color,
                    "borderColor" => $isDelayed ? "red" : $color,
                    "textColor" => "white",
                    "id_mesin" => $row["id_mesin"],
                    "tanggal" => $row["tanggal"],
                    "id_pmm" => $row["id_pmm"],
                    "extendedProps" => [
                        "isDelayed" => $isDelayed,
                        "isAbnormal" => $isAbnormal
                    ]
                ];
            }, $pmmonthly3), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            
            eventDidMount: function(info) {
                // Tambahkan tooltip khusus untuk yang delay
                if (info.event.extendedProps.isDelayed) {
                    info.el.setAttribute('title', 'Tugas ini delay (melewati tanggal seharusnya)');
                    info.el.classList.add('delayed-event');
                    
                    // Tambahkan class khusus untuk abnormality
                    if (info.event.extendedProps.isAbnormal) {
                        info.el.classList.add('abnormal-event');
                    }
                }
            },
            
            eventClick: function(info) {
                <?php if ($this->session->userdata('level') == 2): ?>
                    return false;
                <?php else: ?>
                    var form = document.createElement("form");
                    form.action = "<?= site_url('approvalSPV/read'); ?>";
                    form.method = "POST";

                    var id_mesin = document.createElement("input");
                    id_mesin.type = "hidden";
                    id_mesin.name = "id_mesin";
                    id_mesin.value = info.event.extendedProps.id_mesin;
                    form.appendChild(id_mesin);

                    var tanggal = document.createElement("input");
                    tanggal.type = "hidden";
                    tanggal.name = "tanggal";
                    tanggal.value = info.event.extendedProps.tanggal;
                    form.appendChild(tanggal);

                    var id_pmm = document.createElement("input");
                    id_pmm.type = "hidden";
                    id_pmm.name = "id_pmm";
                    id_pmm.value = info.event.extendedProps.id_pmm;
                    form.appendChild(id_pmm);

                    document.body.appendChild(form);
                    form.submit();
                <?php endif; ?>
            }
        });

        calendar.render();
    });
</script>


<style>
    .status-box {
        width: 15px;
        height: 15px;
        display: inline-block;
        margin-right: 10px;
        border-radius: 3px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        padding: 10px;
    }

    #calendar td,
    #calendar th {
        border: 1px solid #ddd !important;
        padding: 8px;
        text-align: center;
        /* Tengahin teks */
    }
</style>

<script>
    $(document).ready(function() {
        var table1 = $('#table1').DataTable({
        "dom": '<"top"lf>rt<"bottom"ip>',
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "search": "Search:",
            "searchPlaceholder": "..."
        },
        "initComplete": function() {
            // Menyesuaikan margin untuk tablet
            if ($(window).width() <= 991) {
                $('.dataTables_length').css('margin-right', '20px');
                $('.dataTables_filter input').css('width', '140px');
            }
        }
    });
    
    var table2 = $('#table2').DataTable({
        "dom": '<"top"lf>rt<"bottom"ip>',
        
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "search": "Search:",
            "searchPlaceholder": "..."
        },
        "initComplete": function() {
            // Menyesuaikan margin untuk tablet
            if ($(window).width() <= 991) {
                $('.dataTables_length').css('margin-right', '20px');
                $('.dataTables_filter input').css('width', '140px');
            }
        }
    })

        // Fungsi filter berdasarkan range tanggal
        function filterByDateRange() {
            var startDate = $('#filterTanggalMulai').val();
            var endDate = $('#filterTanggalSampai').val();

            // Filter Table 1
            table1.rows().every(function() {
                var rowDate = this.data()[1]; // Kolom tanggal (indeks 1)
                var date = new Date(rowDate);
                var start = new Date(startDate);
                var end = new Date(endDate);
                end.setDate(end.getDate() + 1); // Tambah 1 hari untuk mencakup hari terakhir

                if (date >= start && date <= end) {
                    $(this.node()).show();
                } else {
                    $(this.node()).hide();
                }
            });

            // Filter Table 2
            table2.rows().every(function() {
                var rowDate = this.data()[1]; // Kolom tanggal (indeks 1)
                var date = new Date(rowDate);
                var start = new Date(startDate);
                var end = new Date(endDate);
                end.setDate(end.getDate() + 1); // Tambah 1 hari untuk mencakup hari terakhir

                if (date >= start && date <= end) {
                    $(this.node()).show();
                } else {
                    $(this.node()).hide();
                }
            });
        }

        // Panggil filterByDateRange saat halaman dimuat
        filterByDateRange();

        // Event listener ketika tombol filter diklik
        $('#btnFilter').on('click', function() {
            filterByDateRange();
        });

        // Juga bisa di-trigger saat enter di input tanggal
        $('#filterTanggalMulai, #filterTanggalSampai').on('keypress', function(e) {
            if (e.which == 13) {
                filterByDateRange();
            }
        });
    });
</script>

<?php $this->load->view('layouts/footer'); ?>