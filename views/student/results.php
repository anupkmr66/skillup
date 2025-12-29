<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-chart-bar me-2"></i>My Exam Results
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($results)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-file-alt fa-4x mb-3 opacity-50"></i>
                <p>No exam results available yet</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Exam Name</th>
                            <th>Course</th>
                            <th>Total Marks</th>
                            <th>Obtained Marks</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $result): ?>
                            <tr>
                                <td><?= e($result['exam_name']) ?></td>
                                <td><?= e($result['course_name']) ?></td>
                                <td><?= e($result['total_marks']) ?></td>
                                <td><?= e($result['marks_obtained']) ?></td>
                                <td>
                                    <?php
                                    $percentage = ($result['marks_obtained'] / $result['total_marks']) * 100;
                                    $percentageClass = $percentage >= 75 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger');
                                    ?>
                                    <span class="badge badge-<?= $percentageClass ?>">
                                        <?= number_format($percentage, 2) ?>%
                                    </span>
                                </td>
                                <td>
                                    <strong><?= e($result['grade'] ?? '-') ?></strong>
                                </td>
                                <td>
                                    <?php
                                    $statusClass = $result['status'] === 'pass' ? 'success' : 'danger';
                                    ?>
                                    <span class="badge badge-<?= $statusClass ?>">
                                        <?= ucfirst($result['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Overall Performance -->
            <div class="mt-4">
                <h6 class="mb-3">Overall Performance</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Total Exams</h6>
                                <h4 class="mb-0"><?= count($results) ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Passed</h6>
                                <h4 class="mb-0 text-success">
                                    <?= count(array_filter($results, fn($r) => $r['status'] === 'pass')) ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Failed</h6>
                                <h4 class="mb-0 text-danger">
                                    <?= count(array_filter($results, fn($r) => $r['status'] === 'fail')) ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Avg. Percentage</h6>
                                <h4 class="mb-0 text-primary">
                                    <?php
                                    $totalPercentage = 0;
                                    foreach ($results as $result) {
                                        $totalPercentage += ($result['marks_obtained'] / $result['total_marks']) * 100;
                                    }
                                    $avgPercentage = count($results) > 0 ? $totalPercentage / count($results) : 0;
                                    echo number_format($avgPercentage, 2);
                                    ?>%
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>