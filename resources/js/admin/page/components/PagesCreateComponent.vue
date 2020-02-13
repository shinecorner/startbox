<template>
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form class="form" autocomplete="off" @submit.prevent="save" method="post" novalidate>
                    <div class="form-body">
                        <h4 class="form-section"><i class="feather icon-file-text"></i> Page Info</h4>
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input v-model="page.title" type="text" id="title" class="form-control"
                                        v-bind:class="{'is-invalid' : error.title}" name="title">
                                    <span v-show="error.title"
                                        class="message-error"><b>{{error_message.title}}</b></span>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Content</label>
                                    <div id="full-container">
                                      <div class="editor"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions text-right">
                        <button @click="$router.push({ name: 'pages_list'})" type="reset" class="btn btn-warning mr-1">
                            <i class="feather icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <!-- <i class="fa fa-check-square-o"></i> -->
                            <i
                                v-bind:class="{'fa fa-circle-o-notch fa-spin fa-fw' : loading, 'fa fa-check-square-o': !loading}"></i>
                            {{page.id > 0 ? 'Update' : 'Save'}}
                        </button>
                        <!-- <button type="submit" class="btn btn-lg btn-success mb-1">
                                    <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                                    Light Layout
                                </button> -->
                    </div>
                </form>
                <div v-if="page.id > 0" class="row">
                    <div class="col-12 text-right">
                        <button @click="remove" type="button" class="btn btn-danger">
                            <i class="fa fa-remove"></i>
                            Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import PageServices from '../services/page-services.js';
export default {
  mixins: [PageServices],
  props: [],
  data() {
    return {
        page: {
          id: '',
          title: '',
          slug: '',
          content: ''
        },
        Helpers: Helpers,
        error: {
            title: false
        },
        error_message: {
            title: ''
        },
        loading: false
    };
  },
  mounted() {
    var fullEditor = new Quill("#full-container .editor", {
      bounds: "#full-container .editor",
      modules: {
        formula: true,
        syntax: true,
        toolbar: [
          [
            {
              font: []
            },
            {
              size: []
            }
          ],
          ["bold", "italic", "underline", "strike"],
          [
            {
              color: []
            },
            {
              background: []
            }
          ],
          [
            {
              script: "super"
            },
            {
              script: "sub"
            }
          ],
          [
            {
              header: "1"
            },
            {
              header: "2"
            },
            "blockquote",
            "code-block"
          ],
          [
            {
              list: "ordered"
            },
            {
              list: "bullet"
            },
            {
              indent: "-1"
            },
            {
              indent: "+1"
            }
          ],
          [
            "direction",
            {
              align: []
            }
          ],
          ["link", "image", "video", "formula"],
          ["clean"]
        ]
      },
      theme: "snow"
    });
    Helpers.unBlockPage();
  },
  methods: {
    save() {
        var fullEditor = document.querySelector('#full-container .editor');
        var pageContent = fullEditor.children[0].innerHTML;
        this.page.content = pageContent;
        if (this.page.title) {
            if (this.page.id > 0) {
                this.updatePageCall(this.page.id, this.page, this.createPageCallback);
            } else {
                this.createPageCall(this.page, this.createPageCallback);
            }
        } else {
            if (!this.page.title) {
                this.error.title = true;
                this.error_message.title = 'Title is required';
            }
        }
    },
    createPageCallback(response) {
        $.LoadingOverlay("hide");
        if (response.code == 200) {
            this.$router.push({ name: 'pages_list' });
        } else {
            if (Helpers.isAssoc(response.errors)) {
                for (var key in response.errors) {
                    toastr.error(response.errors[key][0], 'Error');
                }
            } else {
                toastr.error(response.errors[0], 'Error');
            }
        }
    },
    getPageCallback(response) {
        $.LoadingOverlay("hide");
        if (response.code == 200) {
            this.page = response.data;
            const fullEditor = document.querySelector('#full-container .editor');
            fullEditor.children[0].innerHTML = this.page.content;
        } else {
            if (Helpers.isAssoc(response.errors)) {
                for (var key in response.errors) {
                    toastr.error(response.errors[key][0], 'Error');
                }
            } else {
                toastr.error(response.errors[0], 'Error');
            }
        }
    },
    remove() {
        var self = this;
        swal.fire({
            title: "Are you sure?",
            /* text: "You won't be able to revert this!", */
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: !1
        }).then((function (t) {
            if (t.value) {
                if (self.page.id > 0) {
                    $.LoadingOverlay("show");
                    self.removePageCall(self.page.id, self.removePageCallback);
                }
            }
        }));
    },
    removePageCallback(response) {
        $.LoadingOverlay("hide");
        if (response.code == 200) {
            this.$router.push({ name: 'pages_list' });
        } else {
            if (Helpers.isAssoc(response.errors)) {
                for (var key in response.errors) {
                    toastr.error(response.errors[key][0], 'Error');
                }
            } else {
                toastr.error(response.errors[0], 'Error');
            }
        }
    },
  },
  watch: {
      'page.title'(val) {
          if (val) {
              this.error.title = false;
              this.error_message.title = '';
          }
      }
  },
  created() {
      if (this.$route.params.id > 0) {
          $.LoadingOverlay("show");
          this.getPageCall(this.$route.params.id, this.getPageCallback);
      }
  }
};
</script>
<style lang="scss">
#full-container {
  .editor {
    min-height: 300px;
  }
}
.message-error {
    float: right;
    color: red;
    font-size: 12px;
    padding-top: 5px;
    padding-top: 5px;
    padding-bottom: 10px;
}
</style>
