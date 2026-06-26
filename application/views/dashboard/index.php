<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 text-dark fw-bold">Dashboard</h2>
        <p class="text-muted mb-0">Welcome back, <?= explode(' ', $this->session->userdata('name'))[0] ?>!</p>
    </div>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#createTaskModal"><i class="fa-solid fa-plus me-2"></i>New Task</button>
</div>

<!-- Stats Cards -->
<div class="row mb-5 g-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-folder-open"></i></div>
            <div>
                <p class="text-muted mb-1 fs-6">Total Projects</p>
                <h3 class="mb-0 fw-bold"><?= isset($stats['total_projects']) ? $stats['total_projects'] : 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-list-check"></i></div>
            <div>
                <p class="text-muted mb-1 fs-6">Total Tasks</p>
                <h3 class="mb-0 fw-bold"><?= isset($stats['total']) ? $stats['total'] : 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-yellow"><i class="fa-solid fa-spinner"></i></div>
            <div>
                <p class="text-muted mb-1 fs-6">Pending Tasks</p>
                <h3 class="mb-0 fw-bold"><?= isset($stats['pending']) ? $stats['pending'] : 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fa-solid fa-check-double"></i></div>
            <div>
                <p class="text-muted mb-1 fs-6">Completed Tasks</p>
                <h3 class="mb-0 fw-bold"><?= isset($stats['completed']) ? $stats['completed'] : 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-wrap align-items-center gap-3 mb-4">
    <h4 class="mb-0 text-dark fw-bold me-2">Kanban Board</h4>
    <div class="d-flex flex-wrap gap-2">
        <select class="form-select form-select-sm w-auto shadow-sm border-0 bg-light fw-semibold" id="filterProject">
            <option value="">All Projects</option>
            <?php foreach($projects as $p): ?>
                <option value="<?= $p->id ?>"><?= $p->name ?></option>
            <?php endforeach; ?>
        </select>
        <select class="form-select form-select-sm w-auto shadow-sm border-0 bg-light fw-semibold" id="filterPriority">
            <option value="">All Priorities</option>
            <option value="High">High Priority</option>
            <option value="Medium">Medium Priority</option>
            <option value="Low">Low Priority</option>
        </select>
    </div>
</div>

