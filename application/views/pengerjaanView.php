<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <!-- Tabel Kiri -->
                        <div class="col-md-6">
                        <h3 class="text-center">Today PM: Painting 1</h3>

                        <!-- Tabel Data -->
                        <div class="table-responsive">
                            <table id="table1" class="table table-bordered table-striped">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Area</th>
                                        <th>Mesin</th>
                                        <th>Check</th>
                                    </tr>
                                </thead>
                                <tbody id="table1-body">
                                    <?php $no = 1; foreach ($pmmonthly as $row): ?>
                                        <tr>
                                            <td style="font-size: 12px; padding: 3px;"><?= $no++; ?></td>
                                            <td style="font-size: 12px; padding: 3px;"><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                            <td style="font-size: 12px; padding: 3px;"><?= $row['nama_area']; ?></td>
                                            <td style="font-size: 12px; padding: 3px;"><?= $row['nama_mesin']; ?></td>
                                            <td>
                                                <?php if ($row['status'] == 3): ?>
                                                    <form action="<?= site_url('pengerjaan/Detail'); ?>" method="post">
                                                        <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                        <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                        <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                        <button type="submit" class="btn btn-warning btn-sm">Buka</button>
                                                    </form>
                                                <?php elseif ($row['status'] == 4): ?>
                                                    <form action="<?= site_url('pengerjaan/Detail'); ?>" method="post">
                                                        <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                        <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                        <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                        <button type="submit" class="btn btn-warning btn-sm">Buka</button>
                                                    </form>
                                                <?php elseif ($row['status'] == 5): ?>
                                                    <button class="btn btn-secondary btn-sm" style="padding: 2px 5px; font-size: 12px;" disabled>Menunggu Approval</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        </div>

                        <!-- Tabel Kanan -->
                        <div class="col-md-6">
                            <h3 class="text-center">Today PM: Painting 2</h3>
                            <div class="table-responsive">
                                <table id="table2" class="table table-bordered table-striped">
                                <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Area</th>
                                            <th>Mesin</th>
                                            <th>Check</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table2-body">
                                        <?php 
                                        $no = 1;
                                        foreach ($pmmonthly2 as $row): ?>
                                            <tr>
                                                <td style="font-size: 12px; padding: 3px;"><?= $no++; ?></td>
                                                <td style="font-size: 12px; padding: 3px;"><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                                <td style="font-size: 12px; padding: 3px;"><?= $row['nama_area']; ?></td>
                                                <td style="font-size: 12px; padding: 3px;"><?= $row['nama_mesin']; ?></td>
                                                <td>
                                                    <?php if ($row['status'] == 3): ?>
                                                        <form action="<?= site_url('pengerjaan/Detail'); ?>" method="post">
                                                            <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                            <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                            <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                            <button type="submit" class="btn btn-warning btn-sm">Buka</button>
                                                        </form>
                                                        <?php elseif ($row['status'] == 4): ?>
                                                    <form action="<?= site_url('pengerjaan/Detail'); ?>" method="post">
                                                        <input type="hidden" name="id_mesin" value="<?= $row['id_mesin']; ?>">
                                                        <input type="hidden" name="tanggal" value="<?= $row['tanggal']; ?>">
                                                        <input type="hidden" name="id_pmm" value="<?= $row['id_pmm']; ?>">
                                                        <button type="submit" class="btn btn-warning btn-sm">Buka</button>
                                                    </form>
                                                    <?php elseif ($row['status'] == 5): ?>
                                                        <button class="btn btn-secondary btn-sm" style="padding: 2px 5px; font-size: 12px;" disabled>Menunggu Approval</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div> <!-- End Row -->
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table1').DataTable({
            "ordering": true, // Mengaktifkan sorting
            "paging": true,   // Mengaktifkan paginasi
            "searching": true // Mengaktifkan fitur pencarian
        });

        $('#table2').DataTable({
            "ordering": true,
            "paging": true,
            "searching": true
        });

    });
</script>
<?php $this->load->view('layouts/footer'); ?>
