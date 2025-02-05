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

    <title>EduAdmin</title>
    
	<!-- Vendors Style-->
	<link rel="stylesheet" href="<?= base_url() ?>public/main/css/vendors_css.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
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
		<a href="index.html" class="logo">
		  <!-- logo-->
		  <div class="logo-lg">
			  <span class="light-logo"><img src="<?= base_url() ?>public/images/logo-dark-text.png" alt="logo"></span>
			  <span class="dark-logo"><img src="<?= base_url() ?>public/images/logo-light-text.png" alt="logo"></span>
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
					 <a class="dropdown-item" href="#"><i class="ti-wallet text-muted me-2"></i> My Wallet</a>
					 <a class="dropdown-item" href="#"><i class="ti-settings text-muted me-2"></i> Settings</a>
					 <div class="dropdown-divider"></div>
					 <a class="dropdown-item" href="#"><i class="ti-lock text-muted me-2"></i> Logout</a>
				  </li>
				</ul>
			</li>	
        </ul>
      </div>
    </nav>
  </header>