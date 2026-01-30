<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Create User') ?></title>
    <?php
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', 'css', 'head', 5);
    assets()->css('css/base.css', 'head', 8);
    assets()->css('css/dashboard/dashboard-form.css', 'head', 10);
    assets()->js('js/theme.js', 'body_end', 10);
    ?>
    <script>(function(){var t=localStorage.getItem("theme");if(!t&&window.matchMedia("(prefers-color-scheme:dark)").matches)t="dark";if(t)document.documentElement.setAttribute("data-theme",t);})()</script>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Create New User</h1>
        </div>
    </div>

    <div class="container">
        <div class="form-card">
            <h2>User Information</h2>

            <form method="POST" action="<?= url('/dashboard/users') ?>">
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
                    <div class="info-text">Minimum 8 characters</div>
                    <?php if (isset($errors['password'])): ?>
                        <div class="error"><?= e($errors['password'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    <?php if (isset($errors['password_confirmation'])): ?>
                        <div class="error"><?= e($errors['password_confirmation'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Create User</button>
                    <a href="<?= url('/dashboard') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
