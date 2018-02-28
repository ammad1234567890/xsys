
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import VeeValidate from 'vee-validate';
const VueInputMask = require('vue-inputmask').default
import DatatableFactory from 'vuejs-datatable';

import $ from 'jquery';
import 'datatables.net';
Vue.use(VueInputMask)
Vue.use(DatatableFactory);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('retailer-component', require('./components/RetailerComponent.vue'));
Vue.component('retailer-outlet-component', require('./components/RetailerOutletComponent.vue'));
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('product-component', require('./components/ProductComponent.vue'));
Vue.component('role-component', require('./components/RoleComponent.vue'));
Vue.component('userrole-component', require('./components/UserRoleComponent.vue'));
Vue.component('category-component', require('./components/categoryComponent.vue'));
Vue.component('product-component', require('./components/productComponent.vue'));
Vue.component('order-component', require('./components/OrderComponent.vue'));
Vue.component('receive-component', require('./components/ReceiveComponent.vue'));
Vue.component('orderpayment-component', require('./components/OrderPaymentComponent.vue'));
Vue.component('city-component', require('./components/CityComponent.vue'));
Vue.component('region-component', require('./components/RegionComponent.vue'));
Vue.component('department-component', require('./components/DepartmentComponent.vue'));
Vue.component('stafftype-component', require('./components/StaffTypeComponent.vue'));
Vue.component('designation-component', require('./components/DesignationComponent.vue'));
Vue.component('staff-component', require('./components/staffComponent.vue'));
Vue.component('payment-component', require('./components/PaymentTypeComponent.vue'));
Vue.component('currency-component', require('./components/CurrencyComponent.vue'));
Vue.component('receivestatus-component', require('./components/ReceiveStatusComponent.vue'));
const app = new Vue({
    el: '#app'
});
