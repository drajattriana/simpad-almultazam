<!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="<?=  base_url () ?>" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="<?= base_url('assets/img/logo.png') ?>"
              alt="Almultazam"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">AL-MULTAZAM</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
            
            <?php
            foreach ($auth as $nama_menu  => $submenus) : ?>
              <li class="nav-header"><?=  $nama_menu  ?></li>
              
              <?php foreach ($submenus as $submenu) : ?>
                <li class="nav-item">
                  <a href="<?=  base_url ($submenu['url']) ?>" class="nav-link <?= ($hal == $submenu['id']) ? 'active' : '' ?>">
                    <i class="nav-icon <?=  $submenu['icon'] ?>"></i>
                    <p><?= $submenu['name'] ?></p>
                  </a>
                </li>
              <?php endforeach; endforeach;  ?>
  
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->