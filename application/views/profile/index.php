<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-0 text-dark fw-bold">My Profile</h4>
        <p class="text-muted">Manage your personal information and security settings.</p>
    </div>
</div>

<div class="row g-4">
    <!-- User Overview Card -->
    <div class="col-md-4">
        <div class="card glass border-0 shadow-sm h-100 text-center p-4">
            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow" style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold;">
                <?= strtoupper(substr($user->name, 0, 1)) ?>
            </div>
            <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($user->name) ?></h4>
            <p class="text-muted mb-3"><?= htmlspecialchars($user->email) ?></p>
            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fs-6 border border-primary"><i class="fa-solid fa-user-shield me-2"></i><?= $user->role ?></span>
            
            <hr class="my-4" style="opacity: 0.1;">
            
            <div class="d-flex justify-content-center text-start">
                <div>
                    <div class="text-muted small fw-semibold">Member Since</div>
                    <div class="text-dark fw-bold"><?= date('d M Y', strtotime($user->created_at)) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Forms -->
    <div class="col-md-8">
        <!-- Personal Information -->
        <div class="card glass border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-dark mb-4"><i class="fa-regular fa-id-badge text-primary me-2"></i>Personal Information</h5>
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger py-2"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success py-2"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>

                <form action="<?= site_url('profile/update') ?>" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control bg-light border-0" value="<?= htmlspecialchars($user->name) ?>" required>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label text-muted fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control bg-light border-0" value="<?= htmlspecialchars($user->email) ?>" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security -->
        <div class="card glass border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-dark mb-4"><i class="fa-solid fa-shield-halved text-danger me-2"></i>Security</h5>
                
                <?php if($this->session->flashdata('error_security')): ?>
                    <div class="alert alert-danger py-2"><?= $this->session->flashdata('error_security') ?></div>
                <?php endif; ?>
                <?php if($this->session->flashdata('success_security')): ?>
                    <div class="alert alert-success py-2"><?= $this->session->flashdata('success_security') ?></div>
                <?php endif; ?>

                <form action="<?= site_url('profile/update_password') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Current Password</label>
                        <input type="password" name="current_password" class="form-control bg-light border-0" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold">New Password</label>
                            <input type="password" name="new_password" class="form-control bg-light border-0" minlength="6" required>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label text-muted fw-semibold">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control bg-light border-0" minlength="6" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-danger px-4">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
