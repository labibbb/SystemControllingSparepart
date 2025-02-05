<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/sidebar'); ?>
<div class="content-wrapper">
	<div class="container-full">
		<!-- Main content -->
		<section class="content">
			<h1><strong>DASHBOARD SUPERVISOR MTC</strong></h1>
			<div class="form-group">
				<div class="controls">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Terdapat abnormality yang belum di follow > 2 hari total abnormality = 1 temuan" disabled style="background-color: white; color: black; font-size: 18px; padding: 12px;">
						<button class="btn btn-primary" type="button" style="margin-left: 8px; font-size: 18px; padding: 12px 20px;">OPEN</button>
					</div>
				</div>
			</div>						
			<div class="row d-flex">
				<div class="col">
					<a class="box box-link-shadow text-center pull-up border border-2 border-primary" href="javascript:void(0)">
						<div class="box-body py-25 bg-primary px-5">
							<p class="fw-600 text-white" style="font-size: 20px;">
							  <i class="ti-settings me-15 fs-4"></i>IN PROCESS
							</p>
						</div>						  
						<div class="box-body" style="text-align: right;">	
							<h1 class="countnm fs-50 m-0">5</h1>
							<button type="button" class="waves-effect waves-light btn btn-outline btn-rounded btn-primary mb-5 btn-sm" style="margin-top: 22px;">More Info<i class="fa fa-fw fa-arrow-circle-o-right"></i></button>
						</div>
					</a>
				</div>					
				<div class="col">
				  <a class="box box-link-shadow text-center pull-up border border-2 border-primary" href="javascript:void(0)">
					<div class="box-body py-25 bg-primary px-5">
					  <p class="fw-600 text-white" style="font-size: 20px;"><i class="mdi mdi-timer-sand me-15 fs-4"></i>WAITING APPROVE SPV</p>
					</div>
					<div class="box-body" style="text-align: right;">
					  <h1 class="countnm fs-50 m-0" >25</h1>
					  <button type="button" class="waves-effect waves-light btn btn-outline btn-rounded btn-primary mb-5 btn-sm" style="margin-top: 22px;">More Info<i class="fa fa-fw fa-arrow-circle-o-right"></i></button>
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
					  <h1 class="countnm fs-50 m-0 text-danger">5</h1>
					  <button type="button" class="waves-effect waves-light btn btn-outline btn-rounded btn-danger mb-5 btn-sm" style="margin-top: 22px;">More Info<i class="fa fa-fw fa-arrow-circle-o-right"></i></button>
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
					  <h1 class="countnm fs-50 m-0">25</h1>
					  <button type="button" class="waves-effect waves-light btn btn-outline btn-rounded btn-primary mb-5 btn-sm" style="margin-top: 22px;">More Info<i class="fa fa-fw fa-arrow-circle-o-right"></i></button>
					</div>
				  </a>
				</div>
				<div class="col">
				  <a class="box box-link-shadow text-center pull-up border border-2 border-primary" href="javascript:void(0)">
					<div class="box-body py-25 bg-primary px-5">
					  <p class="fw-600 text-white" style="font-size: 20px;"><i class="si-plus si me-15 fs-4"></i>TOTAL</p>
					</div>
					<div class="box-body" style="text-align: right;">
					  <h1 class="countnm fs-50 m-0" >5</h1>
					  <button type="button" class="waves-effect waves-light btn btn-outline btn-rounded btn-primary mb-5 btn-sm" style="margin-top: 22px;">More Info<i class="fa fa-fw fa-arrow-circle-o-right"></i></button>
					</div>
				  </a>
				</div>
			</div>			  
		</section>
		<section class="content">
			<div class="row">
				<div class="col-lg-6">
					<div class="box">
						<div class="box-body">
							<h2 class="box-title" >Today PM : PAINTING 1</h2>
							<div class="table-responsive">
								<table class="table" style="font-size: 15px;">
									<thead class="bg-primary">
										<tr>
											<th>No</th>
											<th>Tanggal</th>
											<th>Area</th>
											<th>Mesin</th>
											<th>Status</th>
											<th>Check</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>23-01-2025</td>
											<td>Bake Oven</td>
											<td>Conveyor Unloading</td>
											<td>-</td>
											<td>-</td>
										</tr>
										<tr>
											<td>2</td>
											<td>23-01-2025</td>
											<td>Bake Oven</td>
											<td>Conveyor Unloading</td>
											<td>-</td>
											<td>-</td>
										</tr>
										<tr>
											<td>3</td>
											<td>23-01-2025</td>
											<td>Bake Oven</td>
											<td>Conveyor Unloading</td>
											<td>-</td>
											<td>-</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box">
						<div class="box-body">
							<h2 class="box-title">Today PM : PAINTING 2</h2>
							<div class="table-responsive">
								<table class="table" style="font-size: 15px;">
									<thead class="bg-primary">
										<tr>
											<th>No</th>
											<th>Tanggal</th>
											<th>Area</th>
											<th>Mesin</th>
											<th>Status</th>
											<th>Check</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>23-01-2025</td>
											<td>Bake Oven</td>
											<td>Conveyor Unloading</td>
											<td>-</td>
											<td>-</td>
										</tr>
										<tr>
											<td>2</td>
											<td>23-01-2025</td>
											<td>Bake Oven</td>
											<td>Conveyor Unloading</td>
											<td>-</td>
											<td>-</td>
										</tr>
										<tr>
											<td>3</td>
											<td>23-01-2025</td>
											<td>Bake Oven</td>
											<td>Conveyor Unloading</td>
											<td>-</td>
											<td>-</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>	  		  
		<!-- /.content -->
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>