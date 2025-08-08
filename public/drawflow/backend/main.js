import { editor, initEditor, addNode, updateNodeHtml } from "./editor.js";
import { showModalForNode } from "./modal.js";

let draggedType = null;

document.addEventListener("DOMContentLoaded", () => {
  initEditor();

  const drawflowEl = document.getElementById('drawflow');

  document.querySelectorAll('.drag-item').forEach(el => {
    el.addEventListener('dragstart', e => {
      draggedType = e.target.dataset.node;
    });
  });

  drawflowEl.addEventListener('dragover', e => e.preventDefault());
  drawflowEl.addEventListener('drop', e => {
    e.preventDefault();
    if (!draggedType) return;
    const rect = e.currentTarget.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    addNode(draggedType, x, y);
    draggedType = null;
  });

  drawflowEl.addEventListener('dblclick', e => {
    const nodeEl = e.target.closest('.drawflow-node');
    if (!nodeEl) return;
    const id = parseInt(nodeEl.id.replace('node-', ''));
    const node = editor.getNodeFromId(id);
    if (!node) return;
    showModalForNode(node, id);
  });

  const modal = document.getElementById("node-modal");
  const span = document.querySelector(".close");

  span.onclick = () => modal.style.display = "none";
  window.onclick = e => {
    if (e.target === modal) modal.style.display = "none";
  };

  document.getElementById('export-json').addEventListener('click', () => {
    console.log(editor.export());
  });

  const loadInput = document.getElementById('file-input');
  document.getElementById('import-json').addEventListener('click', () => loadInput.click());

  loadInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = evt => {
      try {
        const json = JSON.parse(evt.target.result);
        editor.clear();
        editor.import(json);
        setTimeout(() => {
          const nodes = editor.drawflow.drawflow.Home.data || {};
          Object.keys(nodes).forEach(key => {
            const node = editor.getNodeFromId(parseInt(key));
            if (node) updateNodeHtml(node, parseInt(key));
          });
        }, 300);
      } catch {
        alert('Неверный JSON файл');
      }
    };
    reader.readAsText(file);
  });
});
