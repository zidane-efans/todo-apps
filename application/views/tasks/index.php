<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 text-dark fw-bold">Tasks</h2>
        <p class="text-muted mb-0">List view of all tasks across your projects.</p>
    </div>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#createTaskModal"><i class="fa-solid fa-plus me-2"></i>New Task</button>
</div>

<div class="card border-0 shadow-sm glass">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-semibold border-bottom-0">Task Name</th>
                        <th class="py-3 text-muted fw-semibold border-bottom-0">Project</th>
                        <th class="py-3 text-muted fw-semibold border-bottom-0">Priority</th>
                        <th class="py-3 text-muted fw-semibold border-bottom-0">Status</th>
                        <th class="py-3 text-muted fw-semibold border-bottom-0">Deadline</th>
                        <th class="px-4 py-3 text-muted fw-semibold border-bottom-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tasks as $t): ?>
                    <tr>
                        <td class="px-4 py-3">
                            <div class="fw-bold text-dark"><?= $t->title ?></div>
                        </td>
                        <td class="py-3 text-muted"><?= $t->project_name ?></td>
                        <td class="py-3"><span class="badge badge-priority-<?= $t->priority ?> rounded-pill"><?= $t->priority ?></span></td>
                        <td class="py-3">
                            <?php 
                                $statusClass = 'secondary';
                                if($t->status == 'Completed') $statusClass = 'success';
                                if($t->status == 'In Progress') $statusClass = 'warning';
                                if($t->status == 'Review') $statusClass = 'info';
                            ?>
                            <span class="badge bg-<?= $statusClass ?> rounded-pill"><?= $t->status ?></span>
                        </td>
                        <td class="py-3 text-muted"><i class="fa-regular fa-clock me-1"></i> <?= date('M d, Y', strtotime($t->deadline)) ?></td>
                        <td class="px-4 py-3 text-end">
                            <a href="#" class="btn btn-sm btn-light rounded-circle text-primary me-1 edit-task-btn" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-id="<?= $t->id ?>" data-title="<?= htmlspecialchars($t->title) ?>" data-desc="<?= htmlspecialchars($t->description) ?>" data-project="<?= $t->project_id ?>" data-priority="<?= $t->priority ?>" data-status="<?= $t->status ?>" data-deadline="<?= $t->deadline ?>"><i class="fa-solid fa-pen"></i></a>
                            <a href="<?= site_url('tasks/delete/'.$t->id) ?>" class="btn btn-sm btn-light rounded-circle text-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Create New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('tasks/create') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Task Name</label>
                        <input type="text" name="title" class="form-control bg-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Description</label>
                        <textarea name="description" class="form-control bg-light border-0" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Project</label>
                            <select name="project_id" class="form-select bg-light border-0" required>
                                <?php foreach($projects as $p): ?>
                                    <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Priority</label>
                            <select name="priority" class="form-select bg-light border-0">
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Status</label>
                            <select name="status" class="form-select bg-light border-0">
                                <option value="To Do">To Do</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Review">Review</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Deadline</label>
                            <input type="date" name="deadline" class="form-control bg-light border-0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Task</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('tasks/update') ?>" method="POST">
                <input type="hidden" name="id" id="editTaskId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Task Name</label>
                        <input type="text" name="title" id="editTaskTitle" class="form-control bg-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Description</label>
                        <textarea name="description" id="editTaskDesc" class="form-control bg-light border-0" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Project</label>
                            <select name="project_id" id="editTaskProject" class="form-select bg-light border-0" required>
                                <?php foreach($projects as $p): ?>
                                    <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Priority</label>
                            <select name="priority" id="editTaskPriority" class="form-select bg-light border-0">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Status</label>
                            <select name="status" id="editTaskStatus" class="form-select bg-light border-0">
                                <option value="To Do">To Do</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Review">Review</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Deadline</label>
                            <input type="date" name="deadline" id="editTaskDeadline" class="form-control bg-light border-0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var editBtns = document.querySelectorAll('.edit-task-btn');
    editBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('editTaskId').value = this.getAttribute('data-id');
            document.getElementById('editTaskTitle').value = this.getAttribute('data-title');
            document.getElementById('editTaskDesc').value = this.getAttribute('data-desc');
            document.getElementById('editTaskProject').value = this.getAttribute('data-project');
            document.getElementById('editTaskPriority').value = this.getAttribute('data-priority');
            document.getElementById('editTaskStatus').value = this.getAttribute('data-status');
            
            var deadline = this.getAttribute('data-deadline');
            if (deadline) {
                var d = new Date(deadline);
                document.getElementById('editTaskDeadline').value = d.toISOString().split('T')[0];
            }
        });
    });
});
</script>
