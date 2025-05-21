<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Monitoring Approval</h3>
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
                                    <span class="status-box" style="background-color: black;"></span> On Progress Checking
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <span class="status-box" style="background-color: blue;"></span> On Waiting Approve Foreman
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <span class="status-box" style="background-color: red;"></span> Data Reject / Waiting Revision
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <span class="status-box" style="background-color: purple;"></span> On Waiting Approve Supervisor
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

<!-- FullCalendar Scripts -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: <?= json_encode(array_map(function ($row) {
                  // Skip events with status 3
                return [
                    "title" => "P" . $row["id_lini"] . " | " . $row["nama_mesin"],
                    "start" => date("Y-m-d\TH:i:s", strtotime($row["tanggal"])),
                    "allDay" => true,
                    "backgroundColor" => 
                        $row["status"] == 4 ? "black" :
                        ($row["status"] == 3 ? "black" :  
                        ($row["status"] == 5 ? "blue" : 
                        ($row["status"] == 6 ? "purple" : 
                        ($row["status"] == 7 ? "red" :
                        ($row["status"] == 9 ? "red" :   
                        ($row["status"] == 8 ? "lightseagreen" : "gray")))))),
                    "id_mesin" => $row["id_mesin"],
                    "tanggal" => $row["tanggal"],
                    "id_pmm" => $row["id_pmm"]
                ];
            }, $pmmonthly), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,

                eventClick: function(info) {
                // Cek level user dari PHP session
                <?php if ($this->session->userdata('level') == 2): ?>
                    // Jika level 2, tidak melakukan apa-apa (nonaktifkan klik)
                    return false;
                <?php else: ?>
                // Buat form secara dinamis
                var form = document.createElement("form");
                form.action = "<?= site_url('approvalSPV/read'); ?>";
                form.method = "POST";

                // Tambahkan input hidden untuk data yang dikirim
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

                // Tambahkan form ke body dan submit
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

    #calendar td, #calendar th {
        border: 1px solid #ddd !important;
        padding: 8px;
        text-align: center; /* Tengahin teks */
    }
</style>

<?php $this->load->view('layouts/footer'); ?>
