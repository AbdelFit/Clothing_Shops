<template>
  <b-form @submit.prevent="authenticate" @reset="onReset" class="form-center">
    <h3>Login</h3>
    <h6 class="text-danger">{{ error }}</h6>
    <b-form-group label="Email address:" label-for="email">
      <b-form-input id="email" v-model="form.email" type="email" placeholder="Enter email"></b-form-input>
    </b-form-group>
    <b-form-group label="Your Name:" label-for="password">
      <b-form-input
        id="password"
        v-model="form.password"
        type="password"
        placeholder="Enter password"
      ></b-form-input>
    </b-form-group>
    <button type="submit" class="btn btn-primary" :disabled="loading">Submit</button>
    <button type="reset" class="btn btn-danger">Reset</button>
  </b-form>
</template>
<script>
import { login } from "../../helpers/api.js";
export default {
  data() {
    return {
      form: {
        email: "",
        password: ""
      }
    };
  },
  computed: {
    error() {
      return this.$store.getters.authError;
    },
    loading() {
      return this.$store.getters.loading;
    }
  },
  methods: {
    authenticate() {
      this.$store.dispatch("init");
      this.$store.dispatch("login", this.$data.form);
    },
    onReset() {
      this.email = "";
      this.password = "";
    }
  }
};
</script>

<style>
.is_valid {
  border-color: red;
}

.form-center {
  margin: 0 auto;
  margin-top: 200px !important;
  margin-bottom: 200px !important;
  width: 35%;
  padding: 30px;
  box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.15);
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
  .form-center {
    width: 50%;
  }
}

@media only screen and (max-width: 767px) {
  .form-center {
    width: 90%;
  }
}
</style>
