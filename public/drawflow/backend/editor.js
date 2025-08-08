import { generateNodeHTML } from "./utils.js";

export let editor = null;

export function initEditor() {
  const el = document.getElementById("drawflow");
  editor = new window.Drawflow(el);
  editor.start();
}


export function addNode(type, x, y, id = null, data = {actions: [ ]}) {
  if (!editor) throw new Error("Editor is not initialized");

  const { html, inputs, outputs } = generateNodeHTML(type, data);

  if (id) {
    editor.addNodeWithId(type, inputs, outputs, x, y, data.title || type, data, html, id);
  } else {
    editor.addNode(type, inputs, outputs, x, y, data.title || type, data, html);
  }
}

export function updateNodeHtml(node, id) {
  if (!node.data) node.data = {};
  if (!node.data.title) node.data.title = node.name;
  if (!node.data.actions) node.data.actions = [];
  if (!node.data.fields) node.data.fields = [];
  if (!node.data.conditions && node.name === 'condition') node.data.conditions = [];
  if (!node.data.fields && node.name === 'process') node.data.fields = [];

  const { html } = generateNodeHTML(node.name, node.data);

  const nodeEl = document.getElementById(`node-${id}`);
  if (nodeEl) nodeEl.querySelector('.drawflow_content_node').innerHTML = html;
  editor.updateNodeDataFromId(id, node.data);
}
