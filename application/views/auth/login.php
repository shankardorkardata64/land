<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
<?php
$setting=setting();

?>	<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<!-- <img src="<?php asset('assets/images/logo-img.png') ?>" width="180" alt="" /> -->
							<h2><?=$setting['systemname'];?> </h3>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Sign in</h3>
										<!-- <p>Don't have an account yet? <a href="<?php url('register') ?>">Sign up here</a> -->
										</p>
										<?php getalert(); ?>
									</div>
									<div class="d-grid">
									<div class="form-body">
									<?php echo form_open_multipart('login', array('autocomplete'=>'off','method'=>'post','class'=>'row g-3','id' => 'my_id')); ?>
									
									<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Username</label>
												<input type="text" name='username' class="form-control" id="inputEmailAddress" placeholder="Enter Username">
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Enter Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" name='password' class="form-control border-end-0" id="inputChoosePassword" value="12345678" placeholder="Enter Password"> 
                                                    
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
												</div>
											</div>
											<!-- <div class="col-md-6 text-end">	<a href="<?php url('authentication-forgot-password') ?>">Forgot Password ?</a> -->
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-light"><i class="bx bxs-lock-open"></i>Sign in</button>
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