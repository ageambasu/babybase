window.$ = window.jQuery = require('jquery');
require('select2');
require('bootstrap');
require('bootstrap-datepicker');

import intlTelInput from 'intl-tel-input';
window.intlTelInput = intlTelInput;

$.fn.datepicker.defaults.format = "dd/mm/yyyy";
$(function() {
  //$('.datepicker').datepicker();
});
