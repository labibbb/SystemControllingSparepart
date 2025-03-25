<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<style>
    .note-container {
        display: flex;
        justify-content: flex-start; /* Posisi kiri */
        align-items: start;
    }
    .note-box {
        border: 2px solid black;
        width: 250px;
        min-height: 100px;
    }
    .tindakan-box {
        width: 300px; /* Dibuat lebih besar */
    }
    .upload-box {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 2px dashed black;
        border-radius: 10px;
        padding: 10px;
        cursor: pointer;
    }
    .upload-box img {
        width: 50px;
        height: 50px;
    }
</style>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-center align-items-center">
                    <h3 class="box-title text-center"><?= isset($singleChecksheet['nama_doc']) ? $singleChecksheet['nama_doc'] : '-'; ?></h3>
                </div>
                <div class="box-body">
                <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless" style="width: auto;">
                                    <tr>
                                        <td class="fw-bold">No Form</td>
                                        <td>:</td>
                                        <td><?= isset($singleChecksheet['no_form']) ? $singleChecksheet['no_form'] : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Pemilik Doc</td>
                                        <td>:</td>
                                        <td>MAINTENANCE DEPT</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">No Doc</td>
                                        <td>:</td>
                                        <td><?= isset($singleChecksheet['no_doc']) ? $singleChecksheet['no_doc'] : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Tanggal</td>
                                        <td>:</td>
                                        <td><?= isset($tanggal) ? date('d-m-Y', strtotime($tanggal)) : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Lini</td>
                                        <td>:</td>
                                        <td id="nama_lini"><?= isset($singleChecksheet['nama_lini']) ? $singleChecksheet['nama_lini'] : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Area</td>
                                        <td>:</td>
                                        <td id="nama_area"><?= isset($singleChecksheet['nama_area']) ? $singleChecksheet['nama_area'] : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Mesin</td>
                                        <td>:</td>
                                        <td id="nama_mesin"><?= isset($singleChecksheet['nama_mesin']) ? $singleChecksheet['nama_mesin'] : '-'; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="fw-bold">Diverifikasi oleh System</th>
                                        </tr>
                                        <tr>
                                            <th>Prepared By</th>
                                            <th>Checked By</th>
                                            <th>Approved By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= isset($pmm['prepared']) ? $pmm['prepared'] : '-'; ?></td>
                                            <td><?= isset($pmm['checked']) ? $pmm['checked'] : '-'; ?></td>
                                            <td><?= isset($pmm['approve']) ? $pmm['approve'] : '-'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= isset($pmm['preparedDate']) ? $pmm['preparedDate'] : '-'; ?></td>
                                            <td><?= isset($pmm['checkedDate']) ? $pmm['checkedDate'] : '-'; ?></td>
                                            <td><?= isset($pmm['approveDate']) ? $pmm['approveDate'] : '-'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status Checksheet :</td>
                                            <?php 
                                                if ($pmm['yearStatus'] == 1) {
                                                    $class = 'bg-primary text-white'; // Menunggu Approval (Biru)
                                                    $statusText = 'Menunggu Approval';
                                                } elseif ($pmm['yearStatus'] == 2) {
                                                    $class = 'bg-success text-white'; // Finish on Time (Hijau)
                                                    $statusText = 'Finish on Time';
                                                } elseif ($pmm['yearStatus'] == 3) {
                                                    $class = 'bg-danger text-white'; // Finish on Delay (Merah)
                                                    $statusText = 'Finish on Delay';
                                                } else {
                                                    $class = 'bg-secondary text-white'; // Default (Abu-abu)
                                                    $statusText = 'Unknown Status';
                                                }
                                            ?>
                                            <td colspan="2" class="fw-bold <?= $class; ?>"><?= $statusText; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>    
                        <input type="hidden" id="id_pmm" value="<?= isset($id_pmm) ? $id_pmm : '-'; ?>">
                        <input type="hidden" id="id_lini" value="<?= isset($singleChecksheet['id_lini']) ? $singleChecksheet['id_lini'] : '-'; ?>">
                        <input type="hidden" id="id_area" value="<?= isset($singleChecksheet['id_area']) ? $singleChecksheet['id_area'] : '-'; ?>">
                        <input type="hidden" id="id_mesin" value="<?= isset($singleChecksheet['id_mesin']) ? $singleChecksheet['id_mesin'] : '-'; ?>">
                    </div>

                    <div class="table-responsive">
                        <div style="overflow-x: auto;">
                            <table id="tbCheckSheet" class="table table-bordered table-striped" style="width: max-content; min-width: 100%;">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th style="min-width: 50px;">No</th>
                                        <th style="min-width: 150px;">Item Check</th>
                                        <th style="min-width: 150px;">Point Check</th>
                                        <th style="min-width: 150px;">Metode Check</th>
                                        <th style="min-width: 150px;">Standard</th>
                                        <th style="min-width: 120px;">Aktual</th>
                                        <th style="min-width: 200px;">Tindakan</th>
                                        <th style="min-width: 250px;">Hasil</th>
                                        <th style="min-width: 300px;">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($checksheet as $index => $row): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td id="item_cek_<?= $index; ?>"><?= $row['item_cek']; ?></td>
                                            <td id="point_cek_<?= $index; ?>"><?= $row['point_cek']; ?></td>
                                            <td id="metode_cek_<?= $index; ?>"><?= $row['metode_cek']; ?></td>
                                            <td id="standard_<?= $index; ?>"><?= $row['standard']; ?></td>
                                            <td id="idCk_<?= $index; ?>" style="display: none;"><?= $row['id_ck']; ?></td>

                                            <!-- Penyesuaian status -->
                                            <td>
                                                <select id="status_<?= $index; ?>" class="form-select status-dropdown" disabled onchange="updateDropdownColor(this)">
                                                    <option value="OK" class="bg-success text-white" <?= ($row['aktual'] == 'OK') ? 'selected' : ''; ?>>OK</option>
                                                    <option value="NG" class="bg-danger text-white" <?= ($row['aktual'] == 'NG') ? 'selected' : ''; ?>>NG</option>
                                                </select>
                                            </td>

                                            <!-- Tindakan (Muncul jika NG) -->
                                            <td>
                                                <select id="tindakan_<?= $index; ?>" class="form-select tindakan-dropdown" <?= ($row['aktual'] == 'NG') ? '' : 'style="visibility:hidden;"' ?> disabled>
                                                    <option value="1" <?= ($row['tindakan'] == 1) ? 'selected' : ''; ?>>Dibersihkan/Dirapikan/Pelumas</option>
                                                    <option value="2" <?= ($row['tindakan'] == 2) ? 'selected' : ''; ?>>Disetting/Dikencangkan</option>
                                                    <option value="3" <?= ($row['tindakan'] == 3) ? 'selected' : ''; ?>>Direpair</option>
                                                    <option value="4" <?= ($row['tindakan'] == 4) ? 'selected' : ''; ?>>Diganti</option>
                                                </select>
                                            </td>

                                            <!-- Hasil (Muncul jika NG) -->
                                            <td>
                                                <select id="hasil_<?= $index; ?>" class="form-select hasil-dropdown" <?= ($row['aktual'] == 'NG') ? '' : 'style="visibility:hidden;"' ?> disabled>
                                                    <option value="1" <?= ($row['hasil'] == 1) ? 'selected' : ''; ?>>✅ OK & Mesin jalan</option>
                                                    <option value="2" <?= ($row['hasil'] == 2) ? 'selected' : ''; ?>>⚠️ Abnormal & Mesin jalan</option>
                                                    <option value="3" <?= ($row['hasil'] == 3) ? 'selected' : ''; ?>>❌ Mesin Stop</option>
                                                </select>
                                            </td>

                                            <!-- Keterangan (Muncul jika NG) -->
                                            <td>
                                                <div id="keterangan_container_<?= $index; ?>" class="keterangan-container" style="display: flex; gap: 5px; <?= ($row['aktual'] == 'NG') ? '' : 'visibility:hidden;' ?>">
                                                    <input id="keterangan_input_<?= $index; ?>" type="text" class="form-control keterangan-input" value="<?= $row['keterangan']; ?>" disabled style="flex: 1; min-width: 200px;">
                                                    
                                                    <?php if (!empty($row['gambar'])): ?>
                                                        <a href="<?= base_url('uploads/pengerjaan/' . $row['gambar']); ?>" class="btn btn-primary btn-sm" target="_blank">Show</a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mt-3">
                        <div class="note-container d-flex gap-3 flex-wrap">
                            <!-- Box Tindakan (Diperbesar) -->
                            <div class="note-box p-3 rounded shadow-sm tindakan-box">
                                <strong>Tindakan</strong>
                                <ul class="ps-3 mb-0">
                                    <li>1: Dibersihkan/Dirapikan/Pelumasan</li>
                                    <li>2: Disetting/Dikencangkan</li>
                                    <li>3: Direpair</li>
                                    <li>4: Diganti</li>
                                </ul>
                            </div>

                            <!-- Box Hasil -->
                            <div class="note-box p-3 rounded shadow-sm">
                                <strong>Hasil</strong>
                                <ul class="ps-3 mb-0">
                                    <li>✓ : OK & Mesin jalan</li>
                                    <li>∆ : Abnormal & Mesin jalan</li>
                                    <li>✗ : Mesin stop</li>
                                </ul>
                            </div>

                            <!-- Box Catatan & Upload Foto -->
                            <div class="note-box p-3 rounded shadow-sm">
                                <div class="mb-2">
                                    <strong>Catatan:</strong>
                                    <input type="text" class="form-control mt-1" style="border-radius: 20px;">
                                </div>
                                <div>
                                    <strong>Masukkan Foto:</strong>
                                    <div class="upload-box mt-2">
                                        <label for="uploadFile">
                                            <img src="path_ke_gambar_upload.jpg" alt="Upload" class="img-fluid">
                                        </label>
                                        <input type="file" id="uploadFile" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
             
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <button class="btn btn-secondary px-5 py-2" id="btnBack" style="width: 200px; font-size: 1.2rem;" onclick="window.location.href='<?= site_url('approvalSPV'); ?>'">
                            Back
                        </button>
                    </div>


                </div>
            </div>
        </section>
    </div>
