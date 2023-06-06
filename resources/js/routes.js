import CustomerList from './components/CustomerList.vue';
import CustomerDetails from './components/CustomerDetails.vue';
import CustomerForm from './components/CustomerForm.vue';
import CustomerFormEdit from './components/CustomerFormEdit.vue';
import OrderList from './components/OrderList.vue';
import OrderForm from './components/OrderForm.vue';
import OrderEdit from './components/OrderEdit.vue';

const routes = [
  {
    path: '/',
    redirect: '/customers',
  },
  {
    path: '/customers',
    name: 'CustomerList',
    component: CustomerList,
  },
  {
    path: '/customers/create',
    name: 'CustomerForm',
    component: CustomerForm,
  },
  {
    path: '/customers/:id/orders',
    name: 'CustomerDetails',
    component: CustomerDetails,
  },
  {
    path: '/customers/:id/edit',
    name: 'CustomerFormEdit',
    component: CustomerFormEdit,
  },
  {
    path: '/orders',
    name: 'OrderList',
    component: OrderList,
  },
  {
    path: '/customers/:id/orders/create',
    name: 'OrderForm',
    component: OrderForm,
  },
  {
    path: '/orders/:id/update',
    name: 'OrderEdit',
    component: OrderEdit,
  },
];

export default routes;
