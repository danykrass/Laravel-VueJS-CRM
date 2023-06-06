<template>
  <v-theme-provider theme="dark" with-background style="border-radius: 5px; min-height: 100vh;">
    <v-container>
      <v-sheet class="pa-4 ma-2">
          <div id="root">
              <router-link to="/cpanel/customers"><v-btn color="purple-lighten-1">Customers</v-btn></router-link>
              <router-link to="/cpanel/orders"><v-btn color="purple-lighten-1">Orders</v-btn></router-link>
              <router-view></router-view>
          </div>
        </v-sheet>
    </v-container>
  </v-theme-provider>
  </template>
  
  <script>
  export default {
    name: 'App',
  };
  </script>
  
  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  html, body {
    font-family: Arial, Helvetica, sans-serif;
    font-weight: normal;
  }
  main {
    background: #F2A6FA;
    background: linear-gradient(135deg, #F2A6FA, #8E8D57);
  }
  .pagination{
    background: inherit;
  }
   .v-btn.v-btn--density-default {
    margin: 15px 5px;
    font-size: 12px;
  }
  .v-input {
    height: 50px;
  }
  .v-input{
    margin-bottom: 25px;
  }
  .v-form button[type="submit"] {
    margin: 0;
    padding: 0;
    height: 50px;
  }
  .v-card-text div > button[type="button"] {
    margin: 0 0 20px 0;
    line-height: 0;
  }
  .btn-default {
    margin: 25px auto !important;
    font-size: 16px;
  }
  .bg-danger {
    color:  #fff !important;
  }
  .selectBox {
    margin: 25px 0;
  }
  .selectBox select{
    background: #212121;
    border: 1px solid;
    text-align: center;
    border-radius: 2px;
    margin-left: 5px;
  }
  nav {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }
  .dp__theme_dark {
   --dp-background-color: #212121;
   --dp-text-color: #ffffff;
   --dp-hover-color: #484848;
   --dp-hover-text-color: #ffffff;
   --dp-hover-icon-color: #959595;
   --dp-primary-color: #005cb2;
   --dp-primary-text-color: #ffffff;
   --dp-secondary-color: #a9a9a9;
   --dp-border-color: #ffffff69;
   --dp-menu-border-color: #2d2d2d;
   --dp-border-color-hover: #ffffff;
   --dp-disabled-color: #737373;
   --dp-scroll-bar-background: #212121;
   --dp-scroll-bar-color: #484848;
   --dp-success-color: #00701a;
   --dp-success-color-disabled: #428f59;
   --dp-icon-color: #959595;
   --dp-danger-color: #e53935;
   --dp-highlight-color: rgba(0, 92, 178, 0.2);
   --dp-height: 50px;
}
.dp__input_wrap input {
  height: 55px;
  margin: 25px 0;
  border-color: #ffffff69;
}
.swal2-backdrop-show {
  z-index: 9999;
}
.due {
  white-space: pre-wrap;
  word-wrap: break-word;
  height: 100px;
}
.v-theme--dark {
    color-scheme: dark;
    --v-theme-background: 33,33,33 !important;
    --v-theme-background-overlay-multiplier: 1;
    --v-theme-surface: 33,33,33;
    --v-theme-surface-overlay-multiplier: 1;
    --v-theme-surface-variant: 189,189,189;
    --v-theme-surface-variant-overlay-multiplier: 2;
    --v-theme-on-surface-variant: 66,66,66;
    --v-theme-primary: 187,134,252;
    --v-theme-primary-overlay-multiplier: 2;
    --v-theme-primary-darken-1: 55,0,179;
    --v-theme-primary-darken-1-overlay-multiplier: 1;
    --v-theme-secondary: 3,218,197;
    --v-theme-secondary-overlay-multiplier: 2;
    --v-theme-secondary-darken-1: 3,218,197;
    --v-theme-secondary-darken-1-overlay-multiplier: 2;
    --v-theme-error: 207,102,121;
    --v-theme-error-overlay-multiplier: 2;
    --v-theme-info: 33,150,243;
    --v-theme-info-overlay-multiplier: 2;
    --v-theme-success: 76,175,80;
    --v-theme-success-overlay-multiplier: 2;
    --v-theme-warning: 251,140,0;
    --v-theme-warning-overlay-multiplier: 2;
    --v-theme-on-background: 255,255,255;
    --v-theme-on-surface: 255,255,255;
    --v-theme-on-primary: 255,255,255;
    --v-theme-on-primary-darken-1: 255,255,255;
    --v-theme-on-secondary: 0,0,0;
    --v-theme-on-secondary-darken-1: 0,0,0;
    --v-theme-on-error: 255,255,255;
    --v-theme-on-info: 255,255,255;
    --v-theme-on-success: 255,255,255;
    --v-theme-on-warning: 255,255,255;
    --v-border-color: 255, 255, 255;
    --v-border-opacity: 0.12;
    --v-high-emphasis-opacity: 1;
    --v-medium-emphasis-opacity: 0.7;
    --v-disabled-opacity: 0.5;
    --v-idle-opacity: 0.1;
    --v-hover-opacity: 0.04;
    --v-focus-opacity: 0.12;
    --v-selected-opacity: 0.08;
    --v-activated-opacity: 0.12;
    --v-pressed-opacity: 0.16;
    --v-dragged-opacity: 0.08;
    --v-theme-kbd: 33, 37, 41;
    --v-theme-on-kbd: 255, 255, 255;
    --v-theme-code: 52, 52, 52;
    --v-theme-on-code: 204, 204, 204;
}
.page-link, .page-link.disabled, .disabled > .page-link {
  border-color: transparent;
  background: #272727;
  color: #fff;
  border: none;
}
.page-link.active {
  background: #ab47bc;
  border: none;
}
.page-link:hover, .page-link:focus{
  background: #ab47bc;
  border: none;
  color: #fff;
  outline: none;
}
  </style>
  