import './bootstrap';
// resources/js/app.js
import Alpine from 'alpinejs'
import Pickr from '@simonwep/pickr';　// Pickr をインポート
import flatpickr from "flatpickr";
import { Japanese } from "flatpickr/dist/l10n/ja.js";
import {TabulatorFull as Tabulator} from 'tabulator-tables';
import { validateField, validateForm, validationRules } from './validation';
import { messages_jp } from './message';

window.Alpine = Alpine;
window.Pickr = Pickr;
window.flatpickr = flatpickr;
window.FlatpickrJapanese = Japanese;
window.Tabulator = Tabulator;
window.validateField = validateField;
window.validateForm = validateForm;
window.validationRules = validationRules;
window.messages_jp = messages_jp;

Alpine.start();

//  CSSをインポート
import '@simonwep/pickr/dist/themes/classic.min.css';
import "flatpickr/dist/flatpickr.css";
import "flatpickr/dist/themes/material_blue.css";
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'tabulator-tables/dist/css/tabulator.min.css';
//その他、 "dark", "material_blue", "material_green", "material_red", "material_orange", "airbnb", "confetti" がある。

// flatpickr.setDefaults({
//     locale: Japanese,
//     dateFormat: "Y年m月d日"
// });
