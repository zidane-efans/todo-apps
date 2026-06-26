<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - TaskFlow' : 'TaskFlow' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <?php $this->load->view('partials/sidebar'); ?>
        
        <div class="main-content">
            <?php $this->load->view('partials/navbar'); ?>
            
            <div class="content-body">
                <?php $this->load->view($view, $data); ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const baseUrl = '<?= site_url('/') ?>';
        
        // Sidebar Toggle Logic
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const body = document.body;
            let backdrop = document.createElement('div');
            backdrop.className = 'sidebar-backdrop';
            body.appendChild(backdrop);
            
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (window.innerWidth <= 768) {
                        sidebar.classList.add('sidebar-open');
                        backdrop.classList.add('show');
                    } else {
                        body.classList.toggle('sidebar-collapsed');
                    }
                });
                
                backdrop.addEventListener('click', function() {
                    sidebar.classList.remove('sidebar-open');
                    backdrop.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>
