<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route Tester - SO Framework Documentation</title>
    <?php
    // CDN dependencies (priority 5 = load first)
    assets()->cdn('https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css', 'css', 'head', 5);
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap', 'css', 'head', 5);

    // Syntax highlighting (Highlight.js for code blocks)
    assets()->cdn('https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/highlight.min.js', 'js', 'body_end', 5);

    // Shared base CSS (priority 8 = after CDN, before page-specific)
    assets()->css('css/base.css', 'head', 8);

    // Docs CSS for code blocks and shared styles (priority 9 = before route-tester.css)
    assets()->css('css/docs/docs.css', 'head', 9);

    // Route tester page CSS (priority 10 = after base and docs)
    assets()->css('css/tools/route-tester.css', 'head', 10);

    // Scripts
    assets()->js('js/docs/docs.js', 'body_end', 9); // Code copy + highlight init
    assets()->js('js/tools/route-tester.js', 'body_end', 10);
    assets()->js('js/theme.js', 'body_end', 11); // Theme toggle last
    ?>
    <script>(function(){var t=localStorage.getItem("theme");if(!t&&window.matchMedia("(prefers-color-scheme:dark)").matches)t="dark";if(t)document.documentElement.setAttribute("data-theme",t);})()</script>
    <?= render_assets('head') ?>
</head>

<body>

    <header class="docs-header">
        <div class="docs-header-inner">
            <h1>
                <span class="mdi mdi-api"></span>
                Route Tester
                <span class="subtitle">Interactive API Testing</span>
            </h1>
            <a href="/docs" class="docs-nav-link">
                <span class="mdi mdi-arrow-left"></span> Back to Docs
            </a>
        </div>
    </header>

    <div class="tabs-wrapper">
        <div class="tabs-header">
            <button class="tab-button active" data-tab="routes" onclick="switchMainTab('routes')">
                <span class="mdi mdi-routes"></span>
                Routes
            </button>
            <button class="tab-button" data-tab="apis" onclick="switchMainTab('apis')">
                <span class="mdi mdi-api"></span>
                APIs
            </button>
        </div>
    </div>

    <main class="docs-layout">

        <nav class="docs-sidebar" id="tocList">
        </nav>

        <!-- ROUTES TAB -->
        <article class="docs-content active" id="routes-content">
            <div class="page-title">
                <span class="mdi mdi-routes"></span>
                Demo Route Tester
            </div>
            <p class="page-subtitle">
                Click any route to send a request and view the response. Routes with POST, PUT, or PATCH methods
                open an editor for the request body. All 18 sections below demonstrate different features of the Router.
            </p>
            <div id="sections"></div>
        </article>

        <!-- APIS TAB -->
        <article class="docs-content" id="apis-content">
            <div class="page-title">
                <span class="mdi mdi-api"></span>
                API Demonstrations
            </div>
            <p class="page-subtitle">
                Interactive demos of authentication flows, CRUD operations, and error handling. Test real API endpoints
                and see how authentication, validation, and errors work in practice.
            </p>

            <!-- Auth status indicator -->
            <div class="auth-status" id="authStatus">
                <span class="mdi mdi-account-off"></span>
                <span id="authStatusText">Not authenticated</span>
                <button class="btn-clear-auth" id="clearAuthBtn" style="display:none" onclick="clearAuth()">
                    <span class="mdi mdi-logout"></span> Clear Auth
                </button>
            </div>

            <div id="api-sections"></div>
        </article>

    </main>

    <div class="response-wrap" id="resPanel">
        <div class="res-bar">
            <span class="api-method" id="resMethod"></span>
            <span class="res-url" id="resUrl"></span>
            <span class="res-status" id="resStatus"></span>
            <span class="res-time" id="resTime"></span>
            <button class="close-btn" onclick="closeRes()"><span class="mdi mdi-close"></span></button>
        </div>
        <div class="res-body">
            <pre id="resBody"></pre>
        </div>
    </div>

    <div class="modal-overlay" id="modal">
        <div class="modal">
            <div class="modal-head">
                <h3 id="modalTitle">Send Request</h3>
                <button class="close-btn" onclick="closeModal()" style="background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:20px;padding:4px"><span class="mdi mdi-close"></span></button>
            </div>
            <div class="modal-body">
                <label>URL</label>
                <input type="text" id="modalUrl">
                <label>Request Body (JSON)</label>
                <textarea id="modalBody">{}</textarea>
            </div>
            <div class="modal-foot">
                <button class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                <button class="btn btn-send" id="modalSend"><span class="mdi mdi-send" style="margin-right:4px"></span>Send</button>
            </div>
        </div>
    </div>

    <?= render_assets('body_end') ?>
</body>

</html>
