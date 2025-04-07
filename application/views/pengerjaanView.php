<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <!-- Input Filter Tanggal -->
                        <div class="col-md-12 text-center mb-3">
                            <label for="filterTanggal"><strong>Filter Tanggal:</strong></label>
                            <input type="date" id="filterTanggal" class="form-control d-inline-block" style="width: 200px;" value="<?= date('Y-m-d'); ?>">
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
                                        <?php $no = 1; foreach ($pmmonthly as $row): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td class="tanggal"><?= date('Y-m-d', strtotime($row['tanggal'])); ?></td>
                                                <td><?= $row['nama_area']; ?></td>
                                                <td><?= $row['nama_mesin']; ?></td>
                                                <td>
                                                    <?php if (in_array($row['status'], [3, 4, 7])): ?>
                                                        <form action="<?= site_url('pengerjaan/Detail'); ?>" method="post">
                                                            <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                            <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                            <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                            <button type="submit" class="btn btn-warning btn-sm">Buka</button>
                                                        </form>
                                                    <?php elseif (in_array($row['status'], [5, 6])): ?>
                                                        <button class="btn btn-secondary btn-sm" disabled>Menunggu Approval</button>
                                                    <?php elseif ($row['status'] == 8): ?>
                                                        <button class="btn btn-primary btn-sm" disabled>Complete All</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
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
                                        <?php $no = 1; foreach ($pmmonthly2 as $row): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td class="tanggal"><?= date('Y-m-d', strtotime($row['tanggal'])); ?></td>
                                                <td><?= $row['nama_area']; ?></td>
                                                <td><?= $row['nama_mesin']; ?></td>
                                                <td>
                                                    <?php if (in_array($row['status'], [3, 4, 7])): ?>
                                                        <form action="<?= site_url('pengerjaan/Detail'); ?>" method="post">
                                                            <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                            <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                            <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                            <button type="submit" class="btn btn-warning btn-sm">Buka</button>
                                                        </form>
                                                    <?php elseif (in_array($row['status'], [5, 6])): ?>
                                                        <button class="btn btn-secondary btn-sm" disabled>Menunggu Approval</button>
                                                    <?php elseif ($row['status'] == 8): ?>
                                                        <button class="btn btn-primary btn-sm" disabled>Complete All</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
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
                                    <span class="status-box" style="background-color: orange;"></span> Delay / Reschedule
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
                return [
                    "title" => "P" . $row["id_lini"] . " | " . $row["nama_mesin"],
                    "start" => date("Y-m-d\TH:i:s", strtotime($row["tanggal"])),
                    "allDay" => true,
                    "backgroundColor" => 
                    ($row["status"] == 3) ? "blue" : 
                    (($row["status"] == 4 || $row["status"] == 5) ? "blue" :  
                    (($row["status"] == 6) ? "darkcyan" :  
                    (($row["status"] == 7) ? "red" :  
                    (($row["status"] == 8) ? "lightseagreen" : "gray")))),
                    "id_mesin" => $row["id_mesin"],
                    "tanggal" => $row["tanggal"],
                    "id_pmm" => $row["id_pmm"]
                ];
            }, $pmmonthly3), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
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

    #calendar td, #calendar th {
        border: 1px solid #ddd !important;
        padding: 8px;
        text-align: center; /* Tengahin teks */
    }
</style>

<script>
    $(document).ready(function() {
        var table1 = $('#table1').DataTable();
        var table2 = $('#table2').DataTable();

        // Fungsi filter berdasarkan tanggal
        function filterByDate() {
            var selectedDate = $('#filterTanggal').val();
            
            // Filter Table 1
            table1.column(1).search(selectedDate).draw();

            // Filter Table 2
            table2.column(1).search(selectedDate).draw();
        }

        // Panggil filterByDate saat halaman dimuat
        filterByDate();

        // Event listener ketika tanggal diubah
        $('#filterTanggal').on('change', function() {
            filterByDate();
        });
    });
</script>

<?php $this->load->view('layouts/footer'); ?>
