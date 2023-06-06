<template>
  <div>
    <form @submit.prevent="updateCustomer">
      <v-text-field
        variant="outlined"
        v-model="customer.name"
        label="Full Name"
        required
      ></v-text-field>
      <v-text-field
        variant="outlined"
        v-model="customer.email"
        label="E-mail"
        required
      ></v-text-field>

      <div v-for="(value, key) in contactInformation" :key="key">
        <v-text-field
          variant="outlined"
          v-model="contactInformation[key]"
          :label="`${key}`"
          :placeholder="`${key}`"
        ></v-text-field>
        <v-btn color="error" @click="removeField(key)">
          Delete {{ key }}
        </v-btn>
      </div>

      <div v-if="showAddField">
        <v-text-field
          variant="outlined"
          v-model="newFieldName"
          label="Enter Field Label"
          placeholder="Enter the field label"
        ></v-text-field>
        <v-btn color="primary" @click="addFieldNext">Next</v-btn>
      </div>

      <div v-if="showAddFieldValue">
        <v-text-field
          variant="outlined"
          v-model="newFieldValue"
          label="Enter Field Value"
          placeholder="Enter Field Value"
        ></v-text-field>
        <v-btn color="primary" @click="addFieldFinish">Finish</v-btn>
      </div>

      <v-btn v-if="!showAddField && !showAddFieldValue" color="primary" @click="addField">Add Field</v-btn>

      <v-btn color="success" block size="large" class="btn-default" type="submit">Update</v-btn>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  props: {
    customer: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      contactInformation: {},
      showAddField: false,
      showAddFieldValue: false,
      newFieldName: '',
      newFieldValue: '',
    };
  },
  mounted() {
    this.parseContactInformation();
  },
  methods: {
    updateCustomer() {
      const updatedCustomer = {
        name: this.customer.name,
        email: this.customer.email,
        contact_information: JSON.stringify(this.contactInformation),
      };

      axios
        .put(`/api/customers/${this.customer.id}`, updatedCustomer)
        .then(response => {
          console.log(response.data);
          Swal.fire('Success!', 'Data successfully updated.', 'success');
          this.$emit('customer-updated');
        })
        .catch(error => {
          console.error(error);
          Swal.fire('Error!', 'Something went wrong!', 'error');
        });
    },
    parseContactInformation() {
      if (this.customer.contact_information) {
        try {
          this.contactInformation = JSON.parse(this.customer.contact_information);
        } catch (error) {
          console.error(error);
        }
      }
    },
    addField() {
      this.showAddField = true;
      this.showAddFieldValue = false;
      this.newFieldName = '';
      this.newFieldValue = '';
    },
    addFieldNext() {
      if (this.newFieldName) {
        this.showAddField = false;
        this.showAddFieldValue = true;
      }
    },
    addFieldFinish() {
      if (this.newFieldValue) {
        this.contactInformation[this.newFieldName] = this.newFieldValue;
        this.showAddField = false;
        this.showAddFieldValue = false;
        this.newFieldName = '';
        this.newFieldValue = '';
      }
    },
    removeField(key) {
      delete this.contactInformation[key];
    },
  },
};
</script>
