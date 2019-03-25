try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');


    require('bootstrap');
    require('bootstrap-confirmation2');
    window.alertify = require('alertifyjs');

} catch (e) {}