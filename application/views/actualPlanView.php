<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<style>
    .gantt-container {
        width: 100%;
        overflow-x: auto;
        position: relative;
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
    
    /* Sticky first column */
    th:first-child,
    td:first-child {
        position: sticky;
        left: 0;
        z-index: 1;
        background-color: white;
    }
    
    
    /* Sticky header first column */
    th:first-child {
        z-index: 3;
        background-color: #f4f4f4;
    }
    
    .gantt-bar {
        height: 25px;
        border-radius: 4px;
    }
    
    .plan { background-color: #3498db; }
    .actual { background-color: #e74c3c; }
    
    .machine-name {
        font-weight: bold;
        white-space: nowrap;
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
    /* Tambahkan ke bagian style */
    .achievement-cell {
        font-weight: bold;
        color: white;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.5);
    }
        /* Tambahkan di bagian style */
    .plan-count {
        background-color: #e3f2fd; /* Warna biru muda */
        font-weight: bold;
    }

    .actual-count {
        background-color: #ffebee; /* Warna merah muda */
        font-weight: bold;
    }
</style>
<style>
    /* Update the chart styles */
    .achievement-chart {
        margin-top: 30px;
        width: 100%;
        height: 350px; /* Slightly taller to accommodate more labels */
        background-color: white;
        border: 1px solid #ddd;
        padding: 20px;
        box-sizing: border-box;
        overflow-x: auto;
    }
    
    .chart-container {
        width: max-content;
        min-width: 100%;
        height: 100%;
        position: relative;
        display: flex;
    }
    
    .chart-column {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-right: 5px;
        min-width: 40px;
    }
    
    .chart-bar-container {
        flex-grow: 1;
        display: flex;
        align-items: flex-end;
        height: 200px;
        width: 100%;
    }
    
    .chart-bar {
        width: 30px;
        background-color: #3498db;
        position: relative;
        transition: height 0.3s ease;
    }
    
    .chart-label {
        margin-top: 5px;
        text-align: center;
        font-size: 11px;
        white-space: nowrap;
        writing-mode: vertical-rl;
        transform: rotate(180deg);
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .chart-value {
        position: absolute;
        top: -25px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 11px;
        font-weight: bold;
    }
    
    .chart-axis {
        position: absolute;
        bottom: 40px;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: #333;
    }
    
    .chart-y-labels {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 40px;
        width: 40px;
    }
    
    .chart-y-label {
        position: absolute;
        right: 5px;
        transform: translateY(50%);
        font-size: 11px;
    }
    
    .month-separator {
        border-left: 2px dashed #999;
        height: 100%;
        margin: 0 10px;
    }
    
    .month-label {
        text-align: center;
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 12px;
        white-space: nowrap;
    }
</style>


<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Plan and Actual Schedule Painting 1</h3>
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
        <!-- Tempatkan diagram achievement di sini -->
        <div class="achievement-chart">
            <h4 style="text-align: center; margin-bottom: 15px;">Achievement PM Overview</h4>
            <div class="chart-container" id="achievementChart"></div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>

<script>
    let currentYear = new Date().getFullYear();

    // Mengelompokkan data berdasarkan id_mesin
    const groupedTasks = {};
// nii bagian nge get datanya disini gais pmmonthly
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
        const achievementData = calculateAchievement();
       

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
        addAchievementRow(achievementData);
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
    // Tambahkan fungsi untuk menghitung achievement
function calculateAchievement() {
    const year = parseInt(document.getElementById("yearFilter").value);
    const achievementData = {};
    
    // Inisialisasi struktur data untuk achievement
    const months = Array.from({length: 12}, (_, i) => i);
    months.forEach(month => {
        achievementData[month] = {};
        const weeksInMonth = getWeeksInMonth(year, month);
        weeksInMonth.forEach(week => {
            achievementData[month][week] = { plan: 0, actual: 0 };
        });
    });

    // Hitung plan dan actual per minggu
    Object.values(tasks).forEach(task => {
        // Hitung plan
        task.planDates.forEach(dateStr => {
            const date = new Date(dateStr);
            if (date.getFullYear() === year) {
                const month = date.getMonth();
                const week = getWeekOfMonth(date);
                achievementData[month][week].plan++;
            }
        });
        
        // Hitung actual
        task.actualDates.forEach(dateStr => {
            const date = new Date(dateStr);
            if (date.getFullYear() === year) {
                const month = date.getMonth();
                const week = getWeekOfMonth(date);
                achievementData[month][week].actual++;
            }
        });
    });

    return achievementData;
}

// Fungsi helper untuk mendapatkan minggu dalam bulan
function getWeekOfMonth(date) {
    const firstDay = new Date(date.getFullYear(), date.getMonth(), 1).getDay();
    return Math.ceil((date.getDate() + firstDay) / 7);
}

// Fungsi helper untuk mendapatkan jumlah minggu dalam bulan
function getWeeksInMonth(year, month) {
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const weeks = [];
    
    let currentWeek = 1;
    for (let day = 1; day <= lastDay.getDate(); day++) {
        const currentDate = new Date(year, month, day);
        if (currentDate.getDay() === 0 || day === lastDay.getDate()) {
            weeks.push(currentWeek);
            currentWeek++;
        }
    }
    
    return weeks;
}

// Tambahkan baris achievement ke tabel
function addAchievementRow(achievementData) {
    const year = parseInt(document.getElementById("yearFilter").value);
    let planHtml = `<tr><td><strong>Plan Item PM</strong></td>`;
    let actualHtml = `<tr><td><strong>Actual Item PM</strong></td>`;
    let achievementHtml = `<tr><td><strong>Achievement PM</strong></td>`;
    
    const months = Array.from({length: 12}, (_, i) => i);
    months.forEach(month => {
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const weeksInMonth = getWeeksInMonth(year, month);
        let currentWeek = 1;
        let weekStartDay = 1;
        
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            
            // Jika hari Sabtu atau hari terakhir bulan
            if (date.getDay() === 6 || day === daysInMonth) {
                const weekEndDay = day;
                const weekData = achievementData[month][currentWeek] || { plan: 0, actual: 0 };
                const achievement = weekData.plan > 0 
                    ? Math.round((weekData.actual / weekData.plan) * 100)
                    : 0;
                
                const colspan = weekEndDay - weekStartDay + 1;
                
                // Baris Plan Item PM
                planHtml += `<td colspan="${colspan}" style="text-align: center; background-color: #f8f9fa">
                    ${weekData.plan}
                </td>`;
                
                // Baris Actual Item PM
                actualHtml += `<td colspan="${colspan}" style="text-align: center; background-color: #f8f9fa">
                    ${weekData.actual}
                </td>`;
                
                // Baris Achievement PM
                achievementHtml += `<td colspan="${colspan}" style="text-align: center; background-color: ${getAchievementColor(achievement)}">
                    ${achievement}%
                </td>`;
                
                weekStartDay = day + 1;
                currentWeek++;
            }
        }
    });
    
    planHtml += `</tr>`;
    actualHtml += `</tr>`;
    achievementHtml += `</tr>`;
    
    // Tambahkan baris achievement ke tabel
     // Tambahkan ketiga baris ke tabel
     const tbody = document.getElementById("ganttBody");
    tbody.insertAdjacentHTML('beforeend', planHtml);
    tbody.insertAdjacentHTML('beforeend', actualHtml);
    tbody.insertAdjacentHTML('beforeend', achievementHtml);
     // Generate the achievement chart
     generateAchievementChart(achievementData);
}

 // Update the generateAchievementChart function
 function generateAchievementChart(achievementData) {
        const year = parseInt(document.getElementById("yearFilter").value);
        const chartContainer = document.getElementById("achievementChart");
        chartContainer.innerHTML = '';
        
        // Calculate max achievement for scaling
        let maxAchievement = 0;
        const weeklyAchievements = [];
        
        // Process data for all months and weeks
        for (let month = 0; month < 12; month++) {
            const monthName = new Date(year, month, 1).toLocaleString('default', { month: 'short' });
            const weeks = Object.keys(achievementData[month]).sort((a,b) => a-b);
            
            weeks.forEach(week => {
                const weekData = achievementData[month][week];
                const achievement = weekData.plan > 0 ? Math.round((weekData.actual / weekData.plan) * 100) : 0;
                maxAchievement = Math.max(maxAchievement, achievement);
                
                weeklyAchievements.push({
                    month: month,
                    monthName: monthName,
                    week: week,
                    achievement: achievement,
                    plan: weekData.plan,
                    actual: weekData.actual
                });
            });
        }
        
        // Ensure we have at least 100% scale
        maxAchievement = Math.max(maxAchievement, 100);
        const scaleFactor = 200 / maxAchievement;
        
        // Create chart container structure
        const chartInner = document.createElement('div');
        chartInner.className = 'chart-container';
        
        // Create Y-axis labels
        const yAxisContainer = document.createElement('div');
        yAxisContainer.className = 'chart-y-labels';
        
        for (let i = 0; i <= maxAchievement; i += 20) {
            const yLabel = document.createElement('div');
            yLabel.className = 'chart-y-label';
            yLabel.style.bottom = `${(i / maxAchievement) * 200}px`;
            yLabel.textContent = `${i}%`;
            yAxisContainer.appendChild(yLabel);
        }
        
        chartContainer.appendChild(yAxisContainer);
        
        // Create bars for each week
        let currentMonth = null;
        weeklyAchievements.forEach((item, index) => {
            // Add month separator and label if month changed
            if (item.month !== currentMonth) {
                if (currentMonth !== null) {
                    const separator = document.createElement('div');
                    separator.className = 'month-separator';
                    chartInner.appendChild(separator);
                }
                
                const monthLabel = document.createElement('div');
                monthLabel.className = 'month-label';
                monthLabel.textContent = item.monthName;
                chartInner.appendChild(monthLabel);
                
                currentMonth = item.month;
            }
            
            const column = document.createElement('div');
            column.className = 'chart-column';
            
            const barContainer = document.createElement('div');
            barContainer.className = 'chart-bar-container';
            
            const bar = document.createElement('div');
            bar.className = 'chart-bar';
            bar.style.height = `${item.achievement * scaleFactor}px`;
            bar.style.backgroundColor = getAchievementColor(item.achievement);
            
            const valueLabel = document.createElement('div');
            valueLabel.className = 'chart-value';
            valueLabel.textContent = `${item.achievement}%`;
            bar.appendChild(valueLabel);
            
            const weekLabel = document.createElement('div');
            weekLabel.className = 'chart-label';
            weekLabel.textContent = `W${item.week}`;
            weekLabel.title = `${item.monthName} Minggu ${item.week}`;
            
            barContainer.appendChild(bar);
            column.appendChild(barContainer);
            column.appendChild(weekLabel);
            chartInner.appendChild(column);
        });
        
        // Add X-axis
        const axis = document.createElement('div');
        axis.className = 'chart-axis';
        chartContainer.appendChild(axis);
        
        chartContainer.appendChild(chartInner);
    }
// Fungsi untuk menentukan warna berdasarkan achievement
function getAchievementColor(percentage) {
    if (percentage >= 90) return '#2ecc71'; // Hijau untuk achievement tinggi
    if (percentage >= 70) return '#f39c12'; // Oranye untuk achievement sedang
    return '#e74c3c'; // Merah untuk achievement rendah
}


    document.addEventListener("DOMContentLoaded", () => {
        populateYearDropdown();
        generateGanttChart();
    });
</script>