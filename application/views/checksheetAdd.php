<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Insert Checkseet</h3>
                </div>
                <div class="box-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="no_form">No Form</label>
                            <input type="text" id="no_form" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="id_depertamen">Pemilik Doc</label>
                            <select id="id_departemen" class="form-control" required>
                                <option value="">Pilih Departement</option>
                                <?php foreach ($departemen as $d): ?>
                                    <option value="<?= $d['id']; ?>"><?= $d['dept']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="no_doc">No Doc</label>
                            <input type="text" id="no_doc" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="id_lini">Lini</label>
                            <select id="id_lini" class="form-control" required>
                                <option value="">Pilih Lini</option>
                                <?php foreach ($lini as $l): ?>
                                    <option value="<?= $l['id_lini']; ?>"><?= $l['nama_lini']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_area">Area</label>
                            <select id="id_area" class="form-control" required disabled></select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_mesin">Mesin</label>
                            <select id="id_mesin" class="form-control" required disabled></select>
                        </div>
                    </div>    
                    <div class="table-responsive">
                        <table id="tbCheckSheet" class="table table-bordered table-striped">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Item Check</th>
                                    <th>Point Check</th>
                                    <th>Metode Check</th>
                                    <th>Standard</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data awal -->
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
        $("#btnSimpan").click(function () {
            simpanChecksheet();
        });
        
        // Fungsi untuk menyimpan data checksheet
        let rowCount = 0;

        // Fungsi untuk menambah baris baru
        function addRow(itemCheck = '', mergeItem = false) {
            rowCount++;
            let newRow = `<tr id="row-${rowCount}">
                <td id="row-${rowCount}-no">${rowCount}</td>
                <td id="row-${rowCount}-item" ${mergeItem ? 'rowspan="1"' : ''}>
                    <input type="text" class="form-control item-check" id="row-${rowCount}-itemCheck" value="${itemCheck}" ${mergeItem ? 'readonly' : ''} required>
                </td>
                <td id="row-${rowCount}-col1"><input type="text" class="form-control" id="row-${rowCount}-input1" required></td>
                <td id="row-${rowCount}-col2"><input type="text" class="form-control" id="row-${rowCount}-input2" required></td>
                <td id="row-${rowCount}-col3"><input type="text" class="form-control" id="row-${rowCount}-input3" required></td>
                <td id="row-${rowCount}-action">
                    <button class="btn btn-secondary btn-sm merge-row">Tambah dengan Item Sama</button>
                </td>
            </tr>`;
            $("#tbCheckSheet tbody").append(newRow);
        }

        // Event handler untuk tombol "Tambah Baru"
        $("#addRow").click(function () {
            addRow();
        });

        // Event handler untuk tombol "Tambah dengan Item Sama"
        $(document).on("click", ".merge-row", function () {
            let currentRow = $(this).closest("tr");
            let itemCheckValue = currentRow.find(".item-check").val();

            // Temukan sel item check yang sudah ada dan tingkatkan rowspan
            let itemCheckCell = currentRow.find("td:first-child + td");
            let rowspan = parseInt(itemCheckCell.attr("rowspan")) || 1;
            itemCheckCell.attr("rowspan", rowspan + 1);

            // Tambah baris baru tanpa kolom Item Check
            let newRow = `<tr id="row-${++rowCount}">
                <td id="row-${rowCount}-no">${rowCount}</td>
                <td style="display:none;" id="row-${rowCount}-item"></td>
                <td id="row-${rowCount}-col1"><input type="text" class="form-control" id="row-${rowCount}-input1" required></td>
                <td id="row-${rowCount}-col2"><input type="text" class="form-control" id="row-${rowCount}-input2" required></td>
                <td id="row-${rowCount}-col3"><input type="text" class="form-control" id="row-${rowCount}-input3" required></td>
                <td id="row-${rowCount}-action"></td>
            </tr>`;

            itemCheckCell.closest("tr").after(newRow);
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
            $("#tbCheckSheet tbody tr").each(function () {
                let rowId = $(this).attr("id");
                let itemCek = $(this).find(".item-check").val() || lastItemCek;
                let pointCek = $(this).find("td:nth-child(3) input").val();
                let metodeCek = $(this).find("td:nth-child(4) input").val();
                let standard = $(this).find("td:nth-child(5) input").val();
                let idLini = $("#id_lini").val();
                let idArea = $("#id_area").val();
                let idMesin = $("#id_mesin").val();
                let noForm = $("#no_form").val();
                let noDoc = $("#no_doc").val();
                let idDepartemen = $("#id_departemen").val();

                if (itemCek && pointCek && metodeCek && standard) {
                    dataList.push({
                        id_lini: idLini,
                        id_area: idArea,
                        id_mesin: idMesin,
                        item_cek: itemCek,
                        point_cek: pointCek,
                        metode_cek: metodeCek,
                        standard: standard,
                        status: "1",
                        no_form: noForm,
                        no_doc: noDoc,
                        id_departemen: idDepartemen
                    });

                    lastItemCek = itemCek;
                }
            });

            if (dataList.length === 0) {
                Swal.fire("Gagal", "Silakan lengkapi data sebelum menyimpan!", "error");
                return;
            }

            $.ajax({
                url: "<?= site_url('checkseet/insert'); ?>",
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
