<!-- Sidebar -->
		<div class="sidebar">
			
			<div class="sidebar-background"></div>
			<div class="sidebar-wrapper scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="<?= base_url('assets/img/user.jpg') ?>" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									<?= session()->get('username') ?>
									<span class="user-level"><?= session()->get('role_name') ?></span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<!-- <li>
										<a href="#profile">
											<span class="link-collapse">My Profile</span>
										</a>
									</li>
									<li>
										<a href="#settings">
											<span class="link-collapse">Settings</span>
										</a>
									</li> -->
									<li>
										<a href="<?= base_url('logout') ?>">
											<span class="link-collapse">Logout</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav">
                        

                    
                    <?php
                    foreach ($auth as $nama_menu  => $submenus) : ?>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section"><?=  $nama_menu  ?></h4>
						</li>
						
                    
                    <?php foreach ($submenus as $submenu) : ?>
						<li class="nav-item <?= ($hal == $submenu['id']) ? 'active' : '' ?>">
							<a href="<?=  base_url ($submenu['url']) ?>">
								<i class="<?=  $submenu['icon'] ?>"></i>
								<p><?= $submenu['name'] ?></p>
							</a>
						</li>
                    
                    <?php endforeach; endforeach;  ?>
					
                </ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->