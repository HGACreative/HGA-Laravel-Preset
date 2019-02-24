window.ajax = require('axios');

window.ajax.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.ajax.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('We can\'t find a CSRF token in the document header');
}
