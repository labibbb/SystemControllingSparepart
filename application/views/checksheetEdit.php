<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Edit Checkseet</h3>
                </div>
                <div class="box-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="nama_form">Nama Check Sheet</label>
                            <input type="text" id="nama_form" class="form-control" value="<?= isset($singleChecksheet['nama_doc']) ? $singleChecksheet['nama_doc'] : ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_form">Tanggal</label>
                            <input type="date" id="tanggal_form" class="form-control" value="<?= isset($singleChecksheet['tanggal_doc']) ? $singleChecksheet['tanggal_doc'] : ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="no_form">No Form</label>
                            <input type="text" id="no_form" name="no_form" class="form-control" value="<?= isset($singleChecksheet['no_form']) ? $singleChecksheet['no_form'] : ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="id_departemen">Pemilik Doc</label>
                            <input type="text" id="id_departemen" class="form-control" value="MAINTENANCE DEPT" required disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="no_doc">No Doc</label>
                            <input type="text" id="no_doc" class="form-control" value="<?= isset($singleChecksheet['no_form']) ? $singleChecksheet['no_doc'] : ''; ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="id_lini">Lini</label>
                            <select id="id_lini" name="id_lini" class="form-control" required>
                                <?php foreach ($lini as $l): ?>
                                    <option value="<?= $l['id_lini']; ?>" <?= ($l['id_lini'] == $singleChecksheet['id_lini']) ? 'selected' : ''; ?>>
                                        <?= $l['nama_lini']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="id_area">Area</label>
                            <select id="id_area" name="id_area" class="form-control" required>
                                <?php foreach ($area as $a): ?>
                                    <option value="<?= $a['id_area']; ?>" <?= ($a['id_area'] == $singleChecksheet['id_area']) ? 'selected' : ''; ?>>
                                        <?= $a['nama_area']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="id_mesin">Mesin</label>
                            <select id="id_mesin" name="id_mesin" class="form-control" required>
                                <?php foreach ($mesin as $m): ?>
                                    <option value="<?= $m['id_mesin']; ?>" <?= ($m['id_mesin'] == $singleChecksheet['id_mesin']) ? 'selected' : ''; ?>>
                                        <?= $m['nama_mesin']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>    
                    <div class="table-responsive">
                        <table id="tbCheckSheet" class="table table-bordered table-striped">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Item Check</th>
                                    <th>Point Check</th>
                                    <th>Metode Check</th>
                                    <th>Standard</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $mergedItems = []; // Menyimpan jumlah baris untuk setiap item_cek
                                    foreach ($checksheet as $row) {
                                        $item = $row['item_cek'];
                                        if (!isset($mergedItems[$item])) {
                                            $mergedItems[$item] = 1;
                                        } else {
                                            $mergedItems[$item]++;
                                        }
                                    }

                                    $displayedItems = []; // Menyimpan item_cek yang sudah ditampilkan
                                    $rowCount = 0; // Inisialisasi row count
                                ?>
                                <?php foreach ($checksheet as $row): ?>
                                    <tr id="row-<?= $rowCount; ?>">
                                        <?php if (!isset($displayedItems[$row['item_cek']])): ?>
                                            <td rowspan="<?= $mergedItems[$row['item_cek']]; ?>">
                                                <input type="text" name="item_cek[]" class="form-control item-check" value="<?= $row['item_cek']; ?>">
                                            </td>
                                            <?php $displayedItems[$row['item_cek']] = true; ?>
                                        <?php else: ?>
                                            <td style="display: none;"></td> <!-- Baris berikutnya dalam grup disembunyikan -->
                                        <?php endif; ?>

                                        <td id="row-<?= $rowCount; ?>-col2">
                                            <input type="text" class="form-control" id="row-<?= $rowCount; ?>-input1" value="<?= $row['point_cek']; ?>" required>
                                        </td>
                                        <td id="row-<?= $rowCount; ?>-col3">
                                            <input type="text" class="form-control" id="row-<?= $rowCount; ?>-input2" value="<?= $row['metode_cek']; ?>" required>
                                        </td>
                                        <td id="row-<?= $rowCount; ?>-col4">
                                            <input type="text" class="form-control" id="row-<?= $rowCount; ?>-input3" value="<?= $row['standard']; ?>" required>
                                        </td>

                                        <?php if (!isset($displayedItems['button_' . $row['item_cek']])): ?>
                                            <td>
                                                <button class="btn btn-secondary btn-sm merge-row"><i class="fas fa-plus"></i></button>
                                            </td>
                                            <?php $displayedItems['button_' . $row['item_cek']] = true; ?>
                                        <?php else: ?>
                                            <td></td> <!-- Baris selain yang pertama dalam grup dibuat kosong -->
                                        <?php endif; ?>
                                    </tr>
                                    <?php $rowCount++; // Tambahkan row count setiap iterasi ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button class="btn btn-success" id="addRow">
                             Tambah Baru
                        </button>
                        <button id="btnSimpan" class="btn btn-primary">
                             Simpan
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    $(document).ready(function() {
        let rowCount = $("#tbCheckSheet tbody tr").length; // Hitung jumlah baris awal dalam tbody
        console.log("Jumlah row awal:", rowCount);
        let lastItemCek = ''; // Initialize the last item check variable

        $("#btnSimpan").click(function () {
            simpanChecksheet();
        });

        // Fungsi untuk menambah baris baru
        function addRow(itemCheck = '', mergeItem = false) {
            rowCount++;
            let newRow = `<tr id="row-${rowCount}">
                <td id="row-${rowCount}-item" ${mergeItem ? 'rowspan="1"' : ''}>
                    <input type="text" class="form-control item-check" id="row-${rowCount}-itemCheck" value="${itemCheck}" ${mergeItem ? 'readonly' : ''} required>
                </td>
                <td id="row-${rowCount}-col1"><input type="text" class="form-control" id="row-${rowCount}-input1" required></td>
                <td id="row-${rowCount}-col2"><input type="text" class="form-control" id="row-${rowCount}-input2" required></td>
                <td id="row-${rowCount}-col3"><input type="text" class="form-control" id="row-${rowCount}-input3" required></td>
                <td id="row-${rowCount}-action">
                    <button class="btn btn-secondary btn-sm merge-row"><i class="fas fa-plus"></i></button>
                </td>
            </tr>`;
            $("#tbCheckSheet tbody").append(newRow);
        }

        // Event handler untuk tombol "Tambah Baru"
        $("#addRow").click(function () {
            addRow(); // Menambah baris baru
        });

        // Event handler untuk tombol "Tambah dengan Item Sama"
        $(document).on("click", ".merge-row", function () {
            let currentRow = $(this).closest("tr");
            let itemCheckValue = currentRow.find(".item-check").val(); // Mendapatkan item dari baris yang sedang dipilih

            // Temukan sel item check yang sudah ada dan tingkatkan rowspan
            let itemCheckCell = currentRow.find("td:first-child"); // Kolom item check adalah yang pertama
            let rowspan = parseInt(itemCheckCell.attr("rowspan")) || 1;
            itemCheckCell.attr("rowspan", rowspan + 1);

            // Tambah baris baru tanpa kolom Item Check (karena kita menggunakan item yang sama)
            let newRow = `<tr id="row-${++rowCount}">
                <td style="display:none;" id="row-${rowCount}-item"></td>
                <td id="row-${rowCount}-col1"><input type="text" class="form-control" id="row-${rowCount}-input1" required></td>
                <td id="row-${rowCount}-col2"><input type="text" class="form-control" id="row-${rowCount}-input2" required></td>
                <td id="row-${rowCount}-col3"><input type="text" class="form-control" id="row-${rowCount}-input3" required></td>
                <td id="row-${rowCount}-action">
                </td>
            </tr>`;

            itemCheckCell.closest("tr").after(newRow); // Menambahkan baris baru setelah baris yang sedang dipilih
        });

        $('#id_lini').change(function() {
            let idLini = $(this).val();
            $('#id_area').prop('disabled', false);
            $.post('<?= site_url("settingfwm/get_area"); ?>', { id_lini: idLini }, function(data) {
                $('#id_area').html('<option value="">Pilih Area</option>');
                $.each(JSON.parse(data), function(index, value) {
                    $('#id_area').append('<option value="' + value.id_area + '">' + value.nama_area + '</option>');
                });
            });
        });

        $('#id_area').change(function() {
            let idArea = $(this).val();
            $('#id_mesin').prop('disabled', false);
            $.post('<?= site_url("settingfwm/get_mesin"); ?>', { id_area: idArea }, function(data) {
                $('#id_mesin').html('<option value="">Pilih Mesin</option>');
                $.each(JSON.parse(data), function(index, value) {
                    $('#id_mesin').append('<option value="' + value.id_mesin + '">' + value.nama_mesin + '</option>');
                });
            }); 
        });
        
        function simpanChecksheet() {
            let dataList = [];
            let errorMessage = ""; // Menyimpan pesan error

            let idLini = $("#id_lini").val();
            let idArea = $("#id_area").val();
            let idMesin = $("#id_mesin").val();
            let noForm = $("#no_form").val();
            let noDoc = $("#no_doc").val();
            let namaForm = $("#nama_form").val();
            let tanggalForm = $("#tanggal_form").val();
            let idDepartemen = $("#id_departemen").val();

            // Validasi setiap kolom input
            if (!idLini) errorMessage += "- ID Lini harus dipilih!<br>";
            if (!idArea) errorMessage += "- ID Area harus dipilih!<br>";
            if (!idMesin) errorMessage += "- ID Mesin harus dipilih!<br>";
            if (!noForm) errorMessage += "- Nomor Form harus diisi!<br>";
            if (!noDoc) errorMessage += "- Nomor Dokumen harus diisi!<br>";
            if (!idDepartemen) errorMessage += "- ID Departemen harus dipilih!<br>";
            if (!namaForm) errorMessage += "- Nama Checksheet harus diisi!<br>";
            if (!tanggalForm) errorMessage += "- Tanggal Form harus dipilih!<br>";

            // Jika ada error, tampilkan alert dan hentikan proses
            if (errorMessage !== "") {
                Swal.fire({
                    title: "Gagal!",
                    html: errorMessage,
                    icon: "error"
                });
                return;
            }

            // Iterasi melalui tabel hanya jika validasi berhasil
            // Iterasi melalui tabel hanya jika validasi berhasil
            $("#tbCheckSheet tbody tr").each(function (index) {
                let currentRow = $(this);
                let itemCekCell = currentRow.find("td:first-child"); // Kolom pertama (Item Check)
                let itemCek = "";

                // Jika kolom pertama tidak tersembunyi, ambil valuenya langsung
                if (itemCekCell.css("display") !== "none") {
                    itemCek = itemCekCell.find("input").val();
                } else {
                    // Jika tersembunyi (karena rowspan), cari baris sebelumnya yang memiliki itemCek
                    let prevRow = currentRow.prevAll("tr").has("td[rowspan]").first();
                    if (prevRow.length) {
                        itemCek = prevRow.find("td:first-child input").val();
                    }
                }

                let pointCek = currentRow.find("td:nth-child(2) input").val();
                let metodeCek = currentRow.find("td:nth-child(3) input").val();
                let standard = currentRow.find("td:nth-child(4) input").val();

                // Log setiap baris yang diproses
                console.log(`Baris ${index + 1}:`, {
                    itemCek: itemCek,
                    pointCek: pointCek,
                    metodeCek: metodeCek,
                    standard: standard
                });

                if (itemCek && pointCek && metodeCek && standard) {
                    dataList.push({
                        id_lini: idLini,
                        id_area: idArea,
                        id_mesin: idMesin,
                        item_cek: itemCek,  // Sekarang item_cek pasti diambil dari row pertama jika merge
                        point_cek: pointCek,
                        metode_cek: metodeCek,
                        standard: standard,
                        status: "1",
                        no_form: noForm,
                        no_doc: noDoc,
                        nama_doc: namaForm,
                        tanggal_doc: tanggalForm,
                        id_departemen: idDepartemen
                    });
                }
            });

            // Pastikan ada data yang dikirim
            if (dataList.length === 0) {
                Swal.fire("Gagal", "Isi tabel sebelum menyimpan!", "error");
                return;
            }

            // Kirim data dengan AJAX
            $.ajax({
                url: "<?= site_url('checkseet/update'); ?>",
                type: "POST",
                data: JSON.stringify({ data: dataList }),
                contentType: "application/json",
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire("Berhasil!", "Data berhasil disimpan!", "success").then(() => {
                            window.location.href = "<?= site_url('checkseet'); ?>";
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
</script>
<?php $this->load->view('layouts/footer'); ?>
