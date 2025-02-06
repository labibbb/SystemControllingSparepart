<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= base_url() ?>public/images/favicon.ico">

    <title>CMMS - 4W</title>
  
	<!-- Vendors Style-->
	<link rel="stylesheet" href="<?= base_url() ?>public/main/css/vendors_css.css">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="<?= base_url() ?>public/main/css/style.css">
	<link rel="stylesheet" href="<?= base_url() ?>public/main/css/skin_color.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.5/sweetalert2.min.css">

</head>
	
<body class="hold-transition theme-primary bg-img" style="background-image: url(<?= base_url() ?>public/images/auth-bg/bg-1.jpg)">
	
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">	
			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<h2 class="text-primary">Let's Get Started</h2>
								<p class="mb-0">Application Login CMMS 4W</p>							
							</div>
							<div class="p-40">
								<form id="loginForm">
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
											<input type="text" class="form-control ps-15 bg-transparent" name="username" placeholder="Username" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
											<input type="password" class="form-control ps-15 bg-transparent" name="password" placeholder="Password" required>
										</div>
									</div>
									<div class="row">
										<div class="col-12 text-center">
										  <button type="submit" class="btn btn-primary mt-10">Login</button>
										</div>
									</div>
								</form>		
							</div>						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="<?= base_url() ?>public/main/js/vendors.min.js"></script>
	<script src="<?= base_url() ?>public/main/js/pages/chat-popup.js"></script>
    <script src="<?= base_url() ?>public/assets/icons/feather-icons/feather.min.js"></script>	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.5/sweetalert2.all.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault(); // Mencegah reload halaman
            
            $.ajax({
                url: '<?= site_url("login/process_login") ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: "Memproses...",
                        text: "Mohon tunggu sebentar",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Berhasil!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Gagal!',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Silakan coba lagi nanti.'
                    });
                }
            });
        });
    });
    </script>
</body>
</html>
