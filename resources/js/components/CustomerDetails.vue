<template>
  <div>
    <v-table>
      <thead>
        <tr>
          <th width="5%">ID</th>
          <th>Details</th>
          <th width="10%">Status</th>
          <th>Due Date</th>
          <th>Attachments</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="customerOrder in customer.orders" :key="customerOrder.id">
          <td width="5%">{{ customerOrder.id }}</td>
          <td width="20%">{{ customerOrder.details }}</td>
          <td width="10%">{{ customerOrder.status }}</td>
          <td class="due">{{ customerOrder.due_date }}</td>
          <td>
            <a v-for="file in parseFiles(customerOrder.files)" :key="file" :href="getFileUrl(file)" target="_blank">
              <v-icon icon="mdi-open-in-new" alt="filename"></v-icon>
            </a>
          </td>
          <td>
            <v-btn color="info" @click="showOrderEditDialog = true; selectedOrder = customerOrder">
              <v-icon icon="mdi-file-document-edit"></v-icon>
            </v-btn>
            <v-btn color="danger" @click="deleteOrder(customerOrder.id)">
              <v-icon icon="mdi-delete"></v-icon>
            </v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>
    
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

export default {
  components: {
    OrderEdit,
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
      selectedOrder: null,
    };
  },
  methods: {
    formatDate(dateTime) {
      const date = new Date(dateTime);
      const formattedDate = date.toLocaleDateString();
      return formattedDate;
    },
    handleOrderUpdated() {
      this.showOrderEditDialog = false;
    },
    showOrderEdit(order) {
      this.selectedOrder = order;
      this.showOrderEditDialog = true;
    },
    getFileUrl(file) {
      return `../storage/app/${file}`;
    },
    parseFiles(files) {
      return JSON.parse(files);
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
  },
  mounted() {
    this.fetchCustomerOrders();
  },
};
</script>
