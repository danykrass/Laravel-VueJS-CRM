<template>
  <div>
    <table>
      <thead>
        <tr>
          <th width="5%">ID</th>
          <th>Details</th>
          <th width="10%">Status</th>
          <th>Due Date</th>
          <th>Attachments</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="customerOrder in orders" :key="customerOrder.id">
        <td width="5%">{{ customerOrder.id }}</td>
        <td width="20%">{{ customerOrder.details }}</td>
        <td width="10%">{{ customerOrder.status }}</td>
        <td class="due">{{ customerOrder.due_date }}</td>
        <td>
            <a v-for="file in parseFiles(customerOrder.files)" :key="file" :href="getFileUrl(file)" target="_blank"><v-icon icon="mdi-open-in-new" alt="filename"></v-icon></a>
        </td>
        <td>{{ formatDate(customerOrder.created_at) }}</td>
        <td>
          <v-btn color="info" @click="showOrderEditDialog = true; selectedOrder = customerOrder">
            Edit
            <v-icon icon="mdi-file-document-edit"></v-icon>
          </v-btn>
          <v-btn color="danger" @click="deleteOrder(customerOrder.id)">
            <v-icon icon="mdi-delete"></v-icon>
          </v-btn>
        </td>
      </tr>
      </tbody>
    </table>
    <v-dialog v-model="showOrderEditDialog" max-width="700">
      <v-card>
        <v-card-title>
          <span class="headline">Order Edit</span>
        </v-card-title>
        <v-card-text>
          <order-edit :order="selectedOrder" @order-updated="handleOrderUpdated"></order-edit>
        </v-card-text>
        <v-card-actions>
          <v-btn color="white" variant="outlined" @click="showOrderEditDialog = false">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from 'axios';
import OrderEdit from './OrderEdit.vue';
import OrderForm from './OrderForm.vue';

export default {
  components: {
    OrderEdit,
    OrderForm,
  },
  props: {
    customer: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      showOrderEditDialog: false,
      orders: [],
      selectedOrder: null
    };
  },
  methods: {
    formatDate(dateTime) {
      const date = new Date(dateTime);
      const formattedDate = date.toLocaleDateString();
      const formattedTime = date.toLocaleTimeString();
      return `${formattedDate}`;
    },
    handleOrderUpdated() {
      this.showOrderEditDialog = false;
    },
    showOrderEdit(order) {
      this.selectedOrder = order;
      this.showOrderEditDialog = true;
    },
    fetchCustomerOrders() {
      axios.get(`/api/customers/${this.customer.id}/orders`)
        .then(response => {
          this.customer.orders = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    getFileUrl(file) {
      return `../storage/app/${file}`;
    },
    parseFiles(files) {
      return JSON.parse(files);
    },
    generateFileName(file, index) {
    const customerID = this.customer.id;
    const orderID = this.customerOrder.id;
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();
    const hours = date.getHours();
    const minutes = date.getMinutes();
    const seconds = date.getSeconds();
    const timestamp = `${year}_${month}_${day}_${hours}_${minutes}`;
    const fileName = `customer${customerID}_order${orderID}_${timestamp}${index !== 0 ? `_${seconds}` : ''}`;
    return fileName;
  },
  },
  mounted() {
    this.fetchCustomerOrders();
  },
};
</script>
