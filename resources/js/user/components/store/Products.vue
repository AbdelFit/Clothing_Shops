<template>
  <!-- Single Product -->
  <div class="row">
    <div class="col-12 col-sm-6 col-lg-4" v-for="product in products" :key="product.id">
      <div class="single-product-wrapper">
        <!-- Product Image -->
        <div class="product-img">
          <div v-for="(img, index) in product.images" :key="img.id">
            <div v-if="index === 0">
              <img :src="`/storage/images_product/${img.file}`" alt>
            </div>
            <!-- Hover Thumb -->
            <div v-else-if="index === 1">
              <img class="hover-img" :src="`/storage/images_product/${img.file}`" alt>
            </div>
            <!-- Product Badge -->
            <div class="product-badge offer-badge" v-if="product.old_price">
              <span>{{ product.percentage_off }}%</span>
            </div>
            <!-- Favourite -->
            <div class="product-favourite">
              <a class="favme fa fa-heart" @click="wishlist(product.id)"></a>
            </div>
          </div>
        </div>
        <!-- Product Description -->
        <div class="product-description">
          <span>topshop</span>
          <router-link :to="`/shop/single-product/${product.id}`">
            <h6>{{ product.name }}</h6>
          </router-link>
          <p class="product-price">
            <span class="old-price">
              {{
              currency_info.currency
              }} {{ (product.old_price * currency_info.rate).toFixed(0)}}
            </span>
            {{
            currency_info.currency
            }} {{ (product.price * currency_info.rate).toFixed(0)}}
          </p>
          <!-- Hover Content -->
          <div class="hover-content">
            <!-- Add to Cart -->
            <div class="add-to-cart-btn">
              <button
                @click="addToCart(product.name, product.price, product.images[0].file, product.id)"
                class="btn essence-btn"
              >
                Add
                to Cart
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  name: "products",
  computed: {
    ...mapGetters(["products", "currency_info"])
  },
  data() {
    return {
      wish_user_id: false
    };
  },
  methods: {
    addToCart(name, price, img, id) {
      this.$store.commit("addToCart", {
        name,
        price,
        img,
        id,
        count: 1
      });
      this.$toaster.success(`You have successfully added ${name}`);
    },
    heartClass(wishlist_id) {
      return {
        active: wishlist_id === this.$store.state.auth.currentUser.id
      };
    },
    wishlist(id) {
      axios
        .post(`/api/wishlist/${id}`, id)
        .then(res => {
          this.$toaster.success(
            "You have successfully added this item to your wishlist"
          );
        })
        .catch(err => {
          if (err.response.status === 422)
            this.$toaster.error("This item is already in your wishlist");
        });
    }
  }
};
</script>
