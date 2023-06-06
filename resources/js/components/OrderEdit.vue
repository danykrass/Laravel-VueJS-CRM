<template>
  <div>
    <v-form @submit.prevent="updateOrder">
      <v-text-field
        variant="outlined"
        v-model="order.details"
        label="Details"
        required
      ></v-text-field>
      <div>
        <v-select
          v-model="order.status"
          label="Status"
          :items="statusOptions"
          variant="outlined"
          required
        ></v-select>
      </div>
      <VueDatePicker
        v-model="order.due_date"
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
        <v-btn color="success" block size="large" class="btn-default" type="submit">Update</v-btn>
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
  props: {
    order: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      files: [],
      statusOptions: ['pending', 'completed', 'cancelled'],
    };
  },
  methods: {
    showOrderFormEdit(order) {
    this.selectedOrder = order;
    this.showOrderFormEditDialog = true;
    },
    updateOrder() {
      const formData = new FormData();
      formData.append('_method', 'put');
      formData.append('details', this.order.details);
      formData.append('status', this.order.status);
      formData.append('due_date', this.formatDate(this.order.due_date));

      if (this.files && this.files.length > 0) {
        for (let i = 0; i < this.files.length; i++) {
          formData.append('files[]', this.files[i]);
        }
      }

      axios
        .post(`/api/orders/${this.order.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
        .then(response => {
          console.log(response.data);
          Swal.fire('Success!', 'Order successfully updated.', 'success');
          this.$emit('customer-updated');
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
  },
};
</script>