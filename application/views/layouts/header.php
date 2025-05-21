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

    <title>CMMS - CW</title>
    
	<!-- Vendors Style-->
	<link rel="stylesheet" href="<?= base_url() ?>public/main/css/vendors_css.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
 
	<!-- Style-->  
	<link rel="stylesheet" href="<?= base_url() ?>public/main/css/style.css">
	<link rel="stylesheet" href="<?= base_url() ?>public/main/css/skin_color.css">
     
  </head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
	
<div class="wrapper">
	<div id="loader"></div>
	
  <header class="main-header">
	<div class="d-flex align-items-center logo-box justify-content-start">
		<a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent" data-toggle="push-menu" role="button">
			<span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
		</a>	
		<!-- Logo -->
		<a href="dashboard" class="logo">
  <!-- logo-->
  <div class="logo-lg">
    <span class="light-logo" style="cursor: default; pointer-events: none;">
        <!-- <img src="<?= base_url() ?>public/images/logo-hitam-pako.png" alt="logo"
             style="width: 150px; height: 40px; pointer-events: none; user-select: none;" draggable="false"> -->
    </span>
</div>

</a>
	</div>  
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
	  <div class="app-menu">
		<ul class="header-megamenu nav">
			<li class="btn-group nav-item d-md-none">
				<a href="#" class="waves-effect waves-light nav-link push-btn" data-toggle="push-menu" role="button">
					<span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
			    </a>
			</li>
		</ul> 
	  </div>
		
      <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">
			<div class="me-3 text-white" id="currentDateTime"></div>

			<li class="dropdown user user-menu">
				<a href="#" class="waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" title="User">
					<i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
				</a>
				<ul class="dropdown-menu animated flipInX">
				  <li class="user-body">
					 <a class="dropdown-item" href="#"><i class="ti-user text-muted me-2"></i> Profile</a>
					 <div class="dropdown-divider"></div>
					 <li>
                        <a href="<?= site_url('login'); ?>">
                            <i class="icon-Logout"><span class="path1"></span><span class="path2"></span></i>
                            <span>Logout</span>
                        </a>
                    </li> 
				  </li>
				</ul>
			</li>	
        </ul>
      </div>
    </nav>
  </header>