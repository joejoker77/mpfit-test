import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import {Dropdown, Tab, Modal, Button, Collapse, Tooltip, Popover} from "bootstrap";

window.Modal = Modal;
window.Collapse = Collapse;
window.Tooltip = Tooltip;
window.Tab = Tab;
window.Dropdown = Dropdown;
window.Popover = Popover;
window.Button = Button;
