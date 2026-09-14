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

.stats {
    display: flex;
    gap: 16px;
    margin-bottom: 32px;
    flex-wrap: wrap;
}

.stat-card {
    background: #ffffff;
    border: 1px solid #e4e7eb;
    border-radius: 8px;
    padding: 20px 24px;
    min-width: 180px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}

.stat-card .label {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 6px;
}

.stat-card .value {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
}

.section {
    background: #ffffff;
    border: 1px solid #e4e7eb;
    border-radius: 8px;
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 12px;
}

.section-header h2 {
    margin-bottom: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    color: #6b7280;
    border-bottom: 1px solid #e4e7eb;
    padding: 10px 12px;
}

tbody td {
    padding: 10px 12px;
    border-bottom: 1px solid #f0f1f3;
    font-size: 14px;
    vertical-align: top;
}

tbody tr:last-child td {
    border-bottom: none;
}

.col-actions {
    white-space: nowrap;
    width: 1%;
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

.btn-sm {
    padding: 6px 12px;
    font-size: 13px;
}

.btn-secondary {
    background: #ffffff;
    color: #111827;
    border: 1px solid #d1d5db;
}

.btn-secondary:hover {
    background: #f4f5f7;
}

.btn-danger {
    background: #ffffff;
    color: #b91c1c;
    border: 1px solid #fecaca;
}

.btn-danger:hover {
    background: #fef2f2;
}

.action-form {
    display: inline-block;
    margin: 0 4px 0 0;
}

.row-actions {
    display: flex;
    gap: 8px;
}

.alert {
    padding: 12px 16px;
    border-radius: 6px;
    font-size: 14px;
    margin-bottom: 20px;
}

.alert-success {
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
}

.alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

.alert-error ul {
    margin: 0;
    padding-left: 18px;
}

.form-section {
    max-width: 520px;
}

.field {
    margin-bottom: 18px;
}

.field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #364152;
    margin-bottom: 6px;
}

.field input,
.field select,
.field textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    font-family: inherit;
    color: #1f2933;
}

.field textarea {
    min-height: 140px;
    resize: vertical;
}

.field .hint {
    margin-top: 6px;
    font-size: 12px;
    color: #6b7280;
}

.actions {
    display: flex;
    gap: 10px;
}
