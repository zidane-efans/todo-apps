<div class="topbar">
    <div class="d-flex align-items-center w-50">
        <button class="btn border-0 text-muted me-3" id="sidebarToggle"><i class="fa-solid fa-bars fs-5"></i></button>
        <div class="input-group d-none d-sm-flex">
            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-search text-muted"></i></span>
            <input type="text" class="form-control bg-light border-0 shadow-none" placeholder="Search projects or tasks...">
        </div>
    </div>
    
    <div class="d-flex align-items-center">
        <div class="dropdown me-4">
            <a href="#" class="text-secondary position-relative dropdown-toggle d-none d-sm-block" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration:none;">
                <i class="fa-regular fa-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li><h6 class="dropdown-header">Notifications</h6></li>
                <li><a class="dropdown-item" href="#">You have an overdue task</a></li>
                <li><a class="dropdown-item" href="#">Meeting at 3 PM</a></li>
            </ul>
        </div>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar" style="width: 35px; height: 35px;">
                    <?= substr($this->session->userdata('name'), 0, 1) ?>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li><a class="dropdown-item" href="<?= site_url('profile') ?>"><i class="fa-regular fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gear me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= site_url('auth/logout') ?>"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>
