<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>
<div class="content-wrapper">
	<div class="container-full">
		<!-- Main content -->
		<section class="content">
			<h1 class="mb-30"><strong>DASHBOARD MONTHLY PLANNING</strong></h1>				
			<div class="row d-flex">
				<div class="col">
					<a class="box box-link-shadow text-center pull-up border border-2 border-primary" href="javascript:void(0)">
						<div class="box-body py-25 bg-primary px-5">
							<p class="fw-600 text-white" style="font-size: 20px;">
							  <i class="ti-settings me-15 fs-4"></i>IN PROCESS
							</p>
						</div>						  
						<div class="box-body" style="text-align: right;">	
							<h1 class="countnm fs-50 m-0"><?= $inProcess ?></h1>
						</div>
					</a>
				</div>					
				<div class="col">
				  <a class="box box-link-shadow text-center pull-up border border-2 border-primary" href="javascript:void(0)">
					<div class="box-body py-25 bg-primary px-5">
					  <p class="fw-600 text-white" style="font-size: 20px;"><i class="mdi mdi-timer-sand me-15 fs-4"></i>WAITING APPROVE SPV</p>
					</div>
					<div class="box-body" style="text-align: right;">
					  <h1 class="countnm fs-50 m-0" ><?= $waitingApproval ?></h1>
					</div>
				  </a>
				</div>
				<div class="col">
				  <a class="box box-link-shadow text-center pull-up border border-2 border-danger" href="javascript:void(0)">
					<div class="box-body py-25 bg-danger px-5">
						<p class="fw-600 text-white" style="font-size: 20px;">
							<i class="fa fa-times me-15 fs-4"></i>REJECT CHECK
						</p>		
					</div>
					<div class="box-body" style="text-align: right;">
					  <h1 class="countnm fs-50 m-0 text-danger"><?= $rejected ?></h1>
					</div>
				  </a>
				</div>
				<div class="col">
				  <a class="box box-link-shadow text-center pull-up border border-2 border-primary" href="javascript:void(0)">
					<div class="box-body py-25 bg-primary px-5">
						<p class="fw-600 text-white" style="font-size: 20px;"</p>
							<i class="fa fa-check-square me-15 fs-4"></i>FINISH CHECK
						</p>
					</div>
					<div class="box-body" style="text-align: right;">
					  <h1 class="countnm fs-50 m-0"><?= $completeAll ?></h1>
					</div>
				  </a>
				</div>
				<div class="col">
				  <a class="box box-link-shadow text-center pull-up border border-2 border-primary" href="javascript:void(0)">
					<div class="box-body py-25 bg-primary px-5">
					  <p class="fw-600 text-white" style="font-size: 20px;"><i class="si-plus si me-15 fs-4"></i>TOTAL</p>
					</div>
					<div class="box-body" style="text-align: right;">
					  <h1 class="countnm fs-50 m-0" ><?= $total ?></h1>
					</div>
				  </a>
				</div>
			</div>			  
		</section>
		<section class="content">
			<div class="row">
				<div class="col-md-6">
					<h3 class="text-center">Today PM: Painting 1</h3>
					<div class="table-responsive">
						<table id="table1" class="table table-bordered table-striped">
							<thead class="bg-primary text-white">
								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Area</th>
									<th>Mesin</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody id="table1-body">
								<?php $no = 1; foreach ($pmmonthly as $row): ?>
									<tr>
										<td><?= $no++; ?></td>
										<td class="tanggal"><?= date('Y-m-d', strtotime($row['tanggal'])); ?></td>
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
                                                    echo '<span class="badge bg-warning">Sudah Terjadwal</span>';
                                                    break;
                                                case 3:
                                                    echo '<span class="badge bg-success">Sudah Terjadwal</span>';
                                                    break;
                                                case 4:
                                                    echo '<span class="badge bg-warning">On Progress Checking</span>';
                                                    break;
                                                case 5:
                                                    echo '<span class="badge bg-warning">Waiting Approval Foreman</span>';
                                                    break;
                                                case 6:
                                                    echo '<span class="badge bg-success">Waiting Approval Supervisor</span>';
                                                    break;
                                                case 7:
                                                    echo '<span class="badge bg-danger">Rejected by Foreman</span>';
                                                    break;
                                                case 8:
                                                    echo '<span class="badge bg-success">Complete All</span>';
                                                    break;
                                                case 9:
                                                    echo '<span class="badge bg-danger">Rejected by Superviosr</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                                                    break;
                                            }
                                            ?>
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
							<thead class="bg-primary text-white">
								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Area</th>
									<th>Mesin</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody id="table2-body">
								<?php $no = 1; foreach ($pmmonthly2 as $row): ?>
									<tr>
										<td><?= $no++; ?></td>
										<td class="tanggal"><?= date('Y-m-d', strtotime($row['tanggal'])); ?></td>
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
                                                    echo '<span class="badge bg-warning">Sudah Terjadwal</span>';
                                                    break;
                                                case 3:
                                                    echo '<span class="badge bg-success">Sudah Terjadwal</span>';
                                                    break;
                                                case 4:
                                                    echo '<span class="badge bg-warning">On Progress Checking</span>';
                                                    break;
                                                case 5:
                                                    echo '<span class="badge bg-warning">Waiting Approval Foreman</span>';
                                                    break;
                                                case 6:
                                                    echo '<span class="badge bg-success">Waiting Approval Supervisor</span>';
                                                    break;
                                                case 7:
                                                    echo '<span class="badge bg-danger">Rejected by Foreman</span>';
                                                    break;
                                                case 8:
                                                    echo '<span class="badge bg-success">Complete All</span>';
                                                    break;
                                                case 9:
                                                    echo '<span class="badge bg-danger">Rejected by Superviosr</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                                                    break;
                                            }
                                            ?>
                                        </td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</section>	  		  
		<!-- /.content -->
    </div>
