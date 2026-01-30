<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= htmlspecialchars($title ?? 'Login') ?></title>
    <?php
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', 'css', 'head', 5);
    assets()->css('css/docs/docs-base.css', 'head', 8);
    assets()->css('css/auth/auth.css', 'head', 10);
    ?>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="container">
        <h1>Welcome Back</h1>
        <p>Login to access your account</p>

        <?php if (session('success')): ?>
            <div class="alert alert-success"><?= e(session('success')) ?></div>
        <?php endif; ?>

        <?php if (session('error')): ?>
            <div class="alert alert-error"><?= e(session('error')) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= url('/login') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?= e(old('email', '')) ?>" required autofocus>
                <?php if (isset($errors['email'])): ?>
                    <div class="error"><?= e($errors['email'][0]) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($errors['password'])): ?>
                    <div class="error"><?= e($errors['password'][0]) ?></div>
                <?php endif; ?>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember" value="1">
                <label for="remember">Remember me for 30 days</label>
            </div>

            <div class="forgot-link">
                <a href="<?= url('/password/forgot') ?>">Forgot password?</a>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="links">
            Don't have an account? <a href="<?= url('/register') ?>">Register here</a>
            <br><br>
            <a href="<?= url('/') ?>">← Back to Home</a> |
            <a href="<?= url('/docs') ?>">Documentation</a>
        </div>
    </div>
</body>
</html>
