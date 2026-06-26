<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 text-dark fw-bold">Projects</h2>
        <p class="text-muted mb-0">Manage and monitor all your active projects.</p>
    </div>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#createProjectModal"><i class="fa-solid fa-plus me-2"></i>New Project</button>
</div>

<div class="row g-4">
    <?php foreach($projects as $p): ?>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm glass h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-3">
                    <span class="badge bg-light text-primary rounded-pill px-3 py-2"><?= $p->status ?></span>
                    <div class="dropdown">
                        <a href="#" class="text-muted text-decoration-none" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                            <li><a class="dropdown-item" href="<?= site_url('projects/view/'.$p->id) ?>">View Details</a></li>
                            <li><a class="dropdown-item edit-project-btn" href="#" data-bs-toggle="modal" data-bs-target="#editProjectModal" data-id="<?= $p->id ?>" data-name="<?= htmlspecialchars($p->name) ?>" data-desc="<?= htmlspecialchars($p->description) ?>" data-status="<?= $p->status ?>" data-start="<?= $p->start_date ?>" data-end="<?= $p->end_date ?>">Edit</a></li>
                            <li><a class="dropdown-item text-danger" href="<?= site_url('projects/delete/'.$p->id) ?>">Delete</a></li>
                        </ul>
                    </div>
                </div>
                <a href="<?= site_url('projects/view/'.$p->id) ?>" class="text-decoration-none text-dark">
                    <h5 class="fw-bold mb-2 project-title"><?= $p->name ?></h5>
                </a>
                <p class="text-muted small mb-4" style="min-height: 40px;"><?= $p->description ?></p>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small text-muted fw-bold">Progress</span>
                        <span class="small text-dark fw-bold"><?= isset($p->progress) ? $p->progress : 0 ?>%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?= isset($p->progress) ? $p->progress : 0 ?>%;"></div>
                    </div>
                </div>
                
                <hr class="text-muted opacity-25">
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="d-flex">
                        <div class="user-avatar" style="width:30px;height:30px;font-size:12px;margin-right:-10px;border:2px solid white">A</div>
                        <div class="user-avatar" style="width:30px;height:30px;font-size:12px;background:var(--secondary-2);border:2px solid white">B</div>
                    </div>
                    <div class="text-muted small"><i class="fa-regular fa-calendar me-1"></i> Due <?= date('M d', strtotime($p->end_date)) ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Create Project Modal -->
<div class="modal fade" id="createProjectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Create New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('projects/create') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Project Name</label>
                        <input type="text" name="name" class="form-control bg-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Description</label>
                        <textarea name="description" class="form-control bg-light border-0" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Start Date</label>
                            <input type="date" name="start_date" class="form-control bg-light border-0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">End Date</label>
                            <input type="date" name="end_date" class="form-control bg-light border-0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Status</label>
                        <select name="status" class="form-select bg-light border-0">
                            <option value="Active">Active</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('projects/update') ?>" method="POST">
                <input type="hidden" name="id" id="editProjectId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Project Name</label>
                        <input type="text" name="name" id="editProjectName" class="form-control bg-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Description</label>
                        <textarea name="description" id="editProjectDesc" class="form-control bg-light border-0" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Start Date</label>
                            <input type="date" name="start_date" id="editProjectStart" class="form-control bg-light border-0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">End Date</label>
                            <input type="date" name="end_date" id="editProjectEnd" class="form-control bg-light border-0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Status</label>
                        <select name="status" id="editProjectStatus" class="form-select bg-light border-0">
                            <option value="Active">Active</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var editBtns = document.querySelectorAll('.edit-project-btn');
    editBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('editProjectId').value = this.getAttribute('data-id');
            document.getElementById('editProjectName').value = this.getAttribute('data-name');
            document.getElementById('editProjectDesc').value = this.getAttribute('data-desc');
            document.getElementById('editProjectStatus').value = this.getAttribute('data-status');
            
            var start = this.getAttribute('data-start');
            if (start) {
                var ds = new Date(start);
                document.getElementById('editProjectStart').value = ds.toISOString().split('T')[0];
            }
            
            var end = this.getAttribute('data-end');
            if (end) {
                var de = new Date(end);
                document.getElementById('editProjectEnd').value = de.toISOString().split('T')[0];
            }
        });
    });
});
</script>
