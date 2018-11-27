<template>
  <div class="card container padding">
    <div id="blog" v-if="complete != '1'">
      <div class="row">
        <div class="col-12">
          <div class="form-group">
            <label for="title">Title</label>
            <input
              name="title"
              type="text"
              id="title"
              class="form-control"
              v-model="blog.title"
              v-bind:class="{ is_invalid: error.title }"
            >
            <small class="text-danger" v-if="error.title">{{error.title[0]}}</small>
          </div>
        </div>
        <div class="col-12">
          <vue-editor
            useCustomImageHandler
            @imageAdded="handleImageAdded"
            v-model="blog.content"
            v-bind:class="{ is_invalid: error.content }"
          ></vue-editor>
          <small class="text-danger" v-if="error.content">{{ error.content[0]}}</small>
          <br>
        </div>
        <div class="col-12">
          <br>
          <div class="form-group">
            <input
              id="upload-file"
              type="file"
              multiple
              class="form-control"
              @change="fileChange"
              v-bind:class="{ is_invalid: error.feature_image }"
            >
            <small class="text-danger" v-if="error.feature_image">{{ error.feature_image[0]}}</small>
            <br>
          </div>
        </div>
        <div class="col-12">
          <div class="center-button">
            <div v-if="loading != '1'">
              <button type="submit" class="btn btn-success button-size" @click="saveBlog()">Upload</button>
            </div>

            <div v-else>
              <button class="btn btn-default button-size">
                <div class="lds-circle"></div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>You have successfully {{ action }} your blog!</div>
  </div>
</template>

<script>
import { VueEditor } from "vue2-editor";

export default {
  components: {
    VueEditor
  },
  data() {
    return {
      blog: {
        title: "",
        content: ""
      },
      attachments: "",
      loading: 0,
      complete: 0,
      error: "",
      action: "Create",
      initializeURL: `/api/blogs`
    };
  },
  created() {
    if (this.$route.meta.mode === "edit") {
      this.storeURL = `/api/blogs/${this.$route.params.id}`;
      this.initializeURL = `/api/blogs/${this.$route.params.id}?_method=PUT`;
      this.action = "Update";
      axios.get(this.storeURL).then(res => {
        this.blog = res.data.blog;
      });
    }
  },
  methods: {
    fileChange(e) {
      let selectedFiles = e.target.files[0];
      this.attachments = selectedFiles;
    },
    handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
      let formData = new FormData();
      formData.append("image", file);
      axios
        .post("/api/blogs/image_upload", formData)
        .then(result => {
          let url = result.data.url;
          Editor.insertEmbed(cursorLocation, "image", url);
          resetUploader();
        })
        .catch(err => {
          console.log(err);
        });
    },
    saveBlog() {
      console.log(this.blog.content);
      this.loading = 1;
      const myForm = document.getElementById("myForm");
      let formData = new FormData(myForm);
      formData.append("feature_image", this.attachments);
      formData.append("content", this.blog.content);
      formData.append("title", this.blog.title);
      axios
        .post(this.initializeURL, formData)
        .then(res => {
          this.complete = 1;
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.loading = 0;
            this.error = error.response.data.errors;
          }
        });
    }
  }
};
</script>
