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
        padding: 12px;
        min-width: 30px;
    }
    th {
        background-color: #f4f4f4;
        position: sticky;
        top: 0;
        z-index: 2;
    }
    .gantt-bar {
        height: 25px;
        border-radius: 4px;
    }
    .plan { background-color: #3498db; }
    .actual { background-color: #e74c3c; }
    .machine-name {
        font-weight: bold;
    }
    .legend {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        gap: 20px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
    }
</style>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Plan and Actual Schedule Painting 2</h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row d-flex">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <label for="yearFilter" class="me-2 fw-bold text-primary fs-4">📅 Pilih Tahun:</label>
                        <select id="yearFilter" class="form-select w-auto shadow-sm border-primary fs-5" onchange="generateGanttChart()">
                        </select>
                    </div>
                    <div class="gantt-container">
                        <table id="ganttTable">
                            <thead id="ganttHeader"></thead>
                            <tbody id="ganttBody"></tbody>
                        </table>
                    </div>
                    <!-- Legend Section -->
                    <div class="legend">
                        <div class="legend-item">
                            <div class="legend-color plan"></div>
                            <span>Plan</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color actual"></div>
                            <span>Actual</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>

<script>
    let currentYear = new Date().getFullYear();

    // Mengelompokkan data berdasarkan id_mesin
    const groupedTasks = {};

    <?php echo json_encode($pmmonthly); ?>.forEach(item => {
        const idMesin = item.id_mesin;
        if (!groupedTasks[idMesin]) {
            groupedTasks[idMesin] = {
                name: item.nama_mesin,
                planDates: new Set(),
                actualDates: new Set()
            };
        }
        if (item.tanggal) groupedTasks[idMesin].planDates.add(formatDate(item.tanggal));
        if (item.approveDate) groupedTasks[idMesin].actualDates.add(formatDate(item.approveDate));
    });

    // Konversi ke array untuk pemetaan data lebih lanjut
    const tasks = Object.values(groupedTasks).map(task => ({
        name: task.name,
        planDates: Array.from(task.planDates).sort(),
        actualDates: Array.from(task.actualDates).sort()
    }));

    // Fungsi untuk format tanggal menjadi "YYYY-MM-DD"
    function formatDate(dateString) {
        if (!dateString) return null;
        const date = new Date(dateString);
        if (isNaN(date)) return null;
        return date.toISOString().split('T')[0];
    }

    function generateGanttChart() {
        currentYear = document.getElementById("yearFilter").value;
        let headerHtml = `<tr><th>Mesin</th>`;
        let weeks = {};

        // Mengelompokkan hari dalam minggu
        for (let month = 0; month < 12; month++) {
            let daysInMonth = new Date(currentYear, month + 1, 0).getDate();
            let weekCounter = 1;

            for (let day = 1; day <= daysInMonth; day++) {
                let weekLabel = `${new Date(currentYear, month, day).toLocaleString('id-ID', { month: 'long' })} W${weekCounter}`;
                if (!weeks[weekLabel]) {
                    weeks[weekLabel] = [];
                }
                weeks[weekLabel].push(day);
                if (new Date(currentYear, month, day).getDay() === 6) {
                    weekCounter++;
                }
            }
        }

        // Membuat header tabel
        for (let week in weeks) {
            headerHtml += `<th colspan="${weeks[week].length}">${week}</th>`;
        }
        headerHtml += `</tr><tr><th></th>`;
        for (let week in weeks) {
            weeks[week].forEach(day => {
                headerHtml += `<th>${String(day).padStart(2, '0')}</th>`;
            });
        }
        headerHtml += `</tr>`;
        document.getElementById("ganttHeader").innerHTML = headerHtml;

        let bodyHtml = "";
        tasks.forEach(task => {
            bodyHtml += `<tr><td><strong>${task.name}</strong> (Plan)</td>`;
            for (let month = 0; month < 12; month++) {
                let daysInMonth = new Date(currentYear, month + 1, 0).getDate();
                for (let day = 1; day <= daysInMonth; day++) {
                    let dateString = `${currentYear}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    bodyHtml += (task.planDates.includes(dateString)) ? `<td class="gantt-bar plan"></td>` : `<td></td>`;
                }
            }
            bodyHtml += `</tr>`;

            bodyHtml += `<tr><td><strong>${task.name}</strong> (Aktual)</td>`;
            for (let month = 0; month < 12; month++) {
                let daysInMonth = new Date(currentYear, month + 1, 0).getDate();
                for (let day = 1; day <= daysInMonth; day++) {
                    let dateString = `${currentYear}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    bodyHtml += (task.actualDates.includes(dateString)) ? `<td class="gantt-bar actual"></td>` : `<td></td>`;
                }
            }
            bodyHtml += `</tr>`;
        });
        document.getElementById("ganttBody").innerHTML = bodyHtml;
    }

    function populateYearDropdown() {
        let yearDropdown = document.getElementById("yearFilter");
        let currentYear = new Date().getFullYear();
        for (let i = currentYear - 5; i <= currentYear + 5; i++) {
            let option = document.createElement("option");
            option.value = i;
            option.text = i;
            if (i === currentYear) option.selected = true;
            yearDropdown.appendChild(option);
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        populateYearDropdown();
        generateGanttChart();
    });
</script>