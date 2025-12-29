<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - SkillUp CIMS</title>
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

        .btn-primary:hover {
            background: #5a6fd1;
        }
    </style>
</head>

<body>
    <div class="card p-4">
        <div class="card-header">
            <h3 class="fw-bold text-primary"><i class="fas fa-key me-2"></i>Forgot Password</h3>
            <p class="text-muted small">Enter your email to reset your password</p>
        </div>
        <div class="card-body">
            <?php if ($error = getFlash('error')): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
            <?php endif; ?>
            <?php if ($success = getFlash('success')): ?>
                <div class="alert alert-success"><?= e($success) ?></div>
            <?php endif; ?>

            <form action="<?= url('forgot-password') ?>" method="POST">
                <?= CSRF::field() ?>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" required placeholder="name@example.com">
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
                    <a href="<?= url('login') ?>" class="btn btn-light">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>