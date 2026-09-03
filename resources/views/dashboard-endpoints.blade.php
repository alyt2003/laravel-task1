<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API Endpoints - Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f5f7;
            color: #1f2933;
            padding: 32px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 24px;
        }

        h2 {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 12px;
            color: #364152;
        }

        .section {
            background: #ffffff;
            border: 1px solid #e4e7eb;
            border-radius: 8px;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        .empty {
            padding: 16px 12px;
            color: #6b7280;
            font-size: 14px;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
        }

        .page-header h1 {
            margin-bottom: 0;
        }

        .btn {
            display: inline-block;
            background: #111827;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 18px;
            border-radius: 6px;
            border: 1px solid #111827;
            cursor: pointer;
        }

        .btn:hover {
            background: #1f2933;
        }

        .btn-secondary {
            background: #ffffff;
            color: #111827;
        }

        .btn-secondary:hover {
            background: #f4f5f7;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: default;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 16px;
            font-size: 14px;
            color: #364152;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .hint {
            font-size: 13px;
            color: #6b7280;
            margin: -8px 0 20px;
        }

        .endpoint-card {
            border: 1px solid #e4e7eb;
            border-radius: 8px;
            margin-bottom: 12px;
            overflow: hidden;
        }

        .endpoint-card:last-child {
            margin-bottom: 0;
        }

        .endpoint-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding: 14px 16px;
            background: #ffffff;
        }

        .method-badge {
            display: inline-block;
            min-width: 58px;
            text-align: center;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.03em;
            padding: 4px 8px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .method-GET { background: #e6f4ff; color: #0b5cab; }
        .method-POST { background: #e6f6ec; color: #0a7a3f; }
        .method-PUT { background: #fff4e0; color: #a15c00; }
        .method-PATCH { background: #fff4e0; color: #a15c00; }
        .method-DELETE { background: #fde8e8; color: #b42318; }

        .endpoint-uri {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .endpoint-desc {
            flex: 1 1 260px;
            font-size: 13px;
            color: #6b7280;
        }

        .auth-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .auth-required {
            background: #fde8e8;
            color: #b42318;
        }

        .auth-public {
            background: #eef2f6;
            color: #4b5563;
        }

        .try-toggle {
            font-size: 13px;
            padding: 6px 14px;
        }

        .try-panel {
            display: none;
            border-top: 1px solid #e4e7eb;
            background: #f9fafb;
            padding: 16px;
        }

        .try-panel.open {
            display: block;
        }

        .field-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }

        .field-grid label {
            display: block;
            font-size: 12px;
            color: #4b5563;
            margin-bottom: 4px;
        }

        .field-grid input {
            width: 100%;
            font-size: 13px;
            padding: 7px 9px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-family: inherit;
        }

        .field-grid input:focus {
            outline: 2px solid #93c5fd;
            outline-offset: 0;
        }

        .required-mark {
            color: #b42318;
        }

        .try-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .status-pill {
            font-size: 12px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 999px;
        }

        .status-2xx { background: #e6f6ec; color: #0a7a3f; }
        .status-4xx { background: #fff4e0; color: #a15c00; }
        .status-5xx { background: #fde8e8; color: #b42318; }
        .status-err { background: #eef2f6; color: #4b5563; }

        .result-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media (max-width: 720px) {
            .result-grid {
                grid-template-columns: 1fr;
            }
        }

        .result-block h3 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #6b7280;
            margin: 0 0 6px;
        }

        pre {
            background: #111827;
            color: #e5e7eb;
            font-size: 12px;
            line-height: 1.5;
            padding: 12px;
            border-radius: 6px;
            overflow-x: auto;
            white-space: pre-wrap;
            word-break: break-word;
            margin: 0;
            min-height: 42px;
        }
    </style>
</head>
<body>
    <a class="back-link" href="{{ url('/dashboard') }}">&larr; Back to Dashboard</a>

    <div class="page-header">
        <h1>API Endpoints</h1>
    </div>

    <div class="section">
        <h2>Registered endpoints ({{ $endpoints->count() }})</h2>
        <p class="hint">
            These are read directly from <code>routes/api.php</code>. Endpoints marked "Auth required" need a Sanctum bearer
            token &mdash; use <strong>POST /api/login</strong> first, the token is then reused automatically for the other panels below.
        </p>

        @if ($endpoints->isEmpty())
            <p class="empty">No API endpoints found.</p>
        @else
            @foreach ($endpoints as $index => $endpoint)
                <div class="endpoint-card" data-endpoint-index="{{ $index }}">
                    <div class="endpoint-row">
                        @foreach ($endpoint['methods'] as $method)
                            <span class="method-badge method-{{ $method }}">{{ $method }}</span>
                        @endforeach
                        <span class="endpoint-uri">{{ $endpoint['uri'] }}</span>
                        <span class="endpoint-desc">{{ $endpoint['description'] }}</span>
                        <span class="auth-badge {{ $endpoint['auth'] ? 'auth-required' : 'auth-public' }}">
                            {{ $endpoint['auth'] ? 'Auth required' : 'Public' }}
                        </span>
                        <button type="button" class="btn btn-secondary try-toggle" data-toggle="{{ $index }}">Try / Test</button>
                    </div>

                    <div class="try-panel" id="try-panel-{{ $index }}">
                        <div class="field-grid">
                            @foreach ($endpoint['route_params'] as $param)
                                <div>
                                    <label for="param-{{ $index }}-{{ $param }}">
                                        URL param: {{ $param }} <span class="required-mark">*</span>
                                    </label>
                                    <input type="text" id="param-{{ $index }}-{{ $param }}" data-kind="param" data-field="{{ $param }}" placeholder="e.g. 1">
                                </div>
                            @endforeach

                            @if ($endpoint['auth'])
                                <div>
                                    <label for="token-{{ $index }}">Bearer token <span class="required-mark">*</span></label>
                                    <input type="text" id="token-{{ $index }}" data-kind="token" placeholder="paste token from /api/login">
                                </div>
                            @endif

                            @foreach ($endpoint['body'] as $field)
                                <div>
                                    <label for="body-{{ $index }}-{{ $field['name'] }}">
                                        {{ $field['name'] }} ({{ $field['type'] }}){{ $field['required'] ? ' ' : '' }}
                                        @if ($field['required'])<span class="required-mark">*</span>@endif
                                    </label>
                                    <input type="text" id="body-{{ $index }}-{{ $field['name'] }}" data-kind="body" data-field="{{ $field['name'] }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="try-actions">
                            <button type="button" class="btn send-btn" data-send="{{ $index }}">Send request</button>
                            <span class="status-pill status-err" id="status-{{ $index }}" style="display:none;"></span>
                        </div>

                        <div class="result-grid">
                            <div class="result-block">
                                <h3>Request</h3>
                                <pre id="request-{{ $index }}"></pre>
                            </div>
                            <div class="result-block">
                                <h3>Response</h3>
                                <pre id="response-{{ $index }}"></pre>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        const endpoints = @json($endpoints);
        const TOKEN_KEY = 'dashboardApiTestToken';

        function fillStoredToken() {
            const stored = localStorage.getItem(TOKEN_KEY);
            if (!stored) return;
            document.querySelectorAll('input[data-kind="token"]').forEach((el) => {
                if (!el.value) el.value = stored;
            });
        }

        document.querySelectorAll('.try-toggle').forEach((btn) => {
            btn.addEventListener('click', () => {
                const idx = btn.getAttribute('data-toggle');
                const panel = document.getElementById('try-panel-' + idx);
                panel.classList.toggle('open');
                if (panel.classList.contains('open')) fillStoredToken();
            });
        });

        document.querySelectorAll('.send-btn').forEach((btn) => {
            btn.addEventListener('click', async () => {
                const idx = parseInt(btn.getAttribute('data-send'), 10);
                const endpoint = endpoints[idx];
                const card = document.querySelector('[data-endpoint-index="' + idx + '"]');

                let uri = endpoint.uri;
                let missingParam = null;
                card.querySelectorAll('input[data-kind="param"]').forEach((input) => {
                    const field = input.getAttribute('data-field');
                    if (!input.value) missingParam = field;
                    uri = uri.replace('{' + field + '}', encodeURIComponent(input.value));
                });

                const bodyPayload = {};
                let missingBody = null;
                card.querySelectorAll('input[data-kind="body"]').forEach((input) => {
                    const field = input.getAttribute('data-field');
                    if (input.value !== '') bodyPayload[field] = input.value;
                });
                endpoint.body.forEach((f) => {
                    if (f.required && (bodyPayload[f.name] === undefined || bodyPayload[f.name] === '')) {
                        missingBody = f.name;
                    }
                });

                const tokenInput = card.querySelector('input[data-kind="token"]');
                const token = tokenInput ? tokenInput.value.trim() : '';

                const requestEl = document.getElementById('request-' + idx);
                const responseEl = document.getElementById('response-' + idx);
                const statusEl = document.getElementById('status-' + idx);
                const method = endpoint.methods[0];

                if (missingParam) {
                    requestEl.textContent = '';
                    responseEl.textContent = 'Please fill in URL param: ' + missingParam;
                    statusEl.style.display = 'inline-block';
                    statusEl.className = 'status-pill status-err';
                    statusEl.textContent = 'Not sent';
                    return;
                }
                if (missingBody) {
                    requestEl.textContent = '';
                    responseEl.textContent = 'Please fill in required field: ' + missingBody;
                    statusEl.style.display = 'inline-block';
                    statusEl.className = 'status-pill status-err';
                    statusEl.textContent = 'Not sent';
                    return;
                }
                if (endpoint.auth && !token) {
                    requestEl.textContent = '';
                    responseEl.textContent = 'This endpoint requires a bearer token. Get one from POST /api/login first.';
                    statusEl.style.display = 'inline-block';
                    statusEl.className = 'status-pill status-err';
                    statusEl.textContent = 'Not sent';
                    return;
                }

                const headers = { 'Accept': 'application/json' };
                if (endpoint.body.length > 0) headers['Content-Type'] = 'application/json';
                if (token) headers['Authorization'] = 'Bearer ' + token;

                const fetchOptions = { method, headers };
                if (endpoint.body.length > 0) fetchOptions.body = JSON.stringify(bodyPayload);

                requestEl.textContent = JSON.stringify({
                    method,
                    url: uri,
                    headers,
                    body: endpoint.body.length > 0 ? bodyPayload : undefined,
                }, null, 2);

                btn.disabled = true;
                btn.textContent = 'Sending...';
                statusEl.style.display = 'none';
                responseEl.textContent = '';

                try {
                    const res = await fetch(uri, fetchOptions);
                    const contentType = res.headers.get('content-type') || '';
                    let data;
                    if (contentType.includes('application/json')) {
                        data = await res.json();
                    } else {
                        data = await res.text();
                    }

                    responseEl.textContent = typeof data === 'string' ? data : JSON.stringify(data, null, 2);

                    statusEl.style.display = 'inline-block';
                    statusEl.textContent = res.status + ' ' + res.statusText;
                    statusEl.className = 'status-pill ' + (res.status < 300 ? 'status-2xx' : res.status < 500 ? 'status-4xx' : 'status-5xx');

                    // Convenience: auto-capture the token after a successful login so
                    // it can be reused in other "Auth required" panels automatically.
                    if (res.ok && data && typeof data === 'object' && data.token) {
                        localStorage.setItem(TOKEN_KEY, data.token);
                        fillStoredToken();
                    }
                } catch (err) {
                    responseEl.textContent = 'Request failed: ' + err.message;
                    statusEl.style.display = 'inline-block';
                    statusEl.className = 'status-pill status-err';
                    statusEl.textContent = 'Network error';
                } finally {
                    btn.disabled = false;
                    btn.textContent = 'Send request';
                }
            });
        });
    </script>
</body>
</html>
