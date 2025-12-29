<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institute Dashboard - SkillUp CIMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?= url('public/assets/css/custom.css') ?>">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <i class="fas fa-graduation-cap me-2"></i>
                SkillUp CIMS
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="<?= url('institute/dashboard') ?>" class="active">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= url('institute/students') ?>">
                        <i class="fas fa-user-graduate"></i> Students
                    </a>
                </li>
                <li>
                    <a href="<?= url('institute/fees') ?>">
                        <i class="fas fa-money-bill-wave"></i> Fees
                    </a>
                </li>
                <li>
                    <a href="<?= url('institute/exams') ?>">
                        <i class="fas fa-file-alt"></i> Exams
                    </a>
                </li>
                <li>
                    <a href="<?= url('institute/batches') ?>">
                        <i class="fas fa-clock"></i> Batches
                    </a>
                </li>
                <li>
                    <a href="<?= url('institute/teachers') ?>">
                        <i class="fas fa-chalkboard-teacher"></i> Teachers
                    </a>
                </li>
                <li>
                    <a href="<?= url('institute/attendance') ?>">
                        <i class="fas fa-calendar-check"></i> Attendance
                    </a>
                </li>
                <li>
                    <a href="<?= url('institute/profile') ?>">
                        <i class="fas fa-user-cog"></i> Profile
                    </a>
                </li>
                <li>
                    <a href="<?= url('logout') ?>">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Institute Portal</h1>
                <div>
                    <span class="me-3">
                        <i class="fas fa-user-circle me-2"></i>
                        <?= e(Session::userData('username')) ?>
                    </span>
                    <a href="<?= url('logout') ?>" class="btn btn-sm btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>

            <?php if ($success = getFlash('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= e($success) ?>
                </div>
            <?php endif; ?>

            <?php if ($error = getFlash('error')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <?= $content ?>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom JS -->
    <script src="<?= url('public/assets/js/main.js') ?>"></script>
</body>

</html>