import './bootstrap';

import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './components/App.vue';
import CustomerList from './components/CustomerList.vue';
import CustomerDetails from './components/CustomerDetails.vue';
import CustomerForm from './components/CustomerForm.vue';
import CustomerFormEdit from './components/CustomerFormEdit.vue';
import OrderList from './components/OrderList.vue';
import OrderForm from './components/OrderForm.vue';
import OrderEdit from './components/OrderEdit.vue';
import OrderDetails from './components/OrderDetails.vue';
import 'sweetalert2/dist/sweetalert2.css';
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/cpanel/customers',
      name: 'CustomerList',
      component: CustomerList,
    },
    {
    path: '/cpanel/customers/create',
    name: 'CustomerForm',
    component: CustomerForm,
    },
    {
        path: '/cpanel/customers/:id/edit',
        name: 'CustomerFormEdit',
        component: CustomerFormEdit,
    },
    {
      path: '/cpanel/customers/:id/',
      name: 'CustomerDetails',
      component: CustomerDetails,
    },
    {
      path: '/cpanel/orders',
      name: 'OrderList',
      component: OrderList,
    },
    {
    path: '/cpanel/orders/:id/create',
    name: 'OrderForm',
    component: OrderForm,
    },
    {
      path: '/cpanel/orders/:id/edit',
      name: 'OrderEdit',
      component: OrderEdit,
    },
    {
      path: '/cpanel/orders/:id/update',
      name: 'OrderEdit',
      component: OrderEdit,
    },
    {
      path: '/cpanel/orders/:id/',
      name: 'OrderDetails',
      component: OrderDetails,
    },
  ],
});

const app = createApp(App)
const vuetify = createVuetify({
  components,
  directives,
  theme: {
    // defaultTheme: 'dark',
    themes: {
        light: {
            dark: true,
            colors: {
              primary: '#E53935', 
              secondary: '#FFCD',
              // danger: '#b57edc',B57EDC
            }
        }
    }
  }
})
app.use(router);
app.use(vuetify)

app.mount('#app')
