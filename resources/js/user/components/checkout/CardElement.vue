<template>
    <div>
        <div id="card-errors" role="alert" class="text-danger" v-text="errorMessage"></div>
        <card class='stripe-card' :class='{ complete }' stripe='pk_test_1qNBK7rnrRoqQHUVZaBLwwm5' :options='stripeOptions'
            @change='change($event)' />
    </div>
</template>

<script>
import { Card, createToken } from "vue-stripe-elements-plus";
export default {
  components: {
    Card
  },
  data() {
    return {
      complete: false,
      errorMessage: "",
      stripeOptions: {}
    };
  },

  methods: {
    change(event) {
      this.errorMessage = event.error ? event.error.message : "";
    }
  }
};
</script>
<style>
.stripe-card {
  width: 100%;
  border: 1px solid #ced4da;
  padding: 13px;
}

.stripe-card.complete {
  border-color: green;
}
</style>
