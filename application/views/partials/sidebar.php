<div class="sidebar">
    <div class="brand">
        <i class="fa-solid fa-layer-group me-2"></i> TaskFlow
    </div>
    
    <div class="nav-menu">
        <a href="<?= site_url('dashboard') ?>" class="nav-item <?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>
        <a href="<?= site_url('projects') ?>" class="nav-item <?= $this->uri->segment(1) == 'projects' ? 'active' : '' ?>">
            <i class="fa-solid fa-folder-open"></i> Projects
        </a>
        <a href="<?= site_url('tasks') ?>" class="nav-item <?= $this->uri->segment(1) == 'tasks' ? 'active' : '' ?>">
            <i class="fa-solid fa-list-check"></i> Tasks
        </a>
        <a href="<?= site_url('progress') ?>" class="nav-item <?= $this->uri->segment(1) == 'progress' ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-line"></i> Progress
        </a>
        <a href="<?= site_url('activity') ?>" class="nav-item <?= $this->uri->segment(1) == 'activity' ? 'active' : '' ?>">
            <i class="fa-solid fa-file-invoice"></i> Activity Reports
        </a>

        <a href="#" class="nav-item">
            <i class="fa-solid fa-gear"></i> Settings
        </a>
    </div>

    <div class="user-profile-card">
        <div class="user-avatar">
            <?= substr($this->session->userdata('name'), 0, 1) ?>
        </div>
        <div>
            <div class="fw-bold fs-6 text-truncate" style="max-width: 150px;"><?= $this->session->userdata('name') ?></div>
            <div class="text-muted small"><?= $this->session->userdata('role') ?></div>
        </div>
    </div>
</div>
