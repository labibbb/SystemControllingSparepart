<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">	
	  	<div class="multinav">
		  <div class="multinav-scroll" style="height: 100%;">	
			  <!-- sidebar menu-->
			  <ul class="sidebar-menu" data-widget="tree">	
				<li class="header">Dashboard & Apps</li>
				<li class="treeview">
				<a href="javascript:void(0);" onclick="window.location.href='<?= site_url('dashboard'); ?>'">
					<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
					<span>Dashboard</span>
				</a>
				</li>
                <li class="treeview">
				  <a href="#">
					<i span class="icon-Layout-grid"><span class="path1"></span><span class="path2"></span></i>
					<span>Master</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="<?= site_url('lini'); ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Lini</a></li>
					<li><a href="<?= site_url('area'); ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Area</a></li>
					<li><a href="<?= site_url('mesin'); ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Mesin</a></li>
					<li><a href="<?= site_url('manpower'); ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Man Power</a></li>
					<li><a href="<?= site_url('departemen'); ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Departemen</a></li>
					<li><a href="<?= site_url('user'); ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>User</a></li>
					<li><a href="<?= site_url('jobdeskripsi'); ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Job Deskripsi</a></li>
				  </ul>
				</li>
				<li class="treeview">
				  <a href="#">
					<i span class="icon-Layout-grid"><span class="path1"></span><span class="path2"></span></i>
					<span>Transaksi</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="<?= site_url('settingfwm'); ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Setting Freq & Work Instruction PM</a></li>
				  </ul>
				</li> 	     
			  </ul>
		  </div>
		</div>
    </section>
</aside>