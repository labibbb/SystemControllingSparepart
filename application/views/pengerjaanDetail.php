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
                                            <td>
                                                <select id="status_<?= $index; ?>" class="form-select status-dropdown" onchange="changeColor(this)" style="background-color: green; color: white;">
                                                    <option value="OK" class="bg-success text-white">OK</option>
                                                    <option value="NG" class="bg-danger text-white">NG</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select id="tindakan_<?= $index; ?>" class="form-select tindakan-dropdown" style="visibility: hidden;">
                                                    <option value="1">Dibersihkan/Dirapikan/Pelumas</option>
                                                    <option value="2">Disetting/Dikencangkan</option>
                                                    <option value="3">Direpair</option>
                                                    <option value="4">Diganti</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select id="hasil_<?= $index; ?>" class="form-select hasil-dropdown" style="visibility: hidden;">
                                                    <option value="OK">✅ OK & Mesin jalan</option>
                                                    <option value="Abnormal">⚠️ Abnormal & Mesin jalan</option>
                                                    <option value="Stop">❌ Mesin Stop</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div id="keterangan_container_<?= $index; ?>" class="keterangan-container" style="display: flex; gap: 5px; visibility: hidden;">
                                                    <input id="keterangan_input_<?= $index; ?>" type="text" class="form-control keterangan-input" placeholder="Masukkan keterangan" style="flex: 1; min-width: 200px;">
                                                    <input id="keterangan_file_<?= $index; ?>" type="file" class="form-control keterangan-file" style="width: 18%;">
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
                                    <input type="text" class="form-control mt-1" style="border-radius: 20px;" disabled>
                                </div>
                                <div>
                                    <strong>Masukkan Foto:</strong>
                                    <div class="upload-box mt-2">
                                        <label for="uploadFile">
                                            <img src="path_ke_gambar_upload.jpg" alt="Upload" class="img-fluid" disabled>
                                        </label>
                                        <input type="file" id="uploadFile" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
             
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <button class="btn btn-success px-5 py-2" id="btnSelesai" style="width: 200px; font-size: 1.2rem;">
                            Selesai
                        </button>
                    </div>

                </div>
            </div>
        </section>
    </div>
</div>

<div class="modal fade show" id="wiModal" tabindex="-1" aria-labelledby="wiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h3 class="modal-title text-center fw-bold"><?= $wi['nama_wi']; ?></h3>
            </div>
            <div class="modal-body">
                <embed src="<?= base_url('uploads/wi_files/' . $wi['nama_file']); ?>#toolbar=0" type="application/pdf" width="100%" height="500px">
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <button type="button" class="btn btn-warning text-white fw-bold" data-bs-dismiss="modal">
                    Selesai Membaca
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#btnSelesai").click(function () {
            simpanChecksheet();
        });
        
        function simpanChecksheet() {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data yang dimasukkan akan disimpan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, simpan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData();

                    let idLini = $("#id_lini").val();
                    let idArea = $("#id_area").val();
                    let idMesin = $("#id_mesin").val();
                    let idPmm = $("#id_pmm").val();
                    let index = 0;

                    // Iterasi tabel untuk mengambil data
                    $("#tbCheckSheet tbody tr").each(function () {
                        let idCk = $(this).find(`#idCk_${index}`).text().trim();
                        let aktual = $(this).find(`#status_${index}`).val();
                        let tindakan = $(this).find(`#tindakan_${index}`).val();
                        let hasil = $(this).find(`#hasil_${index}`).val();
                        let keterangan = $(this).find(`#keterangan_input_${index}`).val();
                        let gambar = $(this).find(`#keterangan_file_${index}`)[0].files[0];

                        // Tambahkan data ke formData
                        formData.append(`data[${index}][id_pmm]`, idPmm);
                        formData.append(`data[${index}][id_ck]`, idCk);
                        formData.append(`data[${index}][id_lini]`, idLini);
                        formData.append(`data[${index}][id_area]`, idArea);
                        formData.append(`data[${index}][id_mesin]`, idMesin);
                        formData.append(`data[${index}][aktual]`, aktual);
                        formData.append(`data[${index}][tindakan]`, tindakan);
                        formData.append(`data[${index}][hasil]`, hasil);
                        formData.append(`data[${index}][keterangan]`, keterangan);
                        formData.append(`data[${index}][status]`, "1");

                        // Jika ada gambar, tambahkan ke formData
                        if (gambar) {
                            formData.append(`gambar_${index}`, gambar);
                        }

                        index++;
                    });

                    // Kirim data dengan AJAX menggunakan FormData
                    $.ajax({
                        url: "<?= site_url('pengerjaan/add'); ?>",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function (response) {
                            if (response.status === "success") {
                                Swal.fire("Berhasil!", "Data berhasil disimpan!", "success").then(() => {
                                    window.location.href = "<?= site_url('pengerjaan'); ?>";
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var myModal = new bootstrap.Modal(document.getElementById('wiModal'), {
            backdrop: 'static', // Tidak bisa ditutup dengan klik di luar modal
            keyboard: false     // Tidak bisa ditutup dengan tombol ESC
        });
        myModal.show();
    });
</script>

<script>
    function changeColor(select) {
        let row = select.closest("tr");
        let tindakanDropdown = row.querySelector(".tindakan-dropdown");
        let hasilDropdown = row.querySelector(".hasil-dropdown");
        let keteranganInput = row.querySelector(".keterangan-input");
        let keteranganFile = row.querySelector(".keterangan-file");

        if (select.value === "OK") {
            select.style.backgroundColor = "green";
            select.style.color = "white";

            // Sembunyikan elemen tanpa mengubah ukuran kolom
            tindakanDropdown.style.visibility = "hidden";
            hasilDropdown.style.visibility = "hidden";
            keteranganInput.style.visibility = "hidden";
            keteranganFile.style.visibility = "hidden";

        } else if (select.value === "NG") {
            select.style.backgroundColor = "red";
            select.style.color = "white";

            // Tampilkan elemen tanpa mengubah ukuran kolom
            tindakanDropdown.style.visibility = "visible";
            hasilDropdown.style.visibility = "visible";
            keteranganInput.style.visibility = "visible";
            keteranganFile.style.visibility = "visible";
        }
    }
</script>
<?php $this->load->view('layouts/footer'); ?>
