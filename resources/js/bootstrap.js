window._ = require('lodash');
window.Vue = require('vue');
import helpers from './helpers/helpers';
import storage from './helpers/storage';
import auth from './helpers/auth';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

Vue.config.productionTip = false
window.Helpers = helpers;
window.Storage = storage;
window.Auth = auth;

window.axios = require('axios');

document.addEventListener('DOMContentLoaded', function () {
  var token = document.querySelector('meta[name="csrf-token"]');
  if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
  }

  try {
    $.ajaxSetup({
      beforeSend: function (xhr) {
        const AUTH_TOKEN = Auth.getAccessToken();
        this.url = process.env.MIX_API_BASE_URL + this.url;
        if (AUTH_TOKEN) {
          xhr.setRequestHeader("Authorization", `Bearer ${AUTH_TOKEN}`);
        }
        if (token) {
          xhr.setRequestHeader('X-CSRF-TOKEN', token.content);
        } else {
          console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
      }
    });
  } catch (e) { }
});

if (Auth.checkAuth() && Helpers.isPath(window.location.pathname, ['/admin/login', '/admin/register', '/admin/recover-password', '/admin/password/reset.*'])) {
  window.location = '/admin/dashboard';
} else if (!Auth.checkAuth() && !Helpers.isPath(window.location.pathname, ['/admin/login', '/admin/register', '/admin/recover-password', '/admin/password/reset.*'])) {
  if (window.location.pathname != '' && window.location.pathname != '/') {
    window.location = '/admin/login?redirect=' + window.location.pathname;
  } else {
    window.location = '/admin/login';
  }
}


window.axios.defaults.baseURL = process.env.MIX_API_BASE_URL + '/admin/';

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.request.use(function (config) {
  // Do something before request is sent
  const AUTH_TOKEN = Auth.getAccessToken();

  if (AUTH_TOKEN) {
    config.headers.common['Authorization'] = `Bearer ${AUTH_TOKEN}`
  }

  return config;

}, function (error) {
  // Do something with request error
  return Promise.reject(error);
});

window.axios.interceptors.response.use(function (response) {

  if (response.data.code == '401') {
    Auth.removeSession();
    window.location = '/admin/login'
  } else
    return response;
}, function (error) {
  if (error.status == 401) {
    Auth.removeSession();
  }
  if (error.status == 500) {
    toastr.error(errors, "Error!");
  }
  console.log(error);
  // Do something with response error
  return Promise.reject(error);
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