</div>
<script>
   $(document).ready(function() {
    var table1 = $('#table1').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "Tidak ada data yang tersedia di tabel",
            "info":           "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "infoEmpty":      "Menampilkan 0 sampai 0 dari 0 entri",
            "infoFiltered":   "(disaring dari _MAX_ total entri)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Tampilkan _MENU_ entri",
            "loadingRecords": "Memuat...",
            "processing":     "Sedang diproses...",
            "search":         "Cari:",
            "zeroRecords":    "Tidak ditemukan data yang cocok",
            "paginate": {
                "first":      "Pertama",
                "last":       "Terakhir",
                "next":       "Selanjutnya",
                "previous":   "Sebelumnya"
            },
            "aria": {
                "sortAscending":  ": aktifkan untuk mengurutkan kolom naik",
                "sortDescending": ": aktifkan untuk mengurutkan kolom turun"
            }
        }
    });
    
    var table2 = $('#table2').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "Tidak ada data yang tersedia di tabel",
            "info":           "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "infoEmpty":      "Menampilkan 0 sampai 0 dari 0 entri",
            "infoFiltered":   "(disaring dari _MAX_ total entri)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Tampilkan _MENU_ entri",
            "loadingRecords": "Memuat...",
            "processing":     "Sedang diproses...",
            "search":         "Cari:",
            "zeroRecords":    "Tidak ditemukan data yang cocok",
            "paginate": {
                "first":      "Pertama",
                "last":       "Terakhir",
                "next":       "Selanjutnya",
                "previous":   "Sebelumnya"
            },
            "aria": {
                "sortAscending":  ": aktifkan untuk mengurutkan kolom naik",
                "sortDescending": ": aktifkan untuk mengurutkan kolom turun"
            }
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if ($this->session->userdata('level') == 3): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var hasPainting1 = <?= count($pmmonthly) ?> > 0;
            var hasPainting2 = <?= count($pmmonthly2) ?> > 0;

            if (hasPainting1 || hasPainting2) {
                var message = 'Anda memiliki pekerjaan hari ini di:';
                if (hasPainting1 && hasPainting2) {
                    message += '\n- Painting 1\n- Painting 2';
                } else if (hasPainting1) {
                    message += '\n- Painting 1';
                } else {
                    message += '\n- Painting 2';
                }

                Swal.fire({
                    title: 'Pekerjaan Hari Ini!',
                    text: message,
                    icon: 'info',
                    confirmButtonText: 'OK',
                    timer: 5000,
                    timerProgressBar: true,
                    toast: false,
                    position: 'center',
                    showConfirmButton: true
                });
            }
        });
    </script>
<?php endif; ?>


<?php $this->load->view('layouts/footer'); ?>