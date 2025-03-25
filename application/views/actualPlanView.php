<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<style>
    .gantt-container {
        width: 100%;
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }
    th, td {
        border: 1px solid #ddd;
        text-align: center;
        padding: 12px; /* Menambah padding agar lebih lebar */
        min-width: 30px; /* Memberi batasan minimal lebar sel */
    }
    th {
        background-color: #f4f4f4;
        position: sticky;
        top: 0;
        z-index: 2;
    }
    .gantt-bar {
        height: 25px; /* Memperbesar tinggi bar */
        border-radius: 4px;
    }
    .plan { background-color: #3498db; }
    .actual { background-color: #2ecc71; }
    .machine-name {
        font-weight: bold;
    }
    #currentMonth {
    font-size: 1.5rem; /* Perbesar ukuran font */
    font-weight: bold; /* Buat teks tebal */
    margin: 0 10px; /* Beri jarak kiri dan kanan agar tidak terlalu mepet */
}

</style>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Plan and Actual Schedule</h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row d-flex">
                    <div class="text-center mb-3">
                        <button onclick="prevMonth()">⏪ Sebelumnya</button>
                        <span id="currentMonth"></span>
                        <button onclick="nextMonth()">Selanjutnya ⏩</button>
                    </div>

                    <div class="gantt-container">
                        <table id="ganttTable">
                            <thead id="ganttHeader"></thead>
                            <tbody id="ganttBody"></tbody>
                        </table>
                    </div>
                    
                </div>    
            </div>
        </section>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>

<script>
    let currentDate = new Date();

    // Data dummy
    const tasks = [
        { name: "BAKE OVEN", planStart: "2025-03-10", planEnd: "2025-03-10", actualStart: "2025-03-11", actualEnd: "2025-03-11" },
        { name: "CONVEYOR FI", planStart: "2025-01-15", planEnd: "2025-01-17", actualStart: "2025-01-16", actualEnd: "2025-01-18" },
        { name: "CONVEYOR UNLOADING", planStart: "2025-01-19", planEnd: "2025-01-21", actualStart: "2025-01-20", actualEnd: "2025-01-22" },
        { name: "BLOW COOLING 1", planStart: "2025-01-22", planEnd: "2025-01-24", actualStart: "2025-01-23", actualEnd: "2025-01-25" },
        { name: "CONVEYOR LOADING", planStart: "2025-01-28", planEnd: "2025-01-30", actualStart: "2025-01-29", actualEnd: "2025-01-31" }
    ];

    function generateGanttChart() {
        const monthYear = currentDate.toISOString().slice(0, 7); // Format YYYY-MM
        document.getElementById("currentMonth").innerText = new Date(monthYear).toLocaleString('id-ID', { month: 'long', year: 'numeric' });

        const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        
        let headerHtml = `<tr><th>Mesin</th>`; 
        for (let day = 1; day <= daysInMonth; day++) {
            headerHtml += `<th>${String(day).padStart(2, '0')}</th>`; // Menampilkan angka 2 digit
        }
        headerHtml += `</tr>`;
        document.getElementById("ganttHeader").innerHTML = headerHtml;

        let bodyHtml = "";
        tasks.forEach(task => {

            bodyHtml += `<tr><td><strong>${task.name}</strong> (Plan)</td>`;
            for (let day = 1; day <= daysInMonth; day++) {
                const dateString = `${monthYear}-${String(day).padStart(2, '0')}`;
                if (dateString >= task.planStart && dateString <= task.planEnd) {
                    bodyHtml += `<td class="gantt-bar plan"></td>`;
                } else {
                    bodyHtml += `<td></td>`;
                }
            }
            bodyHtml += `</tr>`;

            bodyHtml += `<tr><td><strong>${task.name}</strong> (Aktual)</td>`;
            for (let day = 1; day <= daysInMonth; day++) {
                const dateString = `${monthYear}-${String(day).padStart(2, '0')}`;
                if (dateString >= task.actualStart && dateString <= task.actualEnd) {
                    bodyHtml += `<td class="gantt-bar actual"></td>`;
                } else {
                    bodyHtml += `<td></td>`;
                }
            }
            bodyHtml += `</tr>`;
        });

        document.getElementById("ganttBody").innerHTML = bodyHtml;
    }

    function prevMonth() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        generateGanttChart();
    }

    function nextMonth() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        generateGanttChart();
    }

    document.addEventListener("DOMContentLoaded", generateGanttChart);
</script>
