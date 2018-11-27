<template>
  <div class="container">
    <img :src="`/storage/images_feature_image/${blog.feature_image}`" class="full-width">
    <h1 class="text-cs">{{blog.title}}</h1>
    <div v-html="blog.content"></div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      blog: ""
    };
  },
  created() {
    axios.get(`/api/blogs/${this.$route.params.id}`).then(response => {
      this.blog = response.data.blog;
    });
  }
};
</script>
<style lang="scss" scoped>
.text-cs {
  margin-top: 30px;
  margin-bottom: 30px;
  text-transform: capitalize;
  font-weight: 300;
}
.full-width {
  width: 100%;
}
</style>

