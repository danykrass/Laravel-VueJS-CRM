<template>
  <div>
    <v-btn color="success" @click="showOrderFormDialog=true">Add order</v-btn>
    <div class="selectBox">
      Show per page:
      <select v-model="perPage" @change="fetchOrders(1, perPage)">
        <option v-for="option in perPageOptions" :value="option" :key="option">{{ option }}</option>
      </select>
    </div>
    <v-table>
      <thead>
        <tr>
          <th>Order ID:</th>
          <th>Name</th>
          <th>Details</th>
          <th>
            <div class="selectBox">
              Sort by status:
              <select v-model="selectedStatus" @change="fetchOrders(1, perPage)">
                <option value="">All</option>
                <option value="cancelled">Cancelled</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
              </select>
            </div>
          </th>
          <th>Due Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in paginatedOrders" :key="order.id">
          <td>{{ order.id }}</td>
          <td>{{ order.customer.name }}</td>
          <td>{{ order.details }}</td>
          <td>{{ order.status }}</td>
          <td>{{ order.due_date }}</td>
          <td>
            <v-btn color="info" @click="showOrderFormEdit(order)"><v-icon size="x-large" icon="mdi-file-document-edit"></v-icon></v-btn>
            <v-btn color="danger" @click="deleteOrder(order.id)"><v-icon size="x-large" icon="mdi-delete"></v-icon></v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>
    <div class="selectBox">
      Show per page:
      <select v-model="perPage" @change="fetchOrders(1, perPage)">
        <option v-for="option in perPageOptions" :value="option" :key="option">{{ option }}</option>
      </select>
    </div>
    <div class="text-center">
      <v-container>
        <v-row justify="center">
          <v-container class="max-width">
            <pagination v-model="page" :records="pagination.total" :per-page="perPage" @paginate="fetchOrders(page, perPage)"/>
          </v-container>
        </v-row>
      </v-container>
    </div>
    <v-dialog v-model="showOrderFormDialog" max-width="700">
      <v-card>
        <v-card-title>
          <span class="headline">Add an order</span>
        </v-card-title>
        <v-card-text>
          <order-form @order-created="handleOrderCreated"></order-form>
        </v-card-text>
        <v-card-actions>
          <v-btn color="white" variant="outlined" @click="showOrderFormDialog = false">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
import Swal from 'sweetalert2';
import axios from 'axios';
import Pagination from 'v-pagination-3';
import OrderForm from './OrderForm.vue';
import OrderEdit from './OrderEdit.vue';

export default {
  components: {
    Pagination,
    OrderForm,
    OrderEdit,
  },
  data() {
    return {
      loading: false,
      showOrderFormDialog: false,
      showOrderEditDialog: false,
      orders: [],
      selectedStatus: '',
      page: 1,
      perPage: 10,
      perPageOptions: [10, 25, 50, 100],
      pagination: {
        total: 0,
        per_page: 0,
        current_page: 0
      },
      selectedOrder: null,
    };
  },
  computed: {
    paginatedOrders() {
      const startIndex = (this.page - 1) * this.perPage;
      const endIndex = startIndex + this.perPage;
      let slicedOrders = this.orders.slice(startIndex, endIndex);

      if (this.selectedStatus) {
        slicedOrders = slicedOrders.filter(order => order.status === this.selectedStatus);
      }

      return slicedOrders;
    },
  },
  methods: {
    showOrderForm() {
      this.showOrderFormDialog = true;
    },
    showOrderFormEdit(order) {
      this.selectedOrder = order;
      this.showOrderEditDialog = true;
    },
    fetchOrders(page, perPage) {
      axios
        .get('/api/orders')
        .then((response) => {
          this.orders = response.data;

          if (this.selectedStatus) {
            this.orders = this.orders.filter((order) => order.status === this.selectedStatus);
          }

          this.sortOrders();

          this.calculatePagination(page, perPage);
        })
        .catch((error) => {
          console.error(error);
        });
    },
    sortOrders() {
      if (this.selectedStatus === '') {
        this.orders.sort();
      } else {
        this.orders = this.orders.filter((order) => order.status === this.selectedStatus);
      }
    },
    calculatePagination(page, perPage) {
      const startIndex = (page - 1) * perPage;
      const endIndex = startIndex + perPage;
      this.filteredOrders = this.orders.slice(startIndex, endIndex);

      this.pagination.total = this.orders.length;
      this.pagination.per_page = perPage;
      this.pagination.current_page = page;
    },
    handleOrderCreated() {
      this.fetchOrders(this.page, this.perPage);
      this.showOrderFormDialog = false;
    },
    handleOrderUpdated() {
      this.fetchOrders(this.page, this.perPage);
      this.showOrderEditDialog = false;
    },
    deleteOrder(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'The order will be deleted without possibility of recovery!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete(`/api/orders/${id}`)
            .then(() => {
              Swal.fire('Success!', 'Order successfully deleted.', 'success');
              this.fetchOrders(this.page, this.perPage);
            })
            .catch((error) => {
              console.error(error);
              Swal.fire('Error!', 'An error occurred while deleting the order.', 'error');
            });
        }
      });
    },
  },
  mounted() {
    this.fetchOrders(this.page, this.perPage);
  },
};
</script>