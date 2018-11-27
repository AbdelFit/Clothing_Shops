<template>
  <div>
    <!-- ##### Breadcumb Area Start ##### -->
    <div
      class="breadcumb_area breadcumb-style-two bg-img"
      style="background-image: url(img/bg-img/breadcumb2.jpg);"
    >
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12">
            <div class="page-title text-center">
              <h2>Fashion Blog</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->
    <!-- ##### Blog Wrapper Area Start ##### -->
    <div class="blog-wrapper section-padding-80">
      <div class="container">
        <div class="row">
          <!-- Single Blog Area -->
          <div class="col-12 col-lg-6" v-for="blog in blogs" :key="blog.id">
            <div class="single-blog-area mb-50">
              <img :src="`/storage/images_feature_image/${blog.feature_image}`" alt>
              <!-- Post Title -->
              <div class="post-title">
                <router-link :to="`/blog/${blog.id}`">{{blog.title}}</router-link>
              </div>
              <!-- Hover Content -->
              <div class="hover-content">
                <!-- Post Title -->
                <router-link :to="`/blog/${blog.id}`">{{blog.title}}</router-link>
                <router-link :to="`/blog/${blog.id}`">
                  Continue reading
                  <i class="fa fa-angle-right"></i>
                </router-link>
              </div>
            </div>
          </div>
        </div>
        <nav class="center-pagination">
          <ul class="pagination">
            <li v-bind:class="{ disabled: !pagination.first_link} " class="page-item">
              <a href="#" class="page-link" @click="fetch(pagination.first_link)">&laquo;</a>
            </li>
            <li v-bind:class="{ disabled: !pagination.prev_link} " class="page-item">
              <a href="#" class="page-link" @click="fetch(pagination.prev_link)">&lt;</a>
            </li>
            <li
              v-for="n in pagination.last_page"
              v-bind:key="n"
              v-bind:class="{ active: pagination.current_page == n} "
              class="page-item"
            >
              <a href="#" class="page-link" @click="fetch(pagination.path_page + n)">{{ n }}</a>
            </li>
            <li v-bind:class="{ disabled: !pagination.next_link} " class="page-item">
              <a href="#" class="page-link" @click="fetch(pagination.next_link)">&gt;</a>
            </li>
            <li v-bind:class="{ disabled: !pagination.last_link} " class="page-item">
              <a href="#" class="page-link" @click="fetch(pagination.last_link)">&raquo;</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      blogs: [],
      pagination: ""
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch(pagi) {
      (this.load = 1), (pagi = pagi || "api/blogs");
      axios
        .get(pagi, {
          params: {
            q: this.q
          }
        })
        .then(res => {
          this.blogs = res.data.blogs.data;
          this.pagination = {
            current_page: res.data.blogs.current_page,
            last_page: res.data.blogs.last_page,
            from_page: res.data.blogs.from,
            to_page: res.data.blogs.to,
            total_page: res.data.blogs.total,
            path_page: res.data.blogs.path + "?page=",
            first_link: res.data.blogs.first_page_url,
            last_link: res.data.blogs.last_page_url,
            prev_link: res.data.blogs.prev_page_url,
            next_link: res.data.blogs.next_page_url
          };
        });
    }
  }
};
</script>
