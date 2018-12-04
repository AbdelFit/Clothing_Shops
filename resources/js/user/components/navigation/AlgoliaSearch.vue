<template>
  <div class="aa-input-container" id="aa-input-container">
    <input
      type="search"
      id="aa-search-input"
      class="aa-input-search"
      name="search"
      placeholder="Search..."
      autocomplete="off"
    >
  </div>
</template>
<style lang="scss">
.aa-input-container {
  background-color: #ffffff !important;
}

.aa-input-search {
  width: 100%;
  padding: 10px;
  border: 1px solid #bdbdbd;
  border-radius: 20px;
}
.algolia-result {
  display: flex;
  background-color: #ffffff;
  padding: 8px;
  width: 500px;
}
.algolia-thumb {
  width: 60px;
  height: 60px;
}
</style>
<script>
export default {
  props: {
    appId: {
      type: String,
      required: true
    },
    apiKey: {
      type: String,
      required: true
    },
    indexName: {
      type: String,
      required: true
    }
  },
  mounted() {
    var client = algoliasearch(this.appId, this.apiKey);
    var index = client.initIndex(this.indexName);
    var enterPressed = false;
    //initialize autocomplete on search input (ID selector must match)
    autocomplete(
      "#aa-search-input",
      { hint: false },
      {
        source: autocomplete.sources.hits(index, { hitsPerPage: 10 }),
        //value to be displayed in input control after user's suggestion selection
        displayKey: "name",
        //hash of templates used when rendering dataset
        templates: {
          //'suggestion' templating function used to render a single suggestion
          suggestion: function(suggestion) {
            const markup = `
                                <div class="algolia-result">
                                  <div>
                                    <span>
                                        <img src="${
                                          window.location.origin
                                        }/storage/images_product/${
              suggestion.images[0]
            }" alt="img" class="algolia-thumb">
                                    </span>
                                  </div>
                                  <div >
                                    <div>${suggestion.name}</div>
                                    <div>$${suggestion.price.toFixed(2)}</div>
                                  </div>
                                </div>
                            `;
            return markup;
          },
          empty: function(result) {
            return (
              'Sorry, we did not find any results for "' + result.query + '"'
            );
          }
        }
      }
    )
      .on("autocomplete:selected", function(event, suggestion, dataset) {
        window.location.href =
          window.location.origin + "/shop/single-product/" + suggestion.id;
        enterPressed = true;
      })
      .on("keyup", function(event) {
        if (event.keyCode == 13 && !enterPressed) {
          window.location.href =
            window.location.origin +
            "/search-algolia?q=" +
            document.getElementById("aa-search-input").value;
        }
      });
  }
};
</script>
