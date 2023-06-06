<template>
  <div>
    <v-btn color="danger" @click="showModal = true">Customer API settings</v-btn>
    <v-btn color="info" @click="handleButtonClick" :loading="loading">Load from API
      <template v-slot:loader>
        <v-progress-linear indeterminate></v-progress-linear>
      </template>
    </v-btn>
    <v-btn color="success" @click="showCustomerFormDialog = true">Add customer</v-btn>
    <div class="selectBox">
  Show per page:
  <select v-model="perPage" @change="fetchCustomers(1, perPage)">
    <option v-for="option in perPageOptions" :value="option" :key="option">{{ option }}</option>
  </select>
</div>

<v-table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(customer, index) in paginatedCustomers" :key="index">
      <td>{{ customer.id }}</td>
      <td>{{ customer.name }}</td>
      <td>{{ customer.email }}</td>
      <td>
        <v-btn color="success" @click="showCustomerDetails(customer)"><v-icon size="x-large" icon="mdi-shopping-search"></v-icon></v-btn>
        <v-btn color="info" @click="showCustomerFormEdit(customer)"><v-icon size="x-large" icon="mdi-account-edit"></v-icon></v-btn>
        <v-btn color="danger" @click="deleteCustomer(customer.id)"><v-icon size="x-large" icon="mdi-delete"></v-icon></v-btn>
      </td>
    </tr>
  </tbody>
</v-table>

<div class="selectBox">
  Show per page:
  <select v-model="perPage" @change="fetchCustomers(1, perPage)">
    <option v-for="option in perPageOptions" :value="option" :key="option">{{ option }}</option>
  </select>
</div>

<div class="text-center">
  <v-container>
    <v-row justify="center">
      <v-container class="max-width">
        <pagination v-model="page" :records="pagination.total" :per-page="perPage" :per-page-options="perPageOptions" @paginate="fetchCustomers" class="my-4"/>
      </v-container>
    </v-row>
  </v-container>
</div>

<v-dialog v-model="showModal" max-width="600">
  <v-card>
    <v-card-title>
      <span class="headline">Add customer APIs</span>
    </v-card-title>
    <v-card-text>
      <div v-for="(api, index) in apis" :key="index">
        <v-text-field variant="outlined" v-model="api.name" label="Service Name" required></v-text-field>
        <v-text-field variant="outlined" v-model="api.url" label="API URL" required></v-text-field>
        <v-btn color="danger" @click="removeApi(index)">Delete
          <v-icon icon="mdi-delete"></v-icon>
        </v-btn>
      </div>
      <v-btn icon="mdi-plus-box-multiple" size="small" variant="elevated" color="white" @click="addApi"></v-btn>
      <v-btn block size="large" variant="elevated" color="success" @click="saveApis">Save</v-btn>
    </v-card-text>
    <v-card-actions>
      <v-btn color="white" variant="outlined" @click="showModal = false">Close</v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>

<v-dialog v-model="showCustomerFormDialog" max-width="700">
  <v-card>
    <v-card-title>
      <span class="headline">Add a customer</span>
    </v-card-title>
    <v-card-text>
      <customer-form @customer-created="handleCustomerCreated"></customer-form>
    </v-card-text>
    <v-card-actions>
      <v-btn color="white" variant="outlined" @click="showCustomerFormDialog = false">Close</v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>

<v-dialog v-model="showCustomerFormEditDialog" max-width="700">
  <v-card>
    <v-card-title>
      <span class="headline">Edit customer</span>
    </v-card-title>
    <v-card-text>
      <customer-form-edit :customer="selectedCustomer" @customer-updated="handleCustomerUpdated"></customer-form-edit>
    </v-card-text>
    <v-card-actions>
      <v-btn color="white" variant="outlined" @click="showCustomerFormEditDialog = false">Close</v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>

<v-dialog v-model="showCustomerDetailsDialog" max-width="900">
  <v-card>
    <v-card-title>
      <span class="headline">Order History</span>
    </v-card-title>
    <v-card-text>
      <customer-details :customer="selectedCustomer"></customer-details>
    </v-card-text>
    <v-card-actions>
      <v-btn color="white" variant="outlined" @click="showCustomerDetailsDialog = false">Close</v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>
