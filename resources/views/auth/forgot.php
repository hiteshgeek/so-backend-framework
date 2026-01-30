<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= htmlspecialchars($title ?? 'Forgot Password') ?></title>
    <?php
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', 'css', 'head', 5);
    assets()->css('css/docs-base.css', 'head', 8);
    assets()->css('css/auth.css', 'head', 10);
    ?>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <p>Enter your email to receive a password reset link</p>

        <?php if (session('success')): ?>
            <div class="alert alert-success"><?= e(session('success')) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= url('/password/forgot') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?= e(old('email', '')) ?>" required autofocus>
                <?php if (isset($errors['email'])): ?>
                    <div class="error"><?= e($errors['email'][0]) ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn">Send Reset Link</button>
        </form>

        <div class="links">
            <a href="<?= url('/login') ?>">Back to Login</a>
        </div>
    </div>
</body>
</html>
