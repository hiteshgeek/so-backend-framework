<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(config('app.name')) ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .container {
            text-align: center;
            background: white;
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
        }

        h1 {
            font-size: 3em;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        p {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .feature {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .feature-title {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }

        .feature-desc {
            font-size: 0.9em;
            color: #888;
        }

        .links {
            margin-top: 30px;
        }

        .links a {
            display: inline-block;
            margin: 0 10px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .links a:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .version {
            margin-top: 30px;
            color: #999;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 <?= htmlspecialchars(config('app.name')) ?></h1>
        <p>A production-ready PHP framework with modern features, security, and best practices built-in.</p>

        <div class="features">
            <div class="feature">
                <div class="feature-icon">🛣️</div>
                <div class="feature-title">Routing</div>
                <div class="feature-desc">Laravel-style routing</div>
            </div>
            <div class="feature">
                <div class="feature-icon">🔒</div>
                <div class="feature-title">Security</div>
                <div class="feature-desc">CSRF, XSS, SQL injection protection</div>
            </div>
            <div class="feature">
                <div class="feature-icon">🗄️</div>
                <div class="feature-title">Database</div>
                <div class="feature-desc">Query builder & ORM</div>
            </div>
            <div class="feature">
                <div class="feature-icon">🎯</div>
                <div class="feature-title">MVC</div>
                <div class="feature-desc">Clean architecture</div>
            </div>
        </div>

        <div class="links">
            <a href="/api/test">Test API</a>
            <a href="https://github.com">Documentation</a>
        </div>

        <div class="version">
            Version 1.0.0 | PHP <?= PHP_VERSION ?> | <?= php_sapi_name() ?>
        </div>
    </div>
</body>
</html>
