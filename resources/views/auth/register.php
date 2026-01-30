<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= htmlspecialchars($title ?? 'Register') ?></title>
    <?php assets()->css('css/auth.css', 'head', 10); ?>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="container">
        <h1>Create Account</h1>
        <p>Fill in your details to get started</p>

        <?php if (session('error')): ?>
            <div class="alert alert-error"><?= e(session('error')) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= url('/register') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?= e(old('name', '')) ?>" required autofocus>
                <?php if (isset($errors['name'])): ?>
                    <div class="error"><?= e($errors['name'][0]) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?= e(old('email', '')) ?>" required>
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

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn">Create Account</button>
        </form>

        <div class="links">
            Already have an account? <a href="<?= url('/login') ?>">Login here</a>
        </div>
    </div>
</body>
</html>
