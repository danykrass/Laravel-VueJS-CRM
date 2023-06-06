<template>
  <v-sheet class="mx-auto">
    <v-form ref="form" fast-fail @submit.prevent="createCustomer">
      <v-text-field
        variant="outlined"
        v-model="customer.name"
        label="Full Name"
        :counter="100"
        placeholder="Enter Full Name"
        required
      ></v-text-field>

      <v-text-field
        variant="outlined"
        v-model="customer.email"
        label="E-mail"
        :counter="100"
        placeholder="Enter E-mail"
        required
      ></v-text-field>

      <div v-for="(field, index) in contactInformation" :key="index">
        <v-text-field
          variant="outlined"
          v-model="field.value"
          :label="field.label"
          :placeholder="field.label"
          :counter="100"
        ></v-text-field>
        <v-btn color="error" @click="removeField(index)">
          Delete {{ field.label }}
        </v-btn>
      </div>

      <div v-if="isAddingField">
        <v-text-field
          v-if="!isAddingValue"
          variant="outlined"
          v-model="newField.label"
          label="Enter Field Label"
          placeholder="Enter the field label"
        ></v-text-field>
        <v-text-field
          v-if="isAddingValue"
          variant="outlined"
          v-model="newField.value"
          :label="newField.label"
          placeholder="Enter Field Value"
        ></v-text-field>
        <v-btn color="primary" @click="isAddingValue = true" v-if="isAddingField && !isAddingValue">Next</v-btn>
        <v-btn color="primary" @click="addFieldFinish" v-if="isAddingField && isAddingValue">Finish</v-btn>
      </div>

      <v-btn v-if="!isAddingField" color="primary" @click="addField">Add Fields</v-btn>

      <v-btn color="success" block size="large" class="btn-default" type="submit">Create</v-btn>
    </v-form>
  </v-sheet>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      customer: {
        name: '',
        email: '',
      },
      contactInformation: [],
      isAddingField: false,
      isAddingValue: false,
      newField: {
        label: '',
        value: '',
      },
    };
  },
  methods: {
    createCustomer() {
      const formattedContactInformation = this.contactInformation.reduce((result, field) => {
        result[field.label] = field.value;
        return result;
      }, {});

      const customerData = {
        ...this.customer,
        contact_information: JSON.stringify(formattedContactInformation),
      };

      axios
        .post('/api/customers', customerData)
        .then(response => {
          console.log(response.data);
          this.customer = {
            name: '',
            email: '',
          };
          this.contactInformation = [];
          Swal.fire('Success!', 'Customer successfully added.', 'success');
          this.$emit('customer-created');
        })
        .catch(error => {
          console.error(error);
        });
    },
    addField() {
      this.isAddingField = true;
      this.isAddingValue = false;
      this.newField = {
        label: '',
        value: '',
      };
    },
    addFieldFinish() {
      if (this.newField.label && this.newField.value) {
        this.contactInformation.push({ ...this.newField });
        this.isAddingField = false;
        this.isAddingValue = false;
        this.newField = {
          label: '',
          value: '',
        };
      }
    },
    removeField(index) {
      this.contactInformation.splice(index, 1);
    },
  },
};
</script>
