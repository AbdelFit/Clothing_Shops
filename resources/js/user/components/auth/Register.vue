<template>
  <b-form @submit.prevent="Register" @reset="onReset" class="form-center">
    <h3>Register</h3>
    <b-form-group label="Name:" label-for="email">
      <b-form-input id="name" v-model="form.name" type="text" placeholder="Enter name"></b-form-input>
      <span class="text-danger" v-if="error.name">{{ error.name[0] }}</span>
    </b-form-group>
    <b-form-group label="Email address:" label-for="email">
      <b-form-input id="email" v-model="form.email" type="email" placeholder="Enter email"></b-form-input>
      <span class="text-danger" v-if="error.email">{{ error.email[0] }}</span>
    </b-form-group>
    <b-form-group label="Password:" label-for="password">
      <b-form-input
        id="password"
        v-model="form.password"
        type="password"
        placeholder="Enter password"
      ></b-form-input>
      <span class="text-danger" v-if="error.password">{{ error.password[0] }}</span>
    </b-form-group>
    <button type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-danger" @click="onReset">Reset</button>
  </b-form>
</template>
<script>
export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: ""
      }
    };
  },
  computed: {
    error() {
      return this.$store.getters.registerError;
    }
  },
  methods: {
    Register() {
      this.$store.dispatch("init");
      this.$store.dispatch("register", this.$data.form);
    },
    onReset() {
      this.form = {
        name: "",
        email: "",
        password: ""
      };
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
