<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Edit User') ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-content {
            max-width: 800px;
            margin: 0 auto;
        }
        .header h1 {
            font-size: 1.5em;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        h2 {
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
            font-size: 0.9em;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.95em;
            transition: border-color 0.3s;
        }
        .info-text {
            font-size: 0.85em;
            color: #666;
            margin-top: 5px;
        }
        .section-divider {
            border-top: 2px solid #e9ecef;
            margin: 30px 0;
            padding-top: 20px;
        }
        .section-title {
            font-size: 1.1em;
            color: #495057;
            margin-bottom: 15px;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .error {
            color: #e74c3c;
            font-size: 0.85em;
            margin-top: 5px;
        }
        .btn-container {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
        .btn-primary:hover {
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
    </style>
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
