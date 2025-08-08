import { editor } from "./editor.js";

export function generateNodeHTML(type, data) {
    let template = '';
    let inputs = 1, outputs = 1;

    switch (type) {
        case 'start': template = `<div class="node-type">Start</div>`; inputs = 0; break;
        case 'end': template = `<div class="node-type">End</div>`; outputs = 0; break;
        case 'process': template = `<div class="node-type">Process</div>`; break;
        case 'condition': template = `<div class="node-type"><strong>Condition</strong></div>`; inputs = 1; outputs = 2; break;
        default: template = `<div class="node-type">${type}</div>`; break;
    }

    let fieldsHtml = data.fields ? `<div class="conditions"><strong>Данные:</strong><ul>` : '';
    fieldsHtml += (data.fields || []).map(f => {
        if (f.type === 'password' && f.value) return `<div class="field"><strong>${f.label}:</strong> <span class="field-value">••••••••••••</span></div>`;
        if (f.type === 'image' && f.value) return `<div class="field"><strong>${f.label}:</strong> <img src="${f.value}" class="field-image"/></div>`;
        return `
        <div class="field"><strong>${f.label}:</strong><span class="field-value">${f.value || ''}</span></div>
        `;
    }).join('');
    let actionHtml = data.actions ? `<div class="conditions"><strong>Действие: </strong><ul>` : '';
    actionHtml += (data.actions || []).map(f => {
        return `<div class="field"><strong>${f.label}:</strong><span class="field-value">${f.value || ''}</span></div>`;
    }).join('');

    const conditionHtml = type === 'condition' && (data.conditions || []).length > 0
        ? `<div class="conditions"><strong>Условия:</strong><ul>${data.conditions.map(c => {
            let display = '';
            if (c.type === 'not_null') display = `${c.field} IS NOT NULL`;
            else if (c.type === 'is_type') display = `${c.field} IS ${c.value}`;
            else display = `${c.field} ${c.operator} ${c.value}`;
            return `<li class="condition-item">${display}</li>`;
        }).join('')}</ul></div>`
        : '';

    const html = `<div class="node-title">${data.title || type}</div>${template}<div class="node-content">${fieldsHtml}${conditionHtml}${actionHtml}</div>`;
    return { html, inputs, outputs };
}

export function updateNodeHtml(node, id) {
    if (!node.data) node.data = {};
    if (!node.data.title) node.data.title = node.name;
    if (!node.data.actions) node.data.actions;
    if (!node.data.fields) node.data.fields = [];
    if (!node.data.conditions && node.name === 'condition') node.data.conditions = [];
    if (!node.data.fields && node.name === 'fields') node.data.fields = [];

    const { html } = generateNodeHTML(node.name, node.data);

    const nodeEl = document.getElementById(`node-${id}`);
    if (nodeEl) {
        nodeEl.querySelector('.drawflow_content_node').innerHTML = html;

    }
    editor.updateNodeDataFromId(id, node.data);
}
