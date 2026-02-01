<!-- Flow Diagram Component -->
<style>
.flow-diagram {
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 32px 24px;
    margin: 24px 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.flow-diagram-title {
    font-size: 14px;
    font-weight: 700;
    color: #2d3748;
    text-align: center;
    margin-bottom: 24px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.flow-actors {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.flow-actor {
    background: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    color: #2d3748;
    border: 2px solid #4299e1;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.flow-steps {
    position: relative;
    padding: 20px 0;
}

.flow-step {
    display: flex;
    align-items: center;
    margin-bottom: 16px;
    position: relative;
}

.flow-step:last-child {
    margin-bottom: 0;
}

.flow-arrow {
    flex: 1;
    height: 2px;
    background: #4299e1;
    position: relative;
    margin: 0 12px;
}

.flow-arrow::after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 8px solid #4299e1;
    border-top: 6px solid transparent;
    border-bottom: 6px solid transparent;
}

.flow-arrow.reverse {
    background: #48bb78;
}

.flow-arrow.reverse::after {
    left: 0;
    right: auto;
    border-left: none;
    border-right: 8px solid #48bb78;
    border-top: 6px solid transparent;
    border-bottom: 6px solid transparent;
}

.flow-arrow.error {
    background: #f56565;
}

.flow-arrow.error::after {
    border-right-color: #f56565;
}

.flow-label {
    background: white;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    color: #2d3748;
    border: 1px solid #cbd5e0;
    min-width: 200px;
    text-align: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.flow-label.request {
    border-left: 3px solid #4299e1;
}

.flow-label.response {
    border-left: 3px solid #48bb78;
}

.flow-label.error {
    border-left: 3px solid #f56565;
    background: #fff5f5;
}

.flow-note {
    flex: 0 0 200px;
    font-size: 12px;
    color: #718096;
    font-style: italic;
    padding: 0 8px;
}

.flow-spacer {
    height: 8px;
}

@media (max-width: 768px) {
    .flow-step {
        flex-direction: column;
        align-items: stretch;
    }

    .flow-arrow {
        height: 20px;
        width: 2px;
        margin: 8px auto;
    }

    .flow-arrow::after {
        top: auto;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%) rotate(90deg);
    }

    .flow-arrow.reverse::after {
        top: 0;
        bottom: auto;
        transform: translateX(-50%) rotate(90deg);
    }

    .flow-note {
        flex: 1;
        text-align: center;
        margin-top: 8px;
    }
}
</style>

<div class="flow-diagram">
    <div class="flow-diagram-title">Form Submission Flow</div>

    <div class="flow-actors">
        <div class="flow-actor">🌐 Browser</div>
        <div class="flow-actor">⚙️ Server</div>
    </div>

    <div class="flow-steps">
        <!-- Step 1: Initial GET request -->
        <div class="flow-step">
            <div class="flow-label request">GET /register</div>
            <div class="flow-arrow"></div>
            <div class="flow-note"></div>
        </div>

        <!-- Step 2: Server processes and returns form -->
        <div class="flow-step">
            <div class="flow-note"></div>
            <div class="flow-arrow reverse"></div>
            <div class="flow-label response">&lt;form&gt; with CSRF token</div>
        </div>

        <div class="flow-spacer"></div>

        <!-- Step 3: User submits form -->
        <div class="flow-step">
            <div class="flow-label request">POST /register<br><small>_token + form fields</small></div>
            <div class="flow-arrow"></div>
            <div class="flow-note">CsrfMiddleware checks token<br>Validator::make() validates</div>
        </div>

        <div class="flow-spacer"></div>

        <!-- Step 4: Validation fails -->
        <div class="flow-step">
            <div class="flow-note"></div>
            <div class="flow-arrow reverse error"></div>
            <div class="flow-label error">Validation failed<br><small>withErrors() + withInput()</small></div>
        </div>

        <!-- Step 5: Re-render form with errors -->
        <div class="flow-step">
            <div class="flow-note"></div>
            <div class="flow-arrow reverse error"></div>
            <div class="flow-label error">Re-render form with errors</div>
        </div>

        <div class="flow-spacer"></div>

        <!-- Step 6: User corrects and resubmits -->
        <div class="flow-step">
            <div class="flow-label request">POST /register (corrected)</div>
            <div class="flow-arrow"></div>
            <div class="flow-note">Validation passes ✓</div>
        </div>

        <!-- Step 7: Success redirect -->
        <div class="flow-step">
            <div class="flow-note"></div>
            <div class="flow-arrow reverse"></div>
            <div class="flow-label response">Redirect to dashboard</div>
        </div>
    </div>
</div>
