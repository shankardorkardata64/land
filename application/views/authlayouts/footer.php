	
		<?php
$setting=setting();

?>


	</div>
	<!--end wrapper-->
	<!--start switcher-->

        <footer class="page-footer" style='
    background: rgb(0 0 0 / 20%);
    position: absolute;
    left: 0px;
    right: 0;
    text-align: center;
    padding: 7px;
    color: #fff;
    font-size: 14px;
    border-top: 1px solid rgb(255 255 255 / 15%);
    z-index: 3;'>
			<p class="mb-0">Copyright <?=$setting['systemname'];?> © 2022. All right reserved.</p>
		</footer> 

		<script>
			$('form').attr('autocomplete', 'off');
			</script>
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="<?php  asset('assets/js/bootstrap.bundle.min.js') ?>"></script>
	<!--plugins-->
	<script src="<?php  asset('assets/js/jquery.min.js') ?>"></script>
	<script src="<?php  asset('assets/plugins/simplebar/js/simplebar.min.js') ?>"></script>
	<script src="<?php  asset('assets/plugins/metismenu/js/metisMenu.min.js') ?>"></script>
	<script src="<?php  asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') ?>"></script>
	<!--app JS-->
	<script src="<?php  asset('assets/js/app.js') ?>"></script>
	
</body>

</html>