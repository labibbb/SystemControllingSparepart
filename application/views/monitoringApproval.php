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
                                    <span class="status-box" style="background-color: darkcyan;"></span> On Waiting Approve Supervisor
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
            events: [
                { title: 'P2 | FLUID CLEAN | SPRAYBOOTH', start: '2025-02-26', color: 'lightseagreen' },
                { title: 'P1 | PIPA MAINLINE HOT WATER', start: '2025-02-27', color: 'lightseagreen' },
                { title: 'P1 | EXHAUST SPRAYBOOTH 3', start: '2025-02-28', color: 'blue' },
                { title: 'P2 | EXHAUST ROOM 2 | SPRAYBOOTH', start: '2025-02-28', color: 'darkcyan' },
                { title: 'P1 | BAKE OVEN | BAKE OVEN', start: '2025-03-02', color: 'blue' },
                { title: 'P1 | SLUDGE SEPARATOR | SPRAY', start: '2025-03-14', color: 'black' }
            ]
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
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    }

    #calendar td, #calendar th {
        border: 1px solid #ddd !important;
        padding: 8px;
    }
</style>

<?php $this->load->view('layouts/footer'); ?>
