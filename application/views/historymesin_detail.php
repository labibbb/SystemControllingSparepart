<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<style>
    .note-container {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 20px;
    }
    .note-box {
        border: 2px solid black;
        border-radius: 5px;
        width: 250px;
        min-height: 100px;
        padding: 10px;
        background-color: #f9f9f9;
    }
    .filter-container {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }
</style>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">History Checksheet - <?= $mesin_info['nama_mesin'] ?></h3>
                    <a href="<?= site_url('historymesin') ?>" class="btn btn-default">Kembali</a>
                </div>
                <div class="box-body">
                    <!-- Year Filter -->
                    <div class="filter-container">
                        <form action="<?= site_url('historymesin/detail/' . $mesin_info['id_mesin']) ?>" method="get">
                            <label for="year">Filter Tahun:</label>
                            <select name="year" id="year" class="form-control" style="width: 150px;">
                                <?php 
                                // Get available years from your data
                                $availableYears = [];
                                foreach ($checksheet as $row) {
                                    $year = date('Y', strtotime($row['tanggal_pengerjaan']));
                                    if (!in_array($year, $availableYears)) {
                                        $availableYears[] = $year;
                                    }
                                }
                                rsort($availableYears); // Show latest year first
                                
                                // Add "All Years" option
                                array_unshift($availableYears, 'All');
                                
                                $selectedYear = isset($_GET['year']) ? $_GET['year'] : 'All';
                                
                                foreach ($availableYears as $year): 
                                    $selected = ($year == $selectedYear) ? 'selected' : '';
                                ?>
                                    <option value="<?= $year ?>" <?= $selected ?>>
                                        <?= $year == 'All' ? 'Semua Tahun' : $year ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>

                    <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Item Check</th>
                                    <th rowspan="2">Point Check</th>
                                    <th rowspan="2">Metode Check</th>
                                    <th rowspan="2">Standard</th>
                                    <?php 
                                    $dates = [];
                                    foreach ($checksheet as $row) {
                                        $date = date('Y-m-d', strtotime($row['tanggal_pengerjaan']));
                                        if (!in_array($date, $dates)) {
                                            $dates[] = $date;
                                        }
                                    }
                                    
                                    // Filter dates by selected year if not 'All'
                                    if (isset($_GET['year']) && $_GET['year'] != 'All') {
                                        $filterYear = $_GET['year'];
                                        $dates = array_filter($dates, function($date) use ($filterYear) {
                                            return date('Y', strtotime($date)) == $filterYear;
                                        });
                                    }
                                    
                                    sort($dates);
                                    foreach ($dates as $date): 
                                        $formattedDate = date('d-m-Y', strtotime($date));
                                    ?>
                                        <th colspan="5" class="text-center"><?= $formattedDate ?></th>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <?php foreach ($dates as $date): ?>
                                        <th>Aktual</th>
                                        <th>Tindakan</th>
                                        <th>Hasil</th>
                                        <th>Keterangan</th>
                                        <th>Foto</th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $items = [];
                                foreach ($checksheet as $row) {
                                    $key = $row['item_cek'].'|'.$row['point_cek'].'|'.$row['metode_cek'].'|'.$row['standard'];
                                    if (!isset($items[$key])) {
                                        $items[$key] = [
                                            'item_cek' => $row['item_cek'],
                                            'point_cek' => $row['point_cek'],
                                            'metode_cek' => $row['metode_cek'],
                                            'standard' => $row['standard'],
                                            'data' => []
                                        ];
                                    }
                                    $items[$key]['data'][date('Y-m-d', strtotime($row['tanggal_pengerjaan']))] = $row;
                                }

                                $no = 1;
                                foreach ($items as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $item['item_cek'] ?></td>
                                    <td><?= $item['point_cek'] ?></td>
                                    <td><?= $item['metode_cek'] ?></td>
                                    <td><?= $item['standard'] ?></td>
                                    
                                    <?php foreach ($dates as $date): 
                                        $row = isset($item['data'][$date]) ? $item['data'][$date] : null;
                                    ?>
                                        <td>
                                            <?php if ($row): ?>
                                                <?php if ($row['aktual'] == 'OK'): ?>
                                                    <span class="badge bg-success">OK</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">NG</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row && $row['aktual'] != 'OK'): ?>
                                                <?php 
                                                $tindakanOptions = [
                                                    1 => 'Dibersihkan/Dirapikan/Pelumas',
                                                    2 => 'Disetting/Dikencangkan',
                                                    3 => 'Direpair',
                                                    4 => 'Diganti'
                                                ];
                                                echo isset($tindakanOptions[$row['tindakan']]) ? $tindakanOptions[$row['tindakan']] : '-';
                                                ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row && $row['aktual'] != 'OK'): ?>
                                                <?php 
                                                $hasilOptions = [
                                                    'OK' => '✅ OK & Mesin jalan',
                                                    'Abnormal' => '⚠️ Abnormal & Mesin jalan',
                                                    'Stop' => '❌ Mesin Stop'
                                                ];
                                                echo isset($hasilOptions[$row['hasil']]) ? $hasilOptions[$row['hasil']] : '-';
                                                ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $row ? $row['keterangan'] : '' ?></td>
                                        <td>
                                            <?php if ($row && !empty($row['gambar'])): ?>
                                                <a href="<?= base_url('uploads/pengerjaan/' . $row['gambar']); ?>" class="btn btn-primary btn-sm" target="_blank">Show</a>
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                   <!-- Catatan per tanggal -->
                <div class="note-container">
                        <?php foreach ($dates as $date): ?>
                            <?php 
                                $formattedDate = date('d-m-Y', strtotime($date));
                                $note = '';
                                $photo = '';

                                foreach ($items as $item) {
                                    if (isset($item['data'][$date])) {
                                        if (!empty($item['data'][$date]['catatan'])) {
                                            $note = htmlspecialchars($item['data'][$date]['catatan']);
                                        }
                                        if (!empty($item['data'][$date]['gambarPm'])) {
                                            $photo = $item['data'][$date]['gambarPm'];
                                        }
                                        break;
                                    }
                                }
                            ?>
                            <?php if (!empty($note) || !empty($photo)): ?>
                                <div class="note-box">
                                    <strong>Catatan pada <?= $formattedDate ?></strong>
                                    <p><?= $note ?></p>
                                    
                                    <?php if (!empty($photo)): ?>
                                        <div style="margin-top: 10px;">
                                            <a href="<?= base_url('uploads/pengerjaan/' . $photo); ?>" class="btn btn-primary btn-sm" target="_blank">Show</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>