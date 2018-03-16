
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
//Vue.component('product-component', require('./components/productComponent.vue'));
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
Vue.component('allorders-component', require('./components/allOrdersComponent.vue'));
Vue.component('receiveorders-component', require('./components/ReceiveOrdersComponent.vue'));
Vue.component('createretailerorders-component', require('./components/CreateRetailerOrderComponent.vue'));
Vue.component('retailerorders-component', require('./components/RetailerOrderComponent.vue'));
Vue.component('warehouse-component', require('./components/WarehouseComponent.vue'));
Vue.component('warehouseissue-component', require('./components/WarehouseIssueComponent.vue'));
Vue.component('warehousestaff-component', require('./components/warehouseStaffComponent.vue'));
Vue.component('warehousestock-component', require('./components/warehouseStockComponent.vue'));
Vue.component('mainwarehousereceive-component',require('./components/mainWarehouseReceiveComponent.vue'));
//Vue.component('mainwarehousereceive-component',require('./components/mainWarehouseReceiveComponent.vue'));
Vue.component('warehousetype-component', require('./components/WarehouseTypeComponent.vue'));
Vue.component('financeorderapproval-component', require('./components/OrderFinanceApprovalComponent.vue'));

Vue.component('retailerbox-component', require('./components/RetailerboxComponent.vue'));
Vue.component('manufactureorder-component', require('./components/ManufactureorderComponent.vue'));
Vue.component('totalproduct-component', require('./components/TotalproductComponent.vue'));
Vue.component('totalwarehouse-component', require('./components/TotalwarehouseComponent.vue'));
Vue.component('activeproduct-component', require('./components/ActiveproductComponent.vue'));
Vue.component('totalemployeesbox-component', require('./components/TotalemployeesboxComponent.vue'));
Vue.component('salereport-component', require('./components/SalereportComponent.vue'));
Vue.component('regionwisereport-component', require('./components/RegionwisesalereportComponent.vue'));
Vue.component('productstats-component', require('./components/ProductstatsComponent.vue'));
Vue.component('invoiceview-component', require('./components/InvoiceviewComponent.vue'));
Vue.component('collection-component', require('./components/CollectionComponent.vue'));
Vue.component('retailerledger-component', require('./components/RetailerLedgerComponent.vue'));
Vue.component('bank-component', require('./components/BankComponent.vue'));


const app = new Vue({
    el: '#app'
});
