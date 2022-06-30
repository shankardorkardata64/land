
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="d-flex flex-column align-items-center text-center">
											<div class="mt-3">
												<h4><?=$users['fname']?> <?=$users['lname']?></h4>
												
                                                <p class="mb-1">Username:-<?=$users['username']?></p>
												<p class="font-size-sm">Email <?=$users['email']?></p>
												
											</div>
										</div>
										<hr class="my-4" />
									
									</div>
								</div>
							</div>
							<div class="col-lg-8">
								<div class="card">
									<div class="card-body">
                                    <?php echo form_open('profile-update',
                                     array('autocomplete'=>'off','method'=>'post',
                                     'class'=>'rojw g-j3','id' => 'mjy_id')); ?>
									
									
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">First Name</h6>
											</div>
											<div class="col-sm-9">
												<input type="text" required name='fname' class="form-control" value="<?=$users['fname']?>" />
											</div>
										</div>

                                        <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Last Name</h6>
											</div>
											<div class="col-sm-9">
												<input type="text"  name='lname' class="form-control" value="<?=$users['lname']?>" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Email</h6>
											</div>
											<div class="col-sm-9">
												<input type="text" required name='email' class="form-control" value="<?=$users['email']?>" />
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3"></div>
											<div class="col-sm-9">
												<input type="submit"
                                                 class="btn btn-light px-4" value="Save Changes" />
											</div>
										</div>

                                        <?php echo form_close();?>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-body">
                                            <?php echo form_open('profile-password-update',
                                     array('autocomplete'=>'off','method'=>'post',
                                     'class'=>'rojw g-j3','id' => 'mjy_id')); ?>
									
									
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Old Password</h6>
											</div>
											<div class="col-sm-9">
												<input type="password" required name='opassword' class="form-control" value="" />
											</div>
										</div>

                                        <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">New Password</h6>
											</div>
											<div class="col-sm-9">
												<input type="password"  name='npassword' class="form-control" value="" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Confirm New Password</h6>
											</div>
											<div class="col-sm-9">
												<input type="password" required name='cpassword' class="form-control" value="" />
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3"></div>
											<div class="col-sm-9">
												<input type="submit"
                                                 class="btn btn-light px-4" value="Save Changes" />
											</div>
										</div>

                                        <?php echo form_close();?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>