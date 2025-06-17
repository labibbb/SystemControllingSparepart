<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Monitoring Schedule</h3>
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

<!-- FullCalendar Scripts -->
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
        $preparedDate = !empty($row["preparedDate"]) ? date("Y-m-d", strtotime($row["preparedDate"])) : null;
        
        // Cek apakah tugas dikerjakan terlambat (preparedDate > tanggal seharusnya)
        $isDelayed = ($preparedDate && $preparedDate > $eventDate);
        
        // Cek kondisi status untuk warna
        $isAbnormal = in_array($status, [7, 9]);
        $isRegularDelay = in_array($status, [3, 4, 5, 6]);
        $isComplete = ($status == 8);
        $isPastDue = ($eventDate < $today); // Cek jika tanggal sudah lewat

        // Tentukan warna berdasarkan status
        if ($isRegularDelay) {
            // Untuk status 5 dan 6, hanya berwarna orange jika memang delayed (preparedDate > eventDate)
            if (in_array($status, [5, 6])) {
                $color = $isDelayed ? "orange" : "blue";
            } else {
                // Untuk status 3 dan 4, tetap menggunakan logika sebelumnya
                $color = $isPastDue ? "orange" : "blue";
            }
        } elseif ($isAbnormal) {
            $color = "red"; // Warna untuk abnormality (status 7,9)
        } elseif ($isComplete) {
            $color = "lightseagreen"; // Warna untuk complete (status 8)
        } else {
            $color = "blue"; // Default (status lain/belum dikerjakan)
        }

    return [
        "title" => ($isDelayed ? "⏳ " : "") . "P" . $row["id_lini"] . " | " . $row["nama_mesin"],
        "start" => $eventDate,
        "allDay" => true,
        "backgroundColor" => $color,
        "borderColor" => $isDelayed ? "red" : $color,
        "textColor" => "white",
        "id_mesin" => $row["id_mesin"],
        "tanggal" => $row["tanggal"],
        "id_pmm" => $row["id_pmm"],
        "extendedProps" => [
            "isDelayed" => $isDelayed,
            "isAbnormal" => $isAbnormal,
            "preparedDate" => $preparedDate,
            "isPastDue" => $isPastDue
        ]
    ];
}, $pmmonthly), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        
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
        
        // eventClick: function(info) {
        //     <?php if ($this->session->userdata('level') == 2): ?>
        //         return false;
        //     <?php else: ?>
        //         var form = document.createElement("form");
        //         form.action = "<?= site_url('approvalSPV/read'); ?>";
        //         form.method = "POST";

        //         var id_mesin = document.createElement("input");
        //         id_mesin.type = "hidden";
        //         id_mesin.name = "id_mesin";
        //         id_mesin.value = info.event.extendedProps.id_mesin;
        //         form.appendChild(id_mesin);

        //         var tanggal = document.createElement("input");
        //         tanggal.type = "hidden";
        //         tanggal.name = "tanggal";
        //         tanggal.value = info.event.extendedProps.tanggal;
        //         form.appendChild(tanggal);

        //         var id_pmm = document.createElement("input");
        //         id_pmm.type = "hidden";
        //         id_pmm.name = "id_pmm";
        //         id_pmm.value = info.event.extendedProps.id_pmm;
        //         form.appendChild(id_pmm);

        //         document.body.appendChild(form);
        //         form.submit();
        //     <?php endif; ?>
        // }
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
