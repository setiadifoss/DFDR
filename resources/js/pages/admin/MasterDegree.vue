<template>
  <div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Master Subject</h1>
      <!-- <a href="#" class="d-none d-sm-inline-block btn  btn-primary shadow-sm"
        ><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a
      > -->
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <b-row class="mb-3">
              <b-col md="3">
                <b-form-input
                  v-model="filter"
                  type="search"
                  id="filterInput"
                  placeholder="Type to Search"
                ></b-form-input>
              </b-col>
            </b-row>
            <b-table
              hover
              responsive
              :items="items"
              :fields="fields"
              :per-page="perPage"
              :current-page="currentPage"
              :filter="filter"
            >
              <template v-slot:cell(actions)="data">
                <b-button
                  v-b-modal.modal-1
                  variant="success"
                  class="btn-sm"
                  v-b-tooltip.hover
                  title="Detail"
                  v-on:click="toDetail(data.item.id)"
                  ><i class="fas fa-fw fa-edit"></i
                ></b-button>
                <b-button
                  variant="danger"
                  class="btn-sm"
                  v-b-tooltip.hover
                  title="Delete"
                  @click="toDelete(data.item.id)"
                  ><i class="fas fa-fw fa-trash-alt"></i
                ></b-button>
              </template>
            </b-table>
            <b-pagination
              pills
              v-model="currentPage"
              :total-rows="rows"
              :per-page="perPage"
              aria-controls="my-table"
              change="handlePaging($event)"
            ></b-pagination>
            <ul style="display: hidden">
              <li v-for="(cat, c) in subject" :key="c">
                {{ cat.subject_name }}
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h4>Form Subject</h4>
            <form>
              <div class="form-group">
                <label for="exampleInputEmail1"></label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleInputEmail1"
                  aria-describedby="subjectError"
                  placeholder="Input Subject.."
                  v-model="form.subject_name"
                />
                <small
                  id="subjectError"
                  class="form-text text-muted"
                  v-if="submitted && !$v.form.subject_name.required"
                  ><i class="fa fa-info-circle text-xs"></i>&nbsp; Subject name is required</small
                >
              </div>
              <button
                type="submit"
                class="btn btn-sm btn-primary"
                v-if="updated == false"
                v-on:click.prevent="handleCreatedDegree()"
              >
                Submit
              </button>
              <button
                type="submit"
                class="btn btn-sm btn-success"
                v-if="updated == true"
                v-on:click.prevent="handleUpdatedDegree()"
              >
                Update
              </button>
              <button
                type="submit"
                class="btn btn-sm btn-secondary"
                v-if="updated == true"
                v-on:click.prevent="clearData()"
              >
                Cancel
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .text-muted {
    color: red !important;
  }
</style>

<script>
import { required, minLength, email } from "vuelidate/lib/validators";
export default {
  data() {
    return {
      id: "",
      filter: "",
      perPage: 10,
      currentPage: 1,
      fields: ["subject_name", "actions"],
      items: [],
      form: {
        subject_name: "",
      },
      submitted: false,
      updated: false,
    };
  },
  validations: {
    form: {
      subject_name: { required },
    },
  },
  computed: {
    subject() {
      this.items = this.$store.getters.getAllSubject;
    },
    rows() {
      return this.items.length;
    },
  },
  mounted() {
    if (localStorage.getItem("role") == "User") {
      this.$router.push("/my-upload");
    }
    this.$store.dispatch("getSubject");
  },
  methods: {
    handleCreatedDegree() {
      this.submitted = true;
      var vm = this;
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      // console.log(this.form);
      let formData = new FormData();
      formData.append("subject_name", this.form.subject_name);
      axios.post("/api/subject", formData).then((res) => 
      {
        // console.log(res.data);
        if(res.data.status == "Success")
        {
          Vue.swal({
            icon: "success",
            title: "Successfully Added!",
          });
        }
        else
        {
          Vue.swal({
            icon: "error",
            title: "Failed to Add!",
            text: "Data with same name already exist",
          });
        }

        this.$store.dispatch("getSubject");
        this.clearData();
      });
    },

    toDelete(id) {
      // console.log("delete" + id);
      Vue.swal({
        title: "Delete Data",
        text: "Are you sure want to delete this data permanently?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "secondary",
        confirmButtonText: "Delete",
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete("/api/subject/" + id).then((res) => {
            Vue.swal({
              icon: "success",
              title: "Successfully Deleted!",
            });
            this.$store.dispatch("getSubject");
          });
        }
      });
    },

    toDetail(id) {
      this.updated = true;
      axios.get("/api/subject/" + id).then((res) => {
        this.form.subject_name = res.data.data.subject.subject_name;
        this.id = res.data.data.subject.id;
        // console.log(this.id);
      });
    },

    handleUpdatedDegree() {
      var vm = this;
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      let formData = new FormData();
      formData.append("subject_name", this.form.degree_name);
      axios.put("/api/subject/" + this.id, this.form).then((res) => 
      {
        // console.log(res);
        if(res.data.status == "Success")
        {
          Vue.swal({
            icon: "success",
            title: "Successfully Updated!",
          });
        }
        else
        {
          Vue.swal({
            icon: "error",
            title: "Failed to Update!",
            text: "Data with same name already exist",
          });
        }
        
        this.clearData();
        this.$store.dispatch("getSubject");
      });
    },

    clearData() {
      this.submitted = false;
      this.updated = false;
      this.form.subject_name = "";
      this.id = "";
    },
  },
};
</script>
