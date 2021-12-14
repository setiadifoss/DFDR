<template>
  <div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">
        Detail Uploaded File
        <span class="badge badge-warning" v-if="form.status == 'pending'">
          Pending
        </span>
        <span class="badge badge-success" v-if="form.status == 'Approved'">
          Approved
        </span>
        <span class="badge badge-danger" v-if="form.status == 'Reject'">
          Reject
        </span>
      </h1>
      <a
        @click="$router.go(-1)"
        class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"
        ><i class="fas fa-arrow-left fa-sm text-white-50"></i>&nbsp; Return</a
      >
      <!-- <a href="#" class="d-none d-sm-inline-block btn  btn-primary shadow-sm"
        ><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a
      > -->
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body" v-if="loading">
            <div class="text-center">
              <loading-component></loading-component>
            </div>
          </div>
          <div class="card-body" v-if="!loading">
            <form enctype="multipart/form-data">
              <div class="">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input
                        type="text"
                        class="form-control"
                        id="title"
                        v-model="form.title"
                        required
                        aria-describedby="titleHelp"
                        placeholder="Enter Title"
                      />
                      <small
                        id="titleHelp"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.title.required"
                        >Title is required</small
                      >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="category">Category</label>
                      <select
                        class="form-control"
                        id="category"
                        v-model="form.category"
                        aria-describedby="categoryHelp"
                      >
                        <option value="" selected disabled
                          >-- Select category --</option
                        >
                        <option
                          v-for="(cat, c) in categories"
                          :key="c"
                          :value="cat.id"
                          >{{ cat.category_name }}</option
                        >
                      </select>
                      <small
                        id="categoryHelp"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.category.required"
                        >Category is required</small
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="description">Description</label>
                      <vue-editor
                        v-model="form.description"
                      />
                      <small
                        id="descError"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.description.required"
                        >Description is required</small
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="publisher">Publisher</label>
                      <input
                        type="text"
                        class="form-control"
                        id="publisher"
                        v-model="form.publisher"
                        aria-describedby="publisherHelp"
                        placeholder="Enter publisher"
                      />
                      <small
                        id="publisherHelp"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.publisher.required"
                        >Publisher is required</small
                      >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="date">Date</label>
                      <input
                        type="date"
                        class="form-control"
                        id="date"
                        name="date"
                        v-model="form.date"
                        aria-describedby="dateError"
                        placeholder="Masukkan date"
                      />
                      <small
                        id="dateError"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.date.required"
                        >Date is required</small
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="language">Language</label>
                      <select
                        class="form-control"
                        id="language"
                        v-model="form.language"
                        aria-describedby="languageError"
                      >
                        <option value="" selected disabled
                          >Select language</option
                        >
                        <option
                          v-for="(lang, d) in languages"
                          :key="d"
                          :value="lang.id"
                          >{{ lang.language_name }}</option
                        >
                      </select>
                      <small
                        id="languageError"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.language.required"
                        >Language is required</small
                      >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="relation">Relation</label>
                      <input
                        type="text"
                        class="form-control"
                        id="relation"
                        v-model="form.relation"
                        aria-describedby="relationHelp"
                        placeholder="Enter relation"
                      />
                      <small
                        id="relationHelp"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.relation.required"
                        >Relation is required</small
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="right_management">Right Management</label>
                      <select
                        class="form-control"
                        id="right_management"
                        v-model="form.right_management"
                        aria-describedby="right_managementHelp"
                      >
                        <option value="Open">Open</option>
                        <option value="Close">Close</option>
                      </select>

                      <!-- <input
                        type="text"
                        class="form-control"
                        id="right_management"
                        v-model="form.right_management"
                        aria-describedby="right_managementHelp"
                        placeholder="Enter Right Management"
                      /> -->
                      <small
                        id="right_managementHelp"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.right_management.required"
                        >Right management is required</small
                      >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="creator">Creator</label>

                      <textarea
                        class="form-control"
                        id="creator"
                        v-model="form.creator"
                        rows="3"
                        placeholder="Enter creator"
                        aria-describedby="creatorErr"
                      ></textarea>
                      <small
                        id="creatorErr"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.creator.required"
                        >Creator is required</small
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="subject">Subject</label>
                      <textarea
                        class="form-control"
                        id="subject"
                        v-model="form.subject"
                        rows="3"
                        placeholder="Enter subject"
                        aria-describedby="subjectErr"
                      ></textarea>
                      <small
                        id="subjectErr"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.subject.required"
                        >Subject is required</small
                      >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="type">Type</label>
                      <textarea
                        class="form-control"
                        id="type"
                        v-model="form.type"
                        rows="3"
                        placeholder="Enter type"
                        aria-describedby="typeErr"
                      ></textarea>
                      <small
                        id="typeErr"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.type.required"
                        >Type is required</small
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="format">Format</label>
                      <textarea
                        class="form-control"
                        id="format"
                        v-model="form.format"
                        rows="3"
                        placeholder="Enter format"
                        aria-describedby="formatErr"
                      ></textarea>
                      <small
                        id="formatErr"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.format.required"
                        >Format is required</small
                      >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contributor">Contributor</label>
                      <textarea
                        class="form-control"
                        id="contributor"
                        v-model="form.contributor"
                        rows="3"
                        placeholder="Enter contributor"
                        aria-describedby="contributorErr"
                      ></textarea>
                      <small
                        id="contributorErr"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.contributor.required"
                        >Contributor is required</small
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="identifier">Identifier</label>
                      <textarea
                        class="form-control"
                        id="identifier"
                        v-model="form.identifier"
                        rows="3"
                        placeholder="Enter identifier"
                        aria-describedby="identifierErr"
                      ></textarea>
                      <small
                        id="identifierErr"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.identifier.required"
                        >Identifier is required</small
                      >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="source">Source</label>
                      <textarea
                        class="form-control"
                        id="source"
                        v-model="form.source"
                        rows="3"
                        placeholder="Enter source"
                        aria-describedby="sourceErr"
                      ></textarea>
                      <small
                        id="sourceErr"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.source.required"
                        >Source is required</small
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="coverage">coverage</label>
                      <textarea
                        class="form-control"
                        id="coverage"
                        v-model="form.coverage"
                        rows="3"
                        placeholder="Enter coverage"
                        aria-describedby="coverageErr"
                      ></textarea>
                      <small
                        id="coverageErr"
                        class="form-text text-muted"
                        v-if="submitted && !$v.form.coverage.required"
                        >coverage is required</small
                      >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="division_information"
                        >Division Information</label
                      >
                      <textarea
                        class="form-control"
                        id="division_information"
                        v-model="form.division_information"
                        rows="3"
                        placeholder="Enter division information"
                        aria-describedby="division_informationErr"
                      ></textarea>
                      <small
                        id="division_informationErr"
                        class="form-text text-muted"
                        v-if="
                          submitted && !$v.form.division_information.required
                        "
                        >Division information is required</small
                      >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <label for="upload_card">Upload File</label>
                      <input
                        type="file"
                        class="form-control-file"
                        id="upload_card"
                        ref="file1"
                        v-on:change="handleUploadCard()"
                      />
                      <small
                        id="addresError"
                        class="form-text text-muted"
                        v-if="$v.form.upload_card.required && wrongFile"
                        >Format file tidak didukung</small
                      >
                    </div>
                    <br>
                    <div class="col-md-5">
                      <div v-for="(file, f) in form.file_upload" :key="f">
                        <div class="card" style="margin-left: 10px">
                          <div class="card-title">
                            <p class="text-center mt-2">
                              <i class="fas fa-file-pdf fa-5x"></i>
                            </p>
                          </div>
                          <div class="card-body">
                            <a
                              :href="
                                '/storage/uploads/file_upload/' + file.file_name
                              "
                              download
                            >
                              {{ file.file_name }}
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6" v-if="form.status == 'pending'">
                    <div class="form-group">
                      <label for="division_information"
                        >Alasan Reject</label
                      >
                      <textarea
                        class="form-control"
                        id="division_information"
                        v-model="form.rejection"
                        rows="4"
                        placeholder="(opsional) Ketik alasan singkat untuk reject deposit .."
                        aria-describedby="reasonErr"
                      ></textarea>
                      <small
                        id="reasonErr"
                        class="form-text"
                        >*Fill this field if you choose to <b>Reject</b> this deposit</small
                      >
                    </div>
                  </div>
                  
                  <!-- <div class="col-md-6">
                    <div class="form-group">
                      <div class="row">
                        <div>
                        </div>
                        <div class="col-md-10">
                          <label for="upload_file">File</label>
                          <input
                            type="file"
                            ref="file"
                            multiple
                            @change="handleUploadPhoto()"
                            class="form-control-file"
                            id="photo"
                          />

                          <small
                            id="upload_fileHelp"
                            class="form-text text-muted"
                            v-if="submitted && !$v.form.file_upload.required"
                          >
                            File is required
                          </small>
                        </div>
                      </div>
                    </div>
                  </div> -->
                </div>
                <button
                  style="margin-left:10px"
                  class="btn btn-success float-right"
                  type="button"
                  v-on:click.prevent="onUpdate()"
                >
                  Update
                </button>
                <div v-if="form.status == 'pending'">
                  <button
                    type="submit"
                    style="margin-left:10px"
                    class="btn btn-primary float-right"
                    v-on:click.prevent="handleApproval(form.id, 'Approved')"
                  >
                    Approve
                  </button>
                  <button
                    type="submit"
                    class="btn btn-danger float-right"
                    v-on:click.prevent="handleApproval(form.id, 'Reject')"
                  >
                    Reject
                  </button>
                </div>
                <!-- <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      
                    </div>
                  </div>
                </div> -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";

