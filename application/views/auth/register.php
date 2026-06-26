<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - TaskFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-illustration d-none d-lg-flex flex-column">
            <h1 class="display-4 fw-bold mb-4">Join TaskFlow</h1>
            <p class="fs-4 mb-5 text-center px-5">Start organizing your tasks and boosting your productivity today with our modern platform.</p>
            <div style="width:300px; height:300px; background: rgba(255,255,255,0.2); border-radius: 50%; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-rocket" style="font-size: 8rem;"></i>
            </div>
        </div>
        <div class="auth-form-container">
            <div class="auth-card glass">
                <h2 class="text-center mb-2 fw-bold text-dark">Create an Account</h2>
                <p class="text-center text-muted mb-4">Please fill in your details to sign up</p>
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>

                <form action="<?= site_url('auth/register') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-user"></i></span>
                            <input type="text" name="name" class="form-control bg-light border-start-0" placeholder="John Doe" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="john@example.com" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control bg-light border-start-0 border-end-0" placeholder="password" required minlength="6">
                            <span class="input-group-text bg-light border-start-0 cursor-pointer" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="fa-regular fa-eye" id="toggleIcon1"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control bg-light border-start-0 border-end-0" placeholder="confirm password" required minlength="6">
                            <span class="input-group-text bg-light border-start-0 cursor-pointer" onclick="togglePassword('confirm_password', 'toggleIcon2')">
                                <i class="fa-regular fa-eye" id="toggleIcon2"></i>
                            </span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2 fs-5">Sign Up</button>
                </form>
                
                <p class="text-center mt-4 text-muted">Already have an account? <a href="<?= site_url('auth') ?>" class="text-decoration-none fw-bold" style="color: var(--primary-color);">Login</a></p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
