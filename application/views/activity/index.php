<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 text-dark fw-bold">Activity Reports</h4>
            <p class="text-muted">A complete history of actions performed by users.</p>
        </div>
        <button class="btn btn-outline-primary shadow-sm" onclick="window.print()"><i class="fa-solid fa-print me-2"></i>Print Report</button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card glass border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 custom-table">
                        <thead class="bg-light text-muted" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            <tr>
                                <th class="ps-4 py-3 border-bottom-0">User</th>
                                <th class="py-3 border-bottom-0">Activity</th>
                                <th class="pe-4 py-3 border-bottom-0 text-end">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($activities)): ?>
                                <?php foreach($activities as $act): ?>
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-weight: bold;">
                                                    <?= strtoupper(substr($act->user_name ?? '?', 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <span class="d-block fw-bold text-dark"><?= htmlspecialchars($act->user_name ?? 'Unknown User') ?></span>
                                                    <span class="text-muted" style="font-size: 0.85rem;">ID: <?= $act->user_id ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 text-dark">
                                            <i class="fa-solid fa-bolt text-warning me-2"></i> <?= htmlspecialchars($act->activity) ?>
                                        </td>
                                        <td class="pe-4 py-3 text-end text-muted">
                                            <div class="fw-semibold"><?= date('d M Y', strtotime($act->created_at)) ?></div>
                                            <div style="font-size: 0.85rem;"><?= date('H:i', strtotime($act->created_at)) ?></div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="fa-regular fa-folder-open mb-3" style="font-size: 3rem;"></i>
                                        <h5>No activity logs found.</h5>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-table tbody tr {
        transition: background-color 0.2s ease;
    }
    .custom-table tbody tr:hover {
        background-color: rgba(108, 92, 231, 0.05) !important;
    }
    .custom-table td {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }
</style>
