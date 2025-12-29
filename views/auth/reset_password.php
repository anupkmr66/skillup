<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SkillUp CIMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .card-header {
            background: transparent;
            border-bottom: none;
            text-align: center;
            padding-top: 30px;
        }

        .btn-primary {
            background: #667eea;
            border: none;
        }
    </style>
</head>

<body>
    <div class="card p-4">
        <div class="card-header">
            <h3 class="fw-bold text-primary"><i class="fas fa-lock me-2"></i>Reset Password</h3>
            <p class="text-muted small">Enter your new password below</p>
        </div>
        <div class="card-body">
            <?php if ($error = getFlash('error')): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
            <?php endif; ?>

            <form action="<?= url('reset-password') ?>" method="POST">
                <?= CSRF::field() ?>
                <input type="hidden" name="token" value="<?= e($token) ?>">

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                        <input type="password" name="confirm_password" class="form-control" required minlength="6">
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
                    <a href="<?= url('login') ?>" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>