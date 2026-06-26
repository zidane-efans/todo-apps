<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-0 text-dark fw-bold">Progress Analytics</h4>
        <p class="text-muted">A high-level overview of your projects and tasks.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card glass h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-muted fw-semibold">Total Tasks</div>
                <div class="stat-icon icon-blue"><i class="fa-solid fa-list-check"></i></div>
            </div>
            <h3 class="fw-bold mb-0 text-dark"><?= $task_stats['total'] ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card glass h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-muted fw-semibold">Tasks Completed</div>
                <div class="stat-icon icon-green"><i class="fa-solid fa-check-double"></i></div>
            </div>
            <h3 class="fw-bold mb-0 text-success"><?= $task_stats['completed'] ?></h3>
            <?php $percent = $task_stats['total'] > 0 ? round(($task_stats['completed'] / $task_stats['total']) * 100) : 0; ?>
            <div class="progress mt-3" style="height: 6px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percent ?>%;" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card glass h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-muted fw-semibold">Tasks Pending</div>
                <div class="stat-icon icon-yellow"><i class="fa-solid fa-clock-rotate-left"></i></div>
            </div>
            <h3 class="fw-bold mb-0 text-warning"><?= $task_stats['pending'] ?></h3>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Task Status Distribution -->
    <div class="col-md-5">
        <div class="card glass border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-dark mb-4">Task Status Distribution</h5>
                <div style="position: relative; height:300px; width:100%">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Priority Distribution -->
    <div class="col-md-3">
        <div class="card glass border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-dark mb-4">Tasks by Priority</h5>
                <div style="position: relative; height:300px; width:100%">
                    <canvas id="priorityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Progress -->
    <div class="col-md-4">
        <div class="card glass border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-dark mb-4">Project Completion (%)</h5>
                <div style="position: relative; height:300px; width:100%">
                    <canvas id="projectChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Shared Options
    Chart.defaults.font.family = "'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif";
    Chart.defaults.color = '#a0aec0';

    // 1. Status Doughnut Chart
    const statusData = <?= $chart_status ?>;
    if(document.getElementById('statusChart')) {
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: statusData.labels,
                datasets: [{
                    data: statusData.data,
                    backgroundColor: statusData.colors,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '75%'
            }
        });
    }

    // 2. Priority Pie Chart
    const priorityData = <?= $chart_priority ?>;
    if(document.getElementById('priorityChart')) {
        new Chart(document.getElementById('priorityChart'), {
            type: 'pie',
            data: {
                labels: priorityData.labels,
                datasets: [{
                    data: priorityData.data,
                    backgroundColor: priorityData.colors,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    // 3. Project Bar Chart
    const projectData = <?= $chart_projects ?>;
    if(document.getElementById('projectChart')) {
        new Chart(document.getElementById('projectChart'), {
            type: 'bar',
            data: {
                labels: projectData.labels,
                datasets: [{
                    label: 'Completion %',
                    data: projectData.data,
                    backgroundColor: 'rgba(108, 92, 231, 0.7)',
                    borderColor: '#6c5ce7',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { borderDash: [5, 5] }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
});
</script>
