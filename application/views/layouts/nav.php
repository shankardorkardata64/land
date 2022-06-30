<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<!-- <img src="<?php asset('assets/images/logo-icon.png') ?>" class="logo-icon" alt="logo icon"> -->
				</div>
				<div>
					<h4 class="logo-text">Vertical Logo</h4> 
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
			<li><a href="<?=base_url('dashboard')?>" class="has-agrrow">
			<div><i class='bx bx-home-circle'></i>
			</div>
			<div class="menu-title">Dashboard</div>
			</a>
			</li>

			 <?php if($this->session->userdata('role')==1) { ?>
			<li><a href="<?=base_url('manage-user')?>" class="has-agrrow">
			<div><i class='bx bx-user'></i>
			</div>
			<div class="menu-title">Users</div>
			</a>
			</li>
			<?php } ?>

			<li><a href="<?=base_url('profile')?>" class="has-agrrow">
			<div><i class='bx bx-user'></i>
			</div>
			<div class="menu-title">profile</div>
			</a>
			</li>

			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->