<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= htmlspecialchars($title ?? 'Register') ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
        }
        h1 {
            font-size: 1.8em;
            margin-bottom: 10px;
            color: #333;
        }
        p { color: #666; margin-bottom: 30px; font-size: 0.9em; }
        .form-group { margin-bottom: 20px; }
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
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .error {
            color: #e74c3c;
            font-size: 0.85em;
            margin-top: 5px;
        }
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }
        .alert-error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .links {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
        }
        .links a {
            color: #667eea;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
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
