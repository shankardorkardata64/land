<style>
	.form_validation_error
	{
	font-size: 10px;
    color: #e31b1b;
    background: white;
	}
	</style>
	<?php
$setting=setting();

?>
<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<!-- <img src="<?php asset('assets/images/logo-img.png') ?>" width="180" alt="" /> -->
							<?=$setting['systemname'];?>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Verify Email</h3>
										
                                        
							     	<?php getalert(); ?>
									</div>
									<div class="d-grid">
									<div class="form-body">
                                    <?php echo form_open_multipart('email-verify', array('autocomplete'=>'off','method'=>'post','class'=>'row g-3','id' => 'my_id')); ?>
											<div class="col-sm-12">
												<label for="inputFirstName"
                                                 class="form-label">Enter OTP </label>
												<input type="text"
												value="<?php echo $otp; ?>" 
                                                name='otp' required class="form-control" 
                                                id="inputFirstName" placeholder="Enter OTP">
											    
												<?php echo form_error('otp'); ?>
											</div>

                                            <p>Dont have recived Email ? 
                                                <a href="<?php echo base_url('resend-email/'.$token)?>">
                                                Resend here</a>
										</p>

                                            <input type='hidden' value='<?=$token?>' name='token'>
                                    <div class="col-12">
												<div class="d-grid">
													<button type="submit" 
                                                    class="btn btn-light"><i class='bx bx-user'></i>
                                                    Verify </button>
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
				</div>
				<!--end row-->
			</div>
		</div>