import 'bootstrap';
import axios from 'axios';
import { Serbian } from 'flatpickr/dist/l10n/sr.js';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Serbian = Serbian;