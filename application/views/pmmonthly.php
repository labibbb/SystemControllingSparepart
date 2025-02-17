<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h3 class="box-title">Schedule Monthly PM</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>MP</th>
                                    <th>Lini</th>
                                    <th>Area</th>
                                    <th>Mesin</th>
                                    <th>Status</th>
                                    <th>Cek FR</th>
                                    <th>Cek SPV</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-lini">
                                <?php $no = 1; foreach ($pmmonthly as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td>
                                            <?= !empty($row['tanggal']) ? date('d M Y', strtotime($row['tanggal'])) : 'No Set'; ?>
                                        </td>
                                        <td><?= $row['dipname']; ?></td>
                                        <td><?= $row['nama_lini']; ?></td>
                                        <td><?= $row['nama_area']; ?></td>
                                        <td><?= $row['nama_mesin']; ?></td>
                                        <td>
                                            <?php 
                                            // Menentukan status berdasarkan angka
                                            switch ($row['status']) {
                                                case 1:
                                                    echo '<span class="badge bg-info">Terjadwal Tahunan</span>';
                                                    break;
                                                case 2:
                                                    echo '<span class="badge bg-warning">Belum Terlaksana</span>';
                                                    break;
                                                case 3:
                                                    echo '<span class="badge bg-success">Sudah Terjadwal</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <?php if ($row['status'] == 1): ?>
                                                <button class="btn btn-success btn-sm" onclick="editTanggalStatus(<?= $row['id_pmm']; ?>)">Setting</button>
                                            <?php else: ?>
                                                <button class="btn btn-warning btn-sm" onclick="editTanggal(<?= $row['id_pmm']; ?>, '<?= date('Y-m-d', strtotime($row['tanggal'])); ?>', '<?= $row['catatan']; ?>')">Tgl</button>
                                                <button class="btn btn-warning btn-sm" onclick="editMP(<?= $row['id_pmm']; ?>)">MP</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div id="modalTanggal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update MP</h5>
                <button type="button" class="close" onclick="$('#modalMP').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('pmmonthly/update_tanggal2') ?>" method="post">
                    <input type="hidden" name="id_pmm" id="id_pmm_tgl">
                    
                    <div class="form-group">
                        <label for="tanggal">Tanggal lama</label>
                        <input type="date" id="tanggal_tgl" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal Baru</label>
                        <input type="date" name="tanggal" id="tanggal_tgl" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="catatan_mp">Catatan</label>
                        <input type="text" name="catatan" id="catatan_tgl" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update MP -->
<div id="modalMP" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update MP</h5>
                <button type="button" class="close" onclick="$('#modalMP').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('pmmonthly/update_mp') ?>" method="post">
                    <input type="hidden" name="id_pmm" id="id_pmm_mp">
                    
                    <div class="form-group">
                        <label for="id_users">MP</label>
                        <select name="id_users" id="id_users" class="form-control">
                            <?php foreach ($manpower as $mp): ?>
                                <option value="<?= $mp['id_users']; ?>"><?= $mp['dipname']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="catatan_mp">Catatan</label>
                        <input type="text" name="catatan" id="catatan_mp" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modalTanggalStatus" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update MP</h5>
                <button type="button" class="close" onclick="$('#modalMP').modal('hide')">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('pmmonthly/update_tanggal') ?>" method="post">
                    <input type="hidden" name="id_pmm" id="id_pmm_tglstts">
                    
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="catatan_mp">Catatan</label>
                        <input type="text" name="catatan" id="catatan_mp" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editTanggal(id, tanggal, catatan) {
        document.getElementById("id_pmm_tgl").value = id;
        document.getElementById("tanggal_tgl").value = tanggal;
        $('#modalTanggal').modal('show');
    }

    function editMP(id) {
        document.getElementById("id_pmm_mp").value = id;
        $('#modalMP').modal('show'); // Menggunakan Bootstrap modal
    }

    function editTanggalStatus(id) {
        document.getElementById("id_pmm_tglstts").value = id;
        $('#modalTanggalStatus').modal('show'); // Menggunakan Bootstrap modal
    }

</script>

<?php $this->load->view('layouts/footer'); ?>