export default {
  props: ["id"],
  data() {
    return {
      form: {
        id: "",
        title: "",
        category: "",
        description: "",
        publisher: "",
        date: "",
        language: "",
        relation: "",
        user_id: localStorage.getItem("user_id"),
        right_management: "",
        creator: "",
        subject: "",
        type: "",
        format: "",
        contributor: "",
        identifier: "",
        source: "",
        coverage: "",
        status: "",
        upload_card: [],
        division_information: "",
        file_upload: [],
        rejection: "",
      },
      submitted: false,
      loading: true,
      wrongFile: false,
    };
  },
  validations: {
    form: {
      title: { required },
      category: { required },
      description: { required },
      publisher: { required },
      date: { required },
      language: { required },
      relation: { required },
      user_id: localStorage.getItem("user_id"),
      right_management: { required },
      creator: { required },
      subject: { required },
      type: { required },
      format: { required },
      contributor: { required },
      identifier: { required },
      source: { required },
      coverage: { required },
      division_information: { required },
      file_upload: { required },
      upload_card: { required },
      rejection: { required },
    },
  },
  computed: {
    categories() {
      return this.$store.getters.getAllCategories;
    },
    languages() {
      return this.$store.getters.getAllLanguages;
    },
  },
  watch: {
    $route(to, from) {
      // console.log("change");
      this.getMyUpload();
      // this.show = false;
    },
  },
  mounted() {
    this.getMyUpload();
    // console.log(this.form.user_id);
    this.$store.dispatch("getCategory");
    this.$store.dispatch("getLanguage");
  },
  methods: {
    resetData() {
      this.form.title = "";
      this.form.category = "";
      this.form.description = "";
      this.form.publisher = "";
      this.form.date = "";
      this.form.language = "";
      this.form.relation = "";
      this.form.user_id = "";
      this.form.right_management = "";
      this.form.creator = "";
      this.form.subject = "";
      this.form.type = "";
      this.form.format = "";
      this.form.contributor = "";
      this.form.identifier = "";
      this.form.source = "";
      this.form.coverage = "";
      this.form.division_information = "";
      this.form.file_upload = "";
      this.$refs.file.value = null;
    },

    handleUploadCard() {
      
      if (this.$refs.file1.files.length != 0)
      {
        this.form.upload_card = this.$refs.file1.files[0];
        var type = this.$refs.file1.files[0].type;

        console.log(this.form.upload_card);

        if (type === 'application/pdf')
          this.wrongFile = false;
        else
          this.wrongFile = true;
      }
      else
      {
        this.wrongFile = false;
      }
      
    },

    onUpdate() {
      let formData = new FormData();
      formData.append("title", this.form.title);
      formData.append("category", this.form.category);
      formData.append("description", this.form.description);
      formData.append("publisher", this.form.publisher);
      formData.append("date", this.form.date);
      formData.append("language", this.form.language);
      formData.append("relation", this.form.relation);
      formData.append("right_management", this.form.right_management);

      formData.append("creator", this.form.creator);
      formData.append("subject", this.form.subject);
      formData.append("contributor", this.form.contributor);
      formData.append("type", this.form.type);
      formData.append("format", this.form.format);
      formData.append("identifier", this.form.identifier);
      formData.append("source", this.form.source);
      formData.append("coverage", this.form.coverage);
      formData.append("division_information", this.form.division_information);
      formData.append("upload_card", this.form.upload_card);

      axios.post("/api/upload-form/data/" + this.id, formData)
      .then((res) => {
        // console.log(res.data);
        Vue.swal({
          icon: "success",
          title: "Data Berhasil di Ubah!",
        });

        this.getMyUpload();
      })
      .catch((error) => {
          console.log(error.response);
      });
    },

    handleApproval(id, val) {
      var vm = this;
      var data = {
        status: val,
        reason: "-",
      };

      if (val == "Reject")
      {
        var data = {
          status: val,
          reason: this.form.rejection,
        };
      }
      
      axios.put("/api/upload-form/approval/" + id, data)
      .then((res) => {
        // console.log(res);
        if (res.status == 200) {
          // let approval = "";
          // var approval_status = 2;
          // if (approval_status == 1) {
          //   approval = "Approve";
          // } else if (approval_status == 2) {
          //   approval = "Reject";
          // }
          Vue.swal({
            icon: "success",
            title: "File berhasil di " + val,
          });
          vm.$router.push("/all-deposit");
        }
      })
      .catch((error) => {
          console.log(error.response);
      });
    },

    handleUploadPhoto() {
      // console.log(this.$refs.file.files);
      this.form.file_upload = this.$refs.file.files;
    },

    handleSubmit() {
      // console.log(this.form);
      this.submitted = false;
      //   this.$v.$touch();
      //   if (this.$v.$invalid) {
      //     return;
      //   }
      let formData = new FormData();
      formData.append("title", this.form.title);
      formData.append("category", this.form.category);
      formData.append("creator", this.form.creator);
      formData.append("subject", this.form.subject);
      formData.append("description", this.form.description);
      formData.append("publisher", this.form.publisher);
      formData.append("contributor", this.form.contributor);
      formData.append("date", this.form.date);
      formData.append("type", this.form.type);
      formData.append("format", this.form.format);
      formData.append("identifier", this.form.identifier);
      formData.append("source", this.form.source);
      formData.append("language", this.form.language);
      formData.append("relation", this.form.relation);
      formData.append("coverage", this.form.coverage);
      formData.append("division_information", this.form.division_information);
      for (const i of Object.keys(this.form.file_upload)) {
        formData.append(`file_upload[${i}]`, this.form.file_upload[i]);
      }
      formData.append("user_id", this.form.user_id);
      formData.append("right_management", this.form.right_management);

      axios
        .post("/api/upload-form", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          this.resetData();
          Vue.swal({
            icon: "success",
            title: "File successfully uploaded!",
          });
          // console.log(res);
        });
    },

    getMyUpload() {
      this.loading = true;
      // console.log("my upload get");
      axios.get("/api/upload-form/" + this.id).then((res) => {
        this.loading = false;
        this.form.id = res.data.data.form.id;
        this.form.title = res.data.data.form.title;
        this.form.category = res.data.data.form.category;
        this.form.description = res.data.data.form.description;
        this.form.publisher = res.data.data.form.publisher;
        this.form.date = res.data.data.form.date;
        this.form.language = res.data.data.form.language;
        this.form.relation = res.data.data.form.relation;
        this.form.right_management = res.data.data.form.right_management;
        this.form.creator = res.data.data.form.upload_form_creator.map(
          ({ creator }) => creator
        );
        this.form.subject = res.data.data.form.upload_form_subject.map(
          ({ subject }) => subject
        );
        this.form.type = res.data.data.form.upload_form_type.map(
          ({ type }) => type
        );
        this.form.format = res.data.data.form.upload_form_format.map(
          ({ format }) => format
        );
        this.form.contributor = res.data.data.form.upload_form_contributor.map(
          ({ contributor }) => contributor
        );
        this.form.identifier = res.data.data.form.upload_form_identifier.map(
          ({ identifier }) => identifier
        );
        this.form.source = res.data.data.form.upload_form_source.map(
          ({ source }) => source
        );
        this.form.coverage = res.data.data.form.upload_form_coverage.map(
          ({ coverage }) => coverage
        );
        this.form.division_information = res.data.data.form.upload_form_division.map(
          ({ division }) => division
        );
        this.form.file_upload = res.data.data.form.upload_form_file;
        this.form.status = res.data.data.form.status;
        // console.log(this.form.file_upload);
      });
    },
  },
};
</script>
