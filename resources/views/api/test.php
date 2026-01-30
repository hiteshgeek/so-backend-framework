<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route Tester - SO Framework Documentation</title>
    <?php
    assets()->cdn('https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css', 'css', 'head', 5);
    assets()->cdn('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap', 'css', 'head', 5);
    assets()->css('css/tools/route-tester.css', 'head', 10);
    assets()->js('js/tools/route-tester.js', 'body_end', 10);
    ?>
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

    <main class="docs-layout">

        <nav class="docs-sidebar">
            <h3><span class="mdi mdi-format-list-bulleted"></span> Sections</h3>
            <ul id="tocList"></ul>
        </nav>

        <article class="docs-content">
            <div class="page-title">
                <span class="mdi mdi-routes"></span>
                Demo Route Tester
            </div>
            <p class="page-subtitle">
                Click any route to send a request and view the response. Routes with POST, PUT, or PATCH methods
                open an editor for the request body. All 13 sections below demonstrate different features of the Router.
            </p>
            <div id="sections"></div>
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
