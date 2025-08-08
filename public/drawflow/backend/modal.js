import { editor, updateNodeHtml, addNode } from "./editor.js";


const modal = document.getElementById("node-modal");
const modalBody = document.getElementById("modal-body");

export function showModalForNode(node, id) {
    if (node.name === 'condition') {
        showConditionModal(node, id);
    } else if (node.name === 'start') {
        showGeneralModal(node, id);
    } else if (node.name === 'process') {
        showProcessModal(node, id);
    }
    modal.style.display = "block";
}

function showConditionModal(node, id) {
    const inputNodes = editor.drawflow.drawflow.Home.data[id]?.inputs?.input_1?.connections || [];
    const availableFields = [];
    inputNodes.forEach(conn => {
        const inputNode = editor.getNodeFromId(parseInt(conn.node));
        if (inputNode && inputNode.data) {
            if (inputNode.data.fields) {
                inputNode.data.fields.forEach(content => {
                    availableFields.push({title: inputNode.data.title , label: content.label, type: content.type, value: content.value, nodeId: conn.node, source: 'Node(fields)' });

                });
            }
            // if (inputNode.data.fields) {
            //     inputNode.data.fields.forEach(field => {
            //         availableFields.push({ label: field.label, nodeId: conn.node, source: 'Input' });
            //     });
            // }
        }
    });

    // [inputNodes, outputTrueNodes, outputFalseNodes].forEach((connList) => {

    //     connList.forEach(conn => {
    //         const n = editor.getNodeFromId(parseInt(conn.node));
    //         if (!n || !n.data) return;
    //         if (n.data.fields) n.data.fields.forEach(f => {
    //             if (f.type) {
    //                 availableFields.push({ title: n.data.title, label: f.label, value: f.value, nodeId: conn.node, source: "Поле" });
    //             }
    //             if (n.data.title) availableFields.push({ title: n.data.title, label: f.label, nodeId: conn.node, source: "Заголовок" });
    //         });
    //     });
    // });

    availableFields.sort((a, b) => {
        if (a.nodeId < b.nodeId) return -1;
        if (a.nodeId > b.nodeId) return 1;
        return a.label.localeCompare(b.label);
    });

    modalBody.innerHTML = `
    <h3>Редактирование условия</h3>
    <label class="modal-label">Заголовок:
      <input type="text" id="nodeTitleInput" value="${node.data.title || ''}" class="modal-input"/>
    </label>
    <div id="conditions-container" class="conditions-container"></div>
    <div class="condition-form">
      <select id="conditionField" class="modal-select">
      <option class="subtitle" value="Выбери значение" >Выбери значение</option>
            ${availableFields.map(f => {
        return `
        <optgroup label="${f.title}">
        <option class="subtitle" value="${f.label}">${f.label}</option>
        <option class="subtitle" value="${f.value}" >${f.value}</option>
        </optgroup>
        <hr />`
    }).join('')};
</select>
      <select id="conditionType" class="modal-select">
        <option value="equals">Равно (==)</option>
        <option value="not_equals">Не равно (!=)</option>
        <option value="greater_than">Больше (>)</option>
        <option value="less_than">Меньше (<)</option>
        <option value="greater_or_equal">Больше или равно (>=)</option>
        <option value="less_or_equal">Меньше или равно (<=)</option>
        <option value="not_null">Не null</option>
        <option value="is_type">Тип данных</option>
      </select>
      <div id="conditionParams" class="condition-params"></div>
      <button id="addConditionBtn"  class="modal-button">Добавить условие</button>
    </div>
    <div id="fields-container" class="fields-container"></div>
    <select id="contextField" class="modal-select">
        <option class="subtitle"  id="inputValue">Выберите значение</option>
            ${availableFields.map(f => {
        return `
        <optgroup label="${f.source}: Name: ${f.title} ID-${f.nodeId}">
        <option class="subtitle"  id="inputValue" value="${f.value}" data-title="${f.label}" data-type="${f.type}">${f.label}: ${f.type}</option>
        </optgroup>
        <hr />`
    }).join('')};
    </select>
    <button id="addContextBtn" class="modal-button">Добавить поле</button>
    <p class="node-id">ID: ${id}</p>
  `;

    const conditionsContainer = modalBody.querySelector("#conditions-container");
    const conditionParams = modalBody.querySelector("#conditionParams");
    const conditionTypeSelect = modalBody.querySelector("#conditionType");
    const conditionFieldSelect = modalBody.querySelector("#conditionField");
    const fieldsContainer = modalBody.querySelector("#fields-container");

    function renderFields() {
        if (!node.data.fields) node.data.fields = [];
        fieldsContainer.innerHTML = node.data.fields.map((field, idx) => {
            let inputHtml = '';
            if (field.type === 'TEXT') {
                inputHtml = `<input type="text" data-index="${idx}" class="modal-input" placeholder="Введите значение" value="${field.value || ''}"/>`;
            } else if (field.type === 'FILE') {
                inputHtml = `<input type="file" data-index="${idx}" accept="Files/*" class="modal-input"/>`;
            } else if (field.type === 'INT') {
                inputHtml = `<input type="number" data-index="${idx}" class="modal-input"/>`;
            } else if (field.type === 'VARCHAR') {
                inputHtml = `<input type="text" data-index="${idx}" class="modal-input" value="${field.value || ''}"/>`;
            } else if (field.type === 'LONGTEXT') {
                inputHtml = `<textarea data-index="${idx}" class="modal-input">${field.value || ''}</textarea>`;
            } else if (field.type === 'IMAGE') {
                inputHtml = `<input type="file" data-index="${idx}" accept="image/*" class="modal-input"/>`;
                if (field.value) inputHtml += `<br><img src="${field.value}" class="field-image"/>`;
            } else if (field.type === 'DATE') {
                inputHtml = `<input type="date" data-index="${idx}" accept="image/*" class="modal-input"/>`;
            } else {
                inputHtml = `<input type="${field.type}" data-index="${idx}" value="${field.value || ''}" class="modal-input"/>`;
            }
            return `
        <div class="field">
          <label class="modal-label">${field.label}:</label>
          ${inputHtml}
          <button data-del="${idx}" class="del-btn">Удалить</button>
        </div>`;
        }).join('');
    }
    renderFields();
    fieldsContainer.oninput = (e) => {
        const index = +e.target.dataset.index;
        if (!node.data.fields[index]) return;
        if (node.data.fields[index].type === 'image') return;
        node.data.fields[index].value = e.target.value;
        updateNodeHtml(node, id);
    };

    fieldsContainer.onchange = (e) => {
        const index = +e.target.dataset.index;
        if (!node.data.fields[index]) return;
        if (node.data.fields[index].type === 'image' && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = ev => {
                node.data.fields[index].value = ev.target.result;
                renderFields();
                updateNodeHtml(node, id);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    };

    fieldsContainer.onclick = (e) => {
        if (e.target.classList.contains('del-btns')) {
            const index = +e.target.dataset.del;
            if (node.data.fields && node.data.fields[index] !== undefined) {
                node.data.fields.splice(index, 1);
                renderFields();
                updateNodeHtml(node, id);
            }
        }
    };

    function updateConditionParams() {
        const type = conditionTypeSelect.value;
        if (type === 'not_null') {
            conditionParams.innerHTML = '';
        } else if (type === 'is_type') {
            conditionParams.innerHTML = `
        <select id="conditionValue" class="modal-select">
            <option value="TEXT">TEXT</option>
            <option value="LONGTEXT">LONG TEXT</option>
            <option value="INT">INT</option>
            <option value="IMAGE">IMAGE</option>
            <option value="VARCHAR">VARCHAR</option>
        </select>`;
        } else if (type === 'regex') {
            conditionParams.innerHTML = `<input type="text" id="conditionValue" placeholder="Введите регулярное выражение (например, ^[a-zA-Z0-9]+$)" class="modal-input"/>`;
        } else if (['length_min', 'length_max', 'length_exact'].includes(type)) {
            conditionParams.innerHTML = `<input type="number" id="conditionValue" placeholder="Введите число" min="0" class="modal-input"/>`;
        } else {
            conditionParams.innerHTML = `<input type="text" id="conditionValue" placeholder="Введите значение" class="modal-input"/>`;
        }
    }
    conditionTypeSelect.addEventListener('change', updateConditionParams);
    updateConditionParams();

    function renderConditions() {
        if (!node.data.conditions) node.data.conditions = [];
        conditionsContainer.innerHTML = node.data.conditions.map((cond, idx) => {
            let display = '';
            if (cond.type === 'not_null') display = `${cond.field} IS NOT NULL`;
            else if (cond.type === 'is_type') display = `${cond.field} IS ${cond.value}`;
            else if (cond.type === 'length_min') display = `LENGTH(${cond.field}) >= ${cond.value}`;
            else if (cond.type === 'length_max') display = `LENGTH(${cond.field}) <= ${cond.value}`;
            else if (cond.type === 'length_exact') display = `LENGTH(${cond.field}) = ${cond.value}`;
            else if (cond.type === 'regex') display = `${cond.field} MATCHES ${cond.value}`;
            else display = `${cond.field} ${cond.operator} ${cond.value}`;
            return `
        <div class="condition ${cond.field.split(':')[0].toLowerCase()}">
          <span>${display}</span>
          <button data-del="${idx}" class="del-btn">Удалить</button>
        </div>`;
        }).join('');
    }

    renderConditions();

    modalBody.querySelector('#addConditionBtn').onclick = () => {
        const field = conditionFieldSelect.value;
        const type = conditionTypeSelect.value;
        const valInput = modalBody.querySelector('#conditionValue');
        const value = valInput ? valInput.value.trim() : null;

        if (!field || (type !== 'not_null' && !value)) return;

        if (!node.data.conditions) node.data.conditions = [];

        const condition = { field, type };
        if (type !== 'not_null') condition.value = value;
        if (['equals', 'not_equals', 'greater_than', 'less_than', 'greater_or_equal', 'less_or_equal'].includes(type)) {
            condition.operator = {
                equals: '==',
                not_equals: '!=',
                greater_than: '>',
                less_than: '<',
                greater_or_equal: '>=',
                less_or_equal: '<='
            }[type];
        }

        node.data.conditions.push(condition);
        renderConditions();
        updateNodeHtml(node, id);

        if (valInput) valInput.value = '';
    };

    conditionsContainer.onclick = (e) => {
        if (e.target.classList.contains('del-btn')) {
            const index = +e.target.dataset.del;
            if (node.data.conditions && node.data.conditions[index] !== undefined) {
                node.data.conditions.splice(index, 1);
                renderConditions();
                updateNodeHtml(node, id);
            }
        }
    };

    modalBody.querySelector('#nodeTitleInput').oninput = e => {
        node.data.title = e.target.value.trim() || node.name;
        updateNodeHtml(node, id);
    };

    modalBody.querySelector('#addContextBtn').onclick = () => {
        const select = modalBody.querySelector('#contextField');
        const selectedOption = select.options[select.selectedIndex];
        const title = selectedOption ? selectedOption.dataset.title : '';
        const type = selectedOption ? selectedOption.dataset.type : '';
        const value = select.value;
        if (!title) return alert('Поля отсутсвуют');

        if (!node.data.fields) node.data.fields = [];
        node.data.fields.push({
            label: title, type: type, value: value
        });
        renderFields();
        updateNodeHtml(node, id);
    };
}

function showGeneralModal(node, id) {
    const inputNodes = editor.drawflow.drawflow.Home.data[id]?.inputs?.input_1?.connections || [];
    const availableFields = [];
    inputNodes.forEach(conn => {
        const inputNode = editor.getNodeFromId(parseInt(conn.node));
        if (inputNode && inputNode.data) {
            if (inputNode.data.fields) {
                inputNode.data.fields.forEach(content => {
                    availableFields.push({ label: content.label, type: content.type, value: content.value, nodeId: conn.node, source: '' });
                });
            }
            // if (inputNode.data.fields) {
            //     inputNode.data.fields.forEach(field => {
            //         availableFields.push({ label: field.label, nodeId: conn.node, source: 'Input' });
            //     });
            // }
        }
    });


    // [inputNodes, outputTrueNodes, outputFalseNodes].forEach((connList) => {

    //     connList.forEach(conn => {
    //         const n = editor.getNodeFromId(parseInt(conn.node));
    //         if (!n || !n.data) return;
    //         if (n.data.fields) n.data.fields.forEach(f => {
    //             if (f.type) {
    //                 availableFields.push({ title: n.data.title, label: f.label, value: f.value, nodeId: conn.node, source: "Поле" });
    //             }
    //             if (n.data.title) availableFields.push({ title: n.data.title, label: f.label, nodeId: conn.node, source: "Заголовок" });
    //         });
    //     });
    // });


    availableFields.sort((a, b) => {
        if (a.nodeId < b.nodeId) return -1;
        if (a.nodeId > b.nodeId) return 1;
        return a.label.localeCompare(b.label);
    });

    modalBody.innerHTML = `
    <h3>Редактирование ноды: ${node.name}</h3>
    <label class="modal-label">Заголовок:
      <input type="text" id="nodeTitleInput" value="${node.data.title || ''}" class="modal-input"/>
    </label>
    <div id="fields-container" class="fields-container"></div>
    <div class="field-form">
      <input type="text" id="inputName" placeholder="Название поля" class="modal-input"/>
      <select id="inputType" class="modal-select">
        <option value="TEXT">TEXT</option>
        <option value="FILE">FILE</option>
        <option value="LONGTEXT">LONG TEXT</option>
        <option value="INT">INT</option>
        <option value="IMAGE">IMAGE</option>
        <option value="VARCHAR">VARCHAR</option>
        <option value="DATE">DATE</option>
      </select>
    </div>
      <button id="addInputBtn" class="modal-button">Добавить поле</button>
      </div >
      <p class="node-id">ID: ${id}</p>
  `;

    const fieldsContainer = modalBody.querySelector("#fields-container");

    function renderFields() {
        if (!node.data.fields) node.data.fields = [];
        fieldsContainer.innerHTML = node.data.fields.map((field, idx) => {
            let inputHtml = '';
            if (field.type === 'TEXT') {
                inputHtml = `<input type="text" data-index="${idx}" class="modal-input" placeholder="Введите значение" value="${field.value || ''}"/>`;
            } else if (field.type === 'FILE') {
                inputHtml = `<input type="file" data-index="${idx}" accept="Files/*" class="modal-input"/>`;
            } else if (field.type === 'INT') {
                inputHtml = `<input type="number" data-index="${idx}" class="modal-input"/>`;
            } else if (field.type === 'VARCHAR') {
                inputHtml = `<input type="text" data-index="${idx}" class="modal-input" value="${field.value || ''}"/>`;
            } else if (field.type === 'LONGTEXT') {
                inputHtml = `<textarea data-index="${idx}" class="modal-input">${field.value || ''}</textarea>`;
            } else if (field.type === 'IMAGE') {
                inputHtml = `<input type="file" data-index="${idx}" accept="image/*" class="modal-input"/>`;
                if (field.value) inputHtml += `<br><img src="${field.value}" class="field-image"/>`;
            } else if (field.type === 'DATE') {
                inputHtml = `<input type="date" data-index="${idx}" accept="image/*" class="modal-input"/>`;
            } else {
                inputHtml = `<input type="${field.type}" data-index="${idx}" value="${field.value || ''}" class="modal-input"/>`;
            }
            return `
        <div class="field">
          <label class="modal-label">${field.label}:</label>
          ${inputHtml}
          <button data-del="${idx}" class="del-btn">Удалить</button>
        </div>`;
        }).join('');
    }

    renderFields();

    fieldsContainer.oninput = (e) => {
        const index = +e.target.dataset.index;
        if (!node.data.fields[index]) return;
        if (node.data.fields[index].type === 'image') return;
        node.data.fields[index].value = e.target.value;
        updateNodeHtml(node, id);
    };

    fieldsContainer.onchange = (e) => {
        const index = +e.target.dataset.index;
        if (!node.data.fields[index]) return;
        if (node.data.fields[index].type === 'image' && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = ev => {
                node.data.fields[index].value = ev.target.result;
                renderFields();
                updateNodeHtml(node, id);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    };

    fieldsContainer.onclick = (e) => {
        if (e.target.classList.contains('del-btn')) {
            const index = +e.target.dataset.del;
            if (node.data.fields && node.data.fields[index] !== undefined) {
                node.data.fields.splice(index, 1);
                renderFields();
                updateNodeHtml(node, id);
            }
        }
    };

    modalBody.querySelector('#addInputBtn').onclick = () => {
        const label = modalBody.querySelector('#inputName').value.trim();
        const type = modalBody.querySelector('#inputType').value;
        if (!label) return alert('Введите название поля');
        if (!node.data.fields) node.data.fields = [];
        node.data.fields.push({ label, type, value: '' });
        renderFields();
        updateNodeHtml(node, id);
        modalBody.querySelector('#inputName').value = '';
    };


    modalBody.querySelector('#nodeTitleInput').oninput = (e) => {
        node.data.title = e.target.value.trim() || node.name;
        updateNodeHtml(node, id);
    };
}
function showProcessModal(node, id) {
    const inputNodes = editor.drawflow.drawflow.Home.data[id]?.inputs?.input_1?.connections || [];
    const availableFields = [];

    // const input_always_Nodes = editor.drawflow.drawflow.Home.data[conn.node]?.inputs?.input_1?.connections || [];
    // console.log(input_always_Nodes);
    inputNodes.forEach(f => {
        const inputNode = editor.getNodeFromId(parseInt(f.node));
        if (inputNode && inputNode.data) {
            if (inputNode.data.fields) {
                inputNode.data.fields.forEach(content => {
                    availableFields.push({ label: content.label, type: content.type, value: content.value, nodeId: f.node, source: 'Node' });
                    // console.log(availableFields);
                });
            }
            // if (inputNode.data.fields) {
            //     inputNode.data.fields.forEach(field => {
            //         availableFields.push({ label: field.label, nodeId: conn.node, source: 'Input' });
            //     });
            // }
        }

    });


    // [inputNodes, outputTrueNodes, outputFalseNodes].forEach((connList) => {

    //     connList.forEach(conn => {
    //         const n = editor.getNodeFromId(parseInt(conn.node));
    //         if (!n || !n.data) return;
    //         if (n.data.fields) n.data.fields.forEach(f => {
    //             if (f.type) {
    //                 availableFields.push({ title: n.data.title, label: f.label, value: f.value, nodeId: conn.node, source: "Поле" });
    //             }
    //             if (n.data.title) availableFields.push({ title: n.data.title, label: f.label, nodeId: conn.node, source: "Заголовок" });
    //         });
    //     });
    // });


    availableFields.sort((a, b) => {
        if (a.nodeId < b.nodeId) return -1;
        if (a.nodeId > b.nodeId) return 1;
        return a.label.localeCompare(b.label);
    });

    modalBody.innerHTML = `
    <h3>Редактирование ноды: ${node.name}</h3>
    <label class="modal-label">Заголовок:
      <input type="text" id="nodeTitleInput" value="${node.data.title || ''}" class="modal-input"/>
    </label>
    <div id="fields-container" class="fields-container"></div>
    <div class="field-form">
      <input type="text" id="inputName" placeholder="Название поля" class="modal-input"/>
      <select id="inputType" class="modal-select">
        <option value="TEXT">TEXT</option>
        <option value="FILE">FILE</option>
        <option value="LONGTEXT">LONG TEXT</option>
        <option value="INT">INT</option>
        <option value="IMAGE">IMAGE</option>
        <option value="VARCHAR">VARCHAR</option>
        <option value="DATE">DATE</option>
      </select>
    </div>
      <button id="addInputBtn" class="modal-button">Добавить поле</button>
      <select id="processField" class="modal-select">
        <option class="subtitle"  id="inputValue">Выберите значение</option>
            ${availableFields.map(f => {
        return `
        <optgroup label="${f.source}: ID-${f.nodeId}">
        <option class="subtitle"  id="inputValue" value="${f.value}" data-title="${f.label}" data-type="${f.type}">${f.label}: ${f.type}</option>
        </optgroup>
        <hr />`
    }).join('')};
    </select>
      </div >
      <button id="addProcessBtn" class="modal-button">Добавить поле</button>
    <p class="node-id">ID: ${id}</p>
  `;

    const fieldsContainer = modalBody.querySelector("#fields-container");

    function renderFields() {
        if (!node.data.fields) node.data.fields = [];
        fieldsContainer.innerHTML = node.data.fields.map((field, idx) => {
            let inputHtml = '';
            if (field.type === 'TEXT') {
                inputHtml = `<input type="text" data-index="${idx}" class="modal-input" placeholder="Введите значение" value="${field.value || ''}"/>`;
            } else if (field.type === 'FILE') {
                inputHtml = `<input type="file" data-index="${idx}" accept="Files/*" class="modal-input"/>`;
            } else if (field.type === 'INT') {
                inputHtml = `<input type="number" data-index="${idx}" class="modal-input"/>`;
            } else if (field.type === 'VARCHAR') {
                inputHtml = `<input type="text" data-index="${idx}" class="modal-input" value="${field.value || ''}"/>`;
            } else if (field.type === 'LONGTEXT') {
                inputHtml = `<textarea data-index="${idx}" class="modal-input">${field.value || ''}</textarea>`;
            } else if (field.type === 'IMAGE') {
                inputHtml = `<input type="file" data-index="${idx}" accept="image/*" class="modal-input"/>`;
                if (field.value) inputHtml += `<br><img src="${field.value}" class="field-image"/>`;
            } else if (field.type === 'DATE') {
                inputHtml = `<input type="date" data-index="${idx}" accept="image/*" class="modal-input"/>`;
            } else {
                inputHtml = `<input type="${field.type}" data-index="${idx}" value="${field.value || ''}" class="modal-input"/>`;
            }
            return `
        <div class="field">
          <label class="modal-label">${field.label}:</label>
          ${inputHtml}
          <button data-del="${idx}" class="del-btn">Удалить</button>
        </div>`;
        }).join('');
    }

    renderFields();

    fieldsContainer.oninput = (e) => {
        const index = +e.target.dataset.index;
        if (!node.data.fields[index]) return;
        if (node.data.fields[index].type === 'image') return;
        node.data.fields[index].value = e.target.value;
        updateNodeHtml(node, id);
    };

    fieldsContainer.onchange = (e) => {
        const index = +e.target.dataset.index;
        if (!node.data.fields[index]) return;
        if (node.data.fields[index].type === 'image' && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = ev => {
                node.data.fields[index].value = ev.target.result;
                renderFields();
                updateNodeHtml(node, id);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    };

    fieldsContainer.onclick = (e) => {
        if (e.target.classList.contains('del-btn')) {
            const index = +e.target.dataset.del;
            if (node.data.fields && node.data.fields[index] !== undefined) {
                node.data.fields.splice(index, 1);
                renderFields();
                updateNodeHtml(node, id);
            }
        }
    };

    modalBody.querySelector('#addInputBtn').onclick = () => {
        const label = modalBody.querySelector('#inputName').value.trim();
        const type = modalBody.querySelector('#inputType').value;
        if (!label) return alert('Введите название поля');
        if (!node.data.fields) node.data.fields = [];
        node.data.fields.push({ label, type, value: '' });
        renderFields();
        updateNodeHtml(node, id);
        modalBody.querySelector('#inputName').value = '';
    };


    modalBody.querySelector('#nodeTitleInput').oninput = (e) => {
        node.data.title = e.target.value.trim() || node.name;
        updateNodeHtml(node, id);
    };
    modalBody.querySelector('#addProcessBtn').onclick = () => {
        const select = modalBody.querySelector('#processField');
        const selectedOption = select.options[select.selectedIndex];
        const title = selectedOption ? selectedOption.dataset.title : '';
        const type = selectedOption ? selectedOption.dataset.type : '';
        const value = select.value;
        if (!title) return alert('Поля отсутсвуют');
        if (!node.data.fields) node.data.fields = [];
        node.data.fields.push({
            label: title, type: type, value: value
        });
        renderFields();
        updateNodeHtml(node, id);
    };
}