<div class="kanban-board">
    <!-- To Do -->
    <div class="kanban-column glass">
        <div class="kanban-header">
            <span class="text-muted"><i class="fa-solid fa-circle text-secondary me-2"></i>To Do</span>
            <span class="badge bg-light text-dark rounded-pill shadow-sm">
                <?= count(array_filter($tasks, function($t) { return $t->status == 'To Do'; })) ?>
            </span>
        </div>
        <div class="kanban-tasks" id="kanban-todo" data-status="To Do">
            <?php foreach($tasks as $t): if($t->status == 'To Do'): ?>
                <div class="task-card" data-id="<?= $t->id ?>" data-project-id="<?= $t->project_id ?>" data-priority="<?= $t->priority ?>">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge badge-priority-<?= $t->priority ?> rounded-pill"><?= $t->priority ?></span>
                        <div class="dropdown">
                            <a href="#" class="text-muted text-decoration-none" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li><a class="dropdown-item edit-task-btn" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-id="<?= $t->id ?>" data-title="<?= htmlspecialchars($t->title) ?>" data-desc="<?= htmlspecialchars($t->description) ?>" data-project="<?= $t->project_id ?>" data-priority="<?= $t->priority ?>" data-status="<?= $t->status ?>" data-deadline="<?= $t->deadline ?>">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="<?= site_url('tasks/delete/'.$t->id) ?>">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-1"><?= $t->title ?></h6>
                    <p class="text-muted small mb-3 text-truncate"><?= $t->project_name ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="user-avatar" style="width:28px;height:28px;font-size:12px;">U</div>
                        <div class="text-muted small"><i class="fa-regular fa-clock me-1"></i> <?= date('M d', strtotime($t->deadline)) ?></div>
                    </div>
                </div>
            <?php endif; endforeach; ?>
        </div>
    </div>

    <!-- In Progress -->
    <div class="kanban-column glass">
        <div class="kanban-header">
            <span class="text-muted"><i class="fa-solid fa-circle text-warning me-2"></i>In Progress</span>
            <span class="badge bg-light text-dark rounded-pill shadow-sm">
                <?= count(array_filter($tasks, function($t) { return $t->status == 'In Progress'; })) ?>
            </span>
        </div>
        <div class="kanban-tasks" id="kanban-inprogress" data-status="In Progress">
            <?php foreach($tasks as $t): if($t->status == 'In Progress'): ?>
                <div class="task-card" data-id="<?= $t->id ?>" data-project-id="<?= $t->project_id ?>" data-priority="<?= $t->priority ?>" style="border-left-color: var(--secondary-4);">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge badge-priority-<?= $t->priority ?> rounded-pill"><?= $t->priority ?></span>
                        <div class="dropdown">
                            <a href="#" class="text-muted text-decoration-none" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li><a class="dropdown-item edit-task-btn" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-id="<?= $t->id ?>" data-title="<?= htmlspecialchars($t->title) ?>" data-desc="<?= htmlspecialchars($t->description) ?>" data-project="<?= $t->project_id ?>" data-priority="<?= $t->priority ?>" data-status="<?= $t->status ?>" data-deadline="<?= $t->deadline ?>">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="<?= site_url('tasks/delete/'.$t->id) ?>">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-1"><?= $t->title ?></h6>
                    <p class="text-muted small mb-3 text-truncate"><?= $t->project_name ?></p>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $t->progress ?>%;"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="user-avatar" style="width:28px;height:28px;font-size:12px;background:var(--secondary-2)">U</div>
                        <div class="text-muted small"><i class="fa-regular fa-clock me-1"></i> <?= date('M d', strtotime($t->deadline)) ?></div>
                    </div>
                </div>
            <?php endif; endforeach; ?>
        </div>
    </div>

    <!-- Review -->
    <div class="kanban-column glass">
        <div class="kanban-header">
            <span class="text-muted"><i class="fa-solid fa-circle text-info me-2"></i>Review</span>
            <span class="badge bg-light text-dark rounded-pill shadow-sm">
                <?= count(array_filter($tasks, function($t) { return $t->status == 'Review'; })) ?>
            </span>
        </div>
        <div class="kanban-tasks" id="kanban-review" data-status="Review">
            <?php foreach($tasks as $t): if($t->status == 'Review'): ?>
                <div class="task-card" data-id="<?= $t->id ?>" data-project-id="<?= $t->project_id ?>" data-priority="<?= $t->priority ?>" style="border-left-color: var(--secondary-2);">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge badge-priority-<?= $t->priority ?> rounded-pill"><?= $t->priority ?></span>
                        <div class="dropdown">
                            <a href="#" class="text-muted text-decoration-none" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li><a class="dropdown-item edit-task-btn" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-id="<?= $t->id ?>" data-title="<?= htmlspecialchars($t->title) ?>" data-desc="<?= htmlspecialchars($t->description) ?>" data-project="<?= $t->project_id ?>" data-priority="<?= $t->priority ?>" data-status="<?= $t->status ?>" data-deadline="<?= $t->deadline ?>">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="<?= site_url('tasks/delete/'.$t->id) ?>">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-1"><?= $t->title ?></h6>
                    <p class="text-muted small mb-3 text-truncate"><?= $t->project_name ?></p>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%;"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="user-avatar" style="width:28px;height:28px;font-size:12px;background:var(--secondary-3)">U</div>
                        <div class="text-muted small"><i class="fa-regular fa-clock me-1"></i> <?= date('M d', strtotime($t->deadline)) ?></div>
                    </div>
                </div>
            <?php endif; endforeach; ?>
        </div>
    </div>

    <!-- Completed -->
    <div class="kanban-column glass">
        <div class="kanban-header">
            <span class="text-muted"><i class="fa-solid fa-circle text-success me-2"></i>Completed</span>
            <span class="badge bg-light text-dark rounded-pill shadow-sm">
                <?= count(array_filter($tasks, function($t) { return $t->status == 'Completed'; })) ?>
            </span>
        </div>
        <div class="kanban-tasks" id="kanban-completed" data-status="Completed">
            <?php foreach($tasks as $t): if($t->status == 'Completed'): ?>
                <div class="task-card" data-id="<?= $t->id ?>" data-project-id="<?= $t->project_id ?>" data-priority="<?= $t->priority ?>" style="border-left-color: var(--secondary-3); opacity: 0.8;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge badge-priority-<?= $t->priority ?> rounded-pill"><?= $t->priority ?></span>
                        <div class="dropdown">
                            <a href="#" class="text-muted text-decoration-none" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li><a class="dropdown-item edit-task-btn" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-id="<?= $t->id ?>" data-title="<?= htmlspecialchars($t->title) ?>" data-desc="<?= htmlspecialchars($t->description) ?>" data-project="<?= $t->project_id ?>" data-priority="<?= $t->priority ?>" data-status="<?= $t->status ?>" data-deadline="<?= $t->deadline ?>">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="<?= site_url('tasks/delete/'.$t->id) ?>">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-1 text-decoration-line-through"><?= $t->title ?></h6>
                    <p class="text-muted small mb-3 text-truncate"><?= $t->project_name ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="user-avatar" style="width:28px;height:28px;font-size:12px;background:var(--secondary-5)">U</div>
                        <div class="text-success small fw-bold"><i class="fa-solid fa-check-double me-1"></i> Done</div>
                    </div>
                </div>
            <?php endif; endforeach; ?>
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
                                <?php if(isset($projects)): foreach($projects as $p): ?>
                                    <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                <?php endforeach; endif; ?>
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
                                <?php if(isset($projects)): foreach($projects as $p): ?>
                                    <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                <?php endforeach; endif; ?>
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
    var columns = document.querySelectorAll('.kanban-tasks');
    
    // Sortable JS Init
    columns.forEach(function(col) {
        new Sortable(col, {
            group: 'kanban',
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: function (evt) {
                var itemEl = evt.item; 
                var newStatus = evt.to.getAttribute('data-status');
                var oldStatus = evt.from.getAttribute('data-status');
                var taskId = itemEl.getAttribute('data-id');

                if (newStatus !== oldStatus) {
                    // Update Badge Counts dynamically
                    var fromBadge = evt.from.parentElement.querySelector('.badge.bg-light');
                    var toBadge = evt.to.parentElement.querySelector('.badge.bg-light');
                    if(fromBadge) fromBadge.innerText = parseInt(fromBadge.innerText) - 1;
                    if(toBadge) toBadge.innerText = parseInt(toBadge.innerText) + 1;

                    // Update Style based on new column
                    itemEl.style.borderLeftColor = ''; // reset
                    itemEl.style.opacity = '1';
                    var titleEl = itemEl.querySelector('h6');
                    if (titleEl) titleEl.classList.remove('text-decoration-line-through');

                    if (newStatus === 'In Progress') {
                        itemEl.style.borderLeftColor = 'var(--secondary-4)';
                    } else if (newStatus === 'Review') {
                        itemEl.style.borderLeftColor = 'var(--secondary-2)';
                    } else if (newStatus === 'Completed') {
                        itemEl.style.borderLeftColor = 'var(--secondary-3)';
                        itemEl.style.opacity = '0.8';
                        if (titleEl) titleEl.classList.add('text-decoration-line-through');
                    }

                    // Perform AJAX call to update status
                    var formData = new FormData();
                    formData.append('id', taskId);
                    formData.append('status', newStatus);

                    fetch(baseUrl + 'tasks/update_status', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            console.log('Status updated successfully');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            },
        });
    });

    // Edit Modal Data Population
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
    // Filter Logic
    var filterProject = document.getElementById('filterProject');
    var filterPriority = document.getElementById('filterPriority');

    function applyFilters() {
        var projectId = filterProject.value;
        var priority = filterPriority.value;
        var cards = document.querySelectorAll('.task-card');
        
        cards.forEach(function(card) {
            var cardProject = card.getAttribute('data-project-id');
            var cardPriority = card.getAttribute('data-priority');
            
            var matchProject = (projectId === '' || projectId === cardProject);
            var matchPriority = (priority === '' || priority === cardPriority);
            
            if (matchProject && matchPriority) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update Column Counts based on visible cards
        var columnsArray = document.querySelectorAll('.kanban-column');
        columnsArray.forEach(function(col) {
            var badge = col.querySelector('.kanban-header .badge');
            var visibleCards = col.querySelectorAll('.task-card[style*="display: block"], .task-card:not([style*="display: none"])');
            if (badge) {
                badge.innerText = visibleCards.length;
            }
        });
    }

    if(filterProject) filterProject.addEventListener('change', applyFilters);
    if(filterPriority) filterPriority.addEventListener('change', applyFilters);
    
});
</script>
