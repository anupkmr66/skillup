<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-chart-bar me-2"></i>Reports & Analytics
        </h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h6>Total Students</h6>
                        <h3><?= $totalStudents ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                        <h6>Fees Collected</h6>
                        <h3><?= formatCurrency($totalCollected) ?></h3>
                        <small>Pending: <?= formatCurrency($totalPending) ?></small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                        <h6>Active Courses</h6>
                        <h3><?= $totalCourses ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-building fa-2x mb-2"></i>
                        <h6>Active Franchises</h6>
                        <h3><?= $totalFranchises ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="mb-3">Monthly Revenue Trend (Last 12 Months)</h6>
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="mb-3">Student Enrollment Status</h6>
                        <canvas id="enrollmentChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Table -->
        <h6 class="mb-3">Monthly Summary (Last 6 Months)</h6>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>New Students</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($monthlySummary)): ?>
                        <tr>
                            <td colspan="3" class="text-center">No data available</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($monthlySummary as $row): ?>
                            <tr>
                                <td><?= $row['display_month'] ?></td>
                                <td><?= $row['new_students'] ?></td>
                                <td><?= formatCurrency($row['revenue']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Revenue Chart Data
        const revenueData = <?= json_encode($revenueData) ?>;

        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueData.labels,
                    datasets: [{
                        label: 'Revenue',
                        data: revenueData.data,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return '₹' + value;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Enrollment Chart Data
        const enrollmentData = <?= json_encode($enrollmentData) ?>;

        const enrollmentCtx = document.getElementById('enrollmentChart');
        if (enrollmentCtx) {
            new Chart(enrollmentCtx, {
                type: 'doughnut',
                data: {
                    labels: enrollmentData.labels,
                    datasets: [{
                        data: enrollmentData.data,
                        backgroundColor: ['#10b981', '#6366f1', '#ef4444', '#f59e0b', '#8b5cf6'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    });
</script>
