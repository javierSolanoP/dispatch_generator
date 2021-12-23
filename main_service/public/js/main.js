import { component } from "./components/ObjComponent.js";

// Redireccionar right:
component.redirect('addButton', 'component', 'add');

// Redireccionar left:
component.redirect('back-button', 'add', 'component');