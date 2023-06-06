<template>
  <div>
    <v-form ref="form" @submit.prevent="createOrder">
      <v-select
        variant="outlined"
        v-model="customer_id"
        :items="users"
        label="Select customer"
        required
      ></v-select>
      <v-text-field
        variant="outlined"
        v-model="details"
        label="Details"
        required
      ></v-text-field>
      <div>
        <v-select
          v-model="status"
          label="Status"
          :items="statusOptions"
          variant="outlined"
          required
        ></v-select>
      </div>

      <VueDatePicker
        v-model="due_date"
        :enable-time-picker="true"
        :dark="true"
        placeholder="Due Date"
        teleport-center
      ></VueDatePicker>

      <v-file-input
        variant="outlined"
        multiple
        label="File input"
        ref="files"
        @change="handleFilesUpload"
      ></v-file-input>

      <div>
        <v-btn
          color="success"
          block
          size="large"
          class="btn-default"
          type="submit"
          >Create Order</v-btn
        >
      </div>
    </v-form>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
  components: { VueDatePicker },
  data() {
    return {
      details: '',
      status: '',
      due_date: '',
      statusOptions: ['pending', 'completed', 'cancelled'],
      files: null,
      customer_name: null,
      customer_id: null,
      users: [],
      customers: []
    };
  },
  mounted() {
    this.fetchUsers();
  },
  watch: {
    customer_name: {
      handler: 'getCustomerId',
      immediate: true,
    },
  },
  methods: {
    fetchUsers() {
      axios
        .get('https://go-trs.online/api/customers')
        .then(response => {
          this.users = response.data.map(user => user.name);
          this.customers = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    createOrder() {
      const formData = new FormData();
      formData.append('customer_id', this.customer_id);
      formData.append('details', this.details);
      formData.append('status', this.status);
      formData.append('due_date', this.formatDate(this.due_date));

      if (this.files && this.files.length > 0) {
        for (let i = 0; i < this.files.length; i++) {
          formData.append('files[]', this.files[i]);
        }
      }
      axios
      .post('/api/orders', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      .then(response => {
        console.log(response.data);
        Swal.fire('Success!', 'Order successfully created.', 'success');
        this.$emit('create-order');
      })
      .catch(error => {
        console.error(error);
        Swal.fire('Error!', 'Something went wrong!', 'error');
      });
    },
    handleFilesUpload() {
      this.files = this.$refs.files.files;
    },
    formatDate(date) {
      if (date instanceof Date) {
        return date.toISOString();
      }
      return null;
    },
    getCustomerId() {
      if (this.customer_name) {
        const selectedUser = this.users.find(user => user.name === this.customer_name);
      if (selectedUser) {
        this.customer_id = selectedUser.id;
      } else {
        this.customer_id = null;
      }
      console.log(this.customer_id);
      } else {
        this.customer_id = null;
      }
    },
  },
};
</script>
