
require('./bootstrap');

window.Vue = require('vue');

import VueDatePicker from '@mathieustan/vue-datepicker';
import VModal from 'vue-js-modal'
Vue.use(VueDatePicker);
Vue.use(VModal);


Vue.component('stock-component', require('./components/StockComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.use(require('vue-moment'));

/*vue progress var*/
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
  color: '#A3CB38',
  failedColor: '#874b4b',
  thickness: '4px',
  location: 'top'
})


const app = new Vue({
    el: '#vue-app',
});
