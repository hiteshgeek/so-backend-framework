<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Edit User') ?></title>
    <?php assets()->css('css/dashboard-form.css', 'head', 10); ?>
    <?= render_assets('head') ?>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Edit User</h1>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Edit User: <?= e($editUser->name) ?></h2>

            <form method="POST" action="<?= url('/dashboard/users/' . $editUser->id) ?>">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?= e(old('name', $editUser->name)) ?>" required autofocus>
                    <?php if (isset($errors['name'])): ?>
                        <div class="error"><?= e($errors['name'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?= e(old('email', $editUser->email)) ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <div class="error"><?= e($errors['email'][0]) ?></div>
                    <?php endif; ?>
                </div>

                <div class="section-divider">
                    <div class="section-title">Change Password (Optional)</div>
                    <div class="info-text" style="margin-bottom: 15px;">Leave blank to keep current password</div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password">
                        <div class="info-text">Minimum 8 characters</div>
                        <?php if (isset($errors['password'])): ?>
                            <div class="error"><?= e($errors['password'][0]) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation">
                        <?php if (isset($errors['password_confirmation'])): ?>
                            <div class="error"><?= e($errors['password_confirmation'][0]) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="<?= url('/dashboard') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
