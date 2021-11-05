
import 'bootstrap';
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

require('select2/dist/css/select2.css');
require('select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css');
require('select2/dist/js/select2');

const $ = require('jquery');
global.$ = global.jQuery = $;

// Mes fichiers
import './styles/app.scss';


$(function () {
    console.log($('.select-2'));
    $('.select-2').select2({
        theme: "bootstrap-5",
        selectOnClose: true
    });
});