</div>

<script>
    function updateDropdownColor(selectElement) {
        if (selectElement.value === "OK") {
            selectElement.style.backgroundColor = "green";
            selectElement.style.color = "white";
        } else if (selectElement.value === "NG") {
            selectElement.style.backgroundColor = "red";
            selectElement.style.color = "white";
        }
    }

    // Terapkan warna sesuai dengan nilai awal
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".status-dropdown").forEach(function (select) {
            updateDropdownColor(select);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#btnReject").click(function () {
            reject();
        });

        $("#btnApprove").click(function () {
            approve();
        });
        
        function approve() {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data akan disimpan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, simpan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    let id_pmm = $("#id_pmm").val();
                    $.ajax({
                        url: "<?= site_url('approvalSPV/approveSpv/') ?>" + id_pmm, // Kirim sebagai parameter URL
                        type: "POST", // Gunakan POST atau bisa juga GET
                        dataType: "json",
                        success: function (response) {
                            if (response.status === "success") {
                                Swal.fire("Berhasil!", "Data berhasil disimpan!", "success").then(() => {
                                    window.location.href = "<?= site_url('approvalSPV'); ?>";
                                });
                            } else {
                                Swal.fire("Gagal!", response.message || "Terjadi kesalahan saat menyimpan!", "error");
                            }
                        },
                        error: function () {
                            Swal.fire("Error!", "Terjadi kesalahan saat menghubungi server!", "error");
                        }
                    });
                }
            });
        }
        
        function reject() {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data akan disimpan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, simpan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    let id_pmm = $("#id_pmm").val();
                    $.ajax({
                        url: "<?= site_url('approvalSPV/reject/') ?>" + id_pmm, // Kirim sebagai parameter URL
                        type: "POST", // Gunakan POST atau bisa juga GET
                        dataType: "json",
                        success: function (response) {
                            if (response.status === "success") {
                                Swal.fire("Berhasil!", "Data berhasil disimpan!", "success").then(() => {
                                    window.location.href = "<?= site_url('approvalSPV'); ?>";
                                });
                            } else {
                                Swal.fire("Gagal!", response.message || "Terjadi kesalahan saat menyimpan!", "error");
                            }
                        },
                        error: function () {
                            Swal.fire("Error!", "Terjadi kesalahan saat menghubungi server!", "error");
                        }
                    });
                }
            });
        }
    });
</script>
<?php $this->load->view('layouts/footer'); ?>
