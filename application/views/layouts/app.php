<!doctype html>
<html lang="en">
<?php
$setting=setting();

?>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?php asset('assets/images/favicon-32x32.png') ?>" type="image/png" />
	<!--plugins-->
	<link href="<?php  asset('assets/plugins/simplebar/css/simplebar.css') ?>" rel="stylesheet" />
	<link href="<?php  asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') ?>" rel="stylesheet" />
	<link href="<?php  asset('assets/plugins/metismenu/css/metisMenu.min.css') ?>" rel="stylesheet" />
	<!-- loader-->
	<link href="<?php  asset('assets/css/pace.min.css') ?>" rel="stylesheet" />
	<script src="<?php  asset('assets/js/pace.min.js') ?>"></script>
	<!-- Bootstrap CSS -->
	<link href="<?php  asset('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?php  asset('assets/css/app.css') ?>" rel="stylesheet">
	<link href="<?php  asset('assets/css/icons.css') ?>" rel="stylesheet">
	<link href="<?php asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') ?>" rel="stylesheet" />
	
	<title><?=$setting['systemname'];?></title>
	
	<!-- <script>
			$('form').attr('autocomplete', 'off');
	</script> -->

</head>

<body class="bg-theme bg-theme9">
	<!--wrapper-->
	<div class="wrapper">
		
		<?php 
		    // include("header.php");
			 $this->load->view('layouts/header');
    	      // include("nav.php");
			   
			 $this->load->view('layouts/nav');
			   
        ?>	
		



		              
			<div class="page-wrapper">
			<div class="page-contsent">
			<?php getalert(); ?>