</div>
</template>
<script>
import Swal from 'sweetalert2';
import axios from 'axios';
import Pagination from 'v-pagination-3';
import CustomerForm from './CustomerForm.vue';
import CustomerFormEdit from './CustomerFormEdit.vue';
import CustomerDetails from './CustomerDetails.vue';

export default {
  components: {
    Pagination,
    CustomerForm,
    CustomerFormEdit,
    CustomerDetails
  },
  data() {
    return {
      loading: false,
      showModal: false,
      showCustomerFormDialog: false,
      showCustomerFormEditDialog: false,
      showCustomerDetailsDialog: false,
      apis: [{ name: '', url: '' }],
      customers: [],
      page: 1,
      perPage: 10,
      perPageOptions: [10, 25, 50, 100],
      pagination: {
        total: 0,
        per_page: 0,
        current_page: 0
      },
      selectedCustomer: null
    };
  },
  computed: {
    paginatedCustomers() {
      const start = (this.page - 1) * this.perPage;
      const end = start + this.perPage;
      return this.customers.slice(start, end);
    },
  },
  mounted() {
    this.fetchApiUrls();
    this.fetchCustomers(this.page, this.perPage);
  },
  watch: {
    loading(val) {
      if (!val) return;

      setTimeout(() => (this.loading = false), 2000);
    }
  },
  methods: {
    addApi() {
      this.apis.push({ name: '', url: '' });
    },
    removeApi(index) {
      this.apis.splice(index, 1);
    },
    saveApis() {
      const apiUrls = this.apis.map((api) => ({ name: api.name, url: api.url }));
      axios
        .post('/api/save-api', { apiUrls })
        .then(() => {
          this.showModal = false;
          Swal.fire('Success!', 'API saved.', 'success');
        })
        .catch((error) => {
          console.error(error);
          Swal.fire('Error!', 'An error occurred while saving the API.', 'error');
        });
    },
    handleButtonClick() {
      this.fetchCustomersFromApi();
      this.loading = !this.loading;
    },
    handleCustomerUpdated() {
      this.fetchCustomers(this.page, this.perPage);
      this.showCustomerFormEditDialog = false;
    },
    handleCustomerCreated() {
      this.fetchCustomers(this.page, this.perPage);
      this.showCustomerFormDialog = false;
    },
    fetchApiUrls() {
      axios
        .get('/api/fetch-api')
        .then((response) => {
          this.apis = response.data;
        })
        .catch((error) => {
          console.error(error);
          Swal.fire('Error!', 'An error occurred while getting a list of API customers.', 'error');
        });
    },
    fetchCustomersFromApi() {
      axios
        .get('/api/fetch-customers')
        .then((response) => {
          this.fetchCustomers();
          Swal.fire('Success!', '', 'success');
        })
        .catch((error) => {
          console.error(error);
          Swal.fire('Error!', 'An error occurred while loading customer data.', 'error');
        });
    },
    showCustomerForm() {
      this.showCustomerFormDialog = true;
    },
    showCustomerFormEdit(customer) {
      this.selectedCustomer = customer;
      this.showCustomerFormEditDialog = true;
    },
    showCustomerDetails(customer) {
      this.selectedCustomer = customer;
      this.showCustomerDetailsDialog = true;
    },
    fetchCustomers() {
      axios
        .get('/api/customers')
        .then((response) => {
          this.customers = response.data;
          this.pagination.total = this.customers.length;
          this.pagination.per_page = this.perPage;
          this.pagination.current_page = this.page;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    nextPage() {
      if (this.page < this.totalPages) {
        this.page++;
        this.fetchCustomers();
      }
    },
    previousPage() {
      if (this.page > 1) {
        this.page--;
        this.fetchCustomers();
      }
    },
    deleteCustomer(customerId) {
      Swal.fire({
        title: 'Delete Customer',
        text: 'Are you sure you want to delete this customer?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete(`/api/customers/${customerId}`)
            .then(() => {
              this.fetchCustomers(this.page, this.perPage);
              Swal.fire('Deleted!', 'The customer has been deleted.', 'success');
            })
            .catch((error) => {
              console.error(error);
              Swal.fire('Error!', 'An error occurred while deleting the customer.', 'error');
            });
        }
      });
    }
  }
};
</script>
<style scoped>
.selectBox {
  margin: 10px;
}
</style>