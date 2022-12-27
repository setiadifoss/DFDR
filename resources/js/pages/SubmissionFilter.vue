<template>
  <div class="container-fluid mt-4 mb-4">
    <div class="row justify-content-center">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <h4
          class="d-flex justify-content-center text-dark font-weight-bold mb-1"
        >
          All Collections
        </h4>
        <p class="mb-3 d-flex justify-content-center">All Title Submissions</p>
        <form
          class="d-flex justify-content-center mb-5"
          v-on:submit.prevent="onSearch()"
        >
          <div class="search-box">
            <input
              type="text"
              class="form-control form-control-lg"
              id="search"
              v-model="form.search_key"
              placeholder="Search Title Submission .."
            />
            <button
              type="submit"
              class="btn btn-primary btn-block bg-blue btn-md"
              v-on:click.prevent="onSearch()"
            >
              <p>Search</p>
            </button>
          </div>
        </form>
        <div class="row">
          <div class="col-3 filter-container">
            <div
              style="border-bottom: 1px solid #e4e4e4; height: 30px"
              class="row d-flex justify-content-between mb-3 px-3"
            >
              <p class="font-weight-bold">Filter by</p>
              <small style="cursor: pointer" @click="clearFilter()"
                >Reset Filters</small
              >
            </div>
            <div class="p-3">
              <div
                class="d-flex justify-content-between"
                style="cursor: pointer"
                @click="v_sort = !v_sort"
              >
                <p class="mb-3 font-weight-bold">Sort</p>
                <i class="fa fa-chevron-down pt-1" v-if="!v_sort"></i>
                <i class="fa fa-chevron-up pt-1" v-if="v_sort"></i>
              </div>
              <div v-show="v_sort" class="form-check mb-2">
                <input
                  @input="onSorting($event)"
                  class="form-check-input"
                  type="radio"
                  name="ASC"
                  value="ASC"
                  @click="sort = true"
                  :checked="sort"
                  id="flexRadioDefault1"
                />
                <label class="form-check-label" for="flexRadioDefault1">
                  A - Z
                </label>
              </div>
              <div v-show="v_sort" class="form-check mb-3">
                <input
                  @input="onSorting($event)"
                  @click="sort = false"
                  class="form-check-input"
                  type="radio"
                  name="DESC"
                  value="DESC"
                  :checked="!sort"
                  id="flexRadioDefault2"
                />
                <label class="form-check-label" for="flexRadioDefault2">
                  Z - A
                </label>
              </div>
              <div
                class="d-flex justify-content-between"
                style="cursor: pointer"
                @click="v_date = !v_date"
              >
                <p class="mb-3 font-weight-bold">Date Range</p>
                <i class="fa fa-chevron-down pt-1" v-if="!v_date"></i>
                <i class="fa fa-chevron-up pt-1" v-if="v_date"></i>
              </div>
              <div v-show="v_date" class="p-3 mb-4">
                <div class="form-group mb-1">
                  <input
                    type="date"
                    name=""
                    id=""
                    v-model="form.start_date"
                    class="form-control font-date"
                  />
                </div>
                <p class="font-weight-bold text-center mb-1">to</p>
                <div class="form-group">
                  <input
                    type="date"
                    name=""
                    id=""
                    v-model="form.end_date"
                    class="form-control"
                  />
                </div>
                <button
                  class="btn apply-btn btn-sm btn-block font-weight-bold"
                  v-on:click.prevent="onDateRange()"
                >
                  Apply
                </button>
              </div>
              <div
                class="d-flex justify-content-between"
                style="cursor: pointer"
                @click="v_option = !v_option"
              >
                <p class="mb-3 font-weight-bold">Options</p>
                <i class="fa fa-chevron-down pt-1" v-if="!v_option"></i>
                <i class="fa fa-chevron-up pt-1" v-if="v_option"></i>
              </div>
              <div v-show="v_option" class="form-check mb-2">
                <input
                  class="form-check-input"
                  type="radio"
                  name="ASC"
                  value="ASC"
                  @input="onOptionSelected('Open')"
                  @click="options = true"
                  :checked="options"
                  id="flexRadioDefault1"
                />
                <label class="form-check-label" for="flexRadioDefault1">
                  Open
                </label>
              </div>
              <div v-show="v_option" class="form-check mb-3">
                <input
                  @input="onOptionSelected('Close')"
                  @click="options = false"
                  class="form-check-input"
                  type="radio"
                  name="Open"
                  :checked="!options"
                  id="flexRadioDefault2"
                />
                <label class="form-check-label" for="flexRadioDefault2">
                  Close
                </label>
              </div>
              <div
                class="d-flex justify-content-between"
                style="cursor: pointer"
                @click="v_collections = !v_collections"
              >
                <p class="mb-3 font-weight-bold">Collections</p>
                <i class="fa fa-chevron-down pt-1" v-if="!v_collections"></i>
                <i class="fa fa-chevron-up pt-1" v-if="v_collections"></i>
              </div>
              <div
                v-show="v_collections"
                class="form-check mb-1"
                v-for="(cat, index) in categories"
                :key="index"
              >
                <input
                  @input="onCategorySelect(cat.id, cat.category_name)"
                  class="form-check-input"
                  @click="selectedCategory = cat.id"
                  type="radio"
                  :checked="cat.id === selectedCategory"
                  id="flexRadioDefault2"
                />
                <label class="form-check-label" for="flexRadioDefault2">
                  {{ cat.category_name }}
                </label>
              </div>
              <div
                class="d-flex justify-content-between"
                style="cursor: pointer"
                @click="v_creator = !v_creator"
              >
                <p class="mb-3 font-weight-bold">Creators</p>
                <i class="fa fa-chevron-down pt-1" v-if="!v_creator"></i>
                <i class="fa fa-chevron-up pt-1" v-if="v_creator"></i>
              </div>
              <div
                v-show="v_creator"
                class="form-check mb-1"
                v-for="(item, index) in creators"
                :key="index"
              >
                <input
                  @input="onCreatorSelected(item.value)"
                  class="form-check-input"
                  @click="selectedCreator = item.value"
                  type="radio"
                  :checked="item.value === selectedCreator"
                  id="flexRadioDefault2"
                />
                <label
                  style="cursor: pointer"
                  class="form-check-label"
                  for="flexRadioDefault2"
                >
                  {{ item.value }}
                </label>
              </div>
              <p v-show="v_creator" class="mt-3">
                Total data: {{ creators.length }}
              </p>
              <b-pagination
                v-show="v_creator"
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="my-table"
                size="sm"
              ></b-pagination>
              <div
                class="d-flex justify-content-between"
                style="cursor: pointer"
                @click="v_subject = !v_subject"
              >
                <p class="mb-3 font-weight-bold">Subject</p>
                <i class="fa fa-chevron-down pt-1" v-if="!v_subject"></i>
                <i class="fa fa-chevron-up pt-1" v-if="v_subject"></i>
              </div>
              <div
                v-show="v_subject"
                class="form-check mb-1"
                v-for="(sub, index) in subject"
                :key="index"
              >
                <input
                  @input="onSubjectClicked(sub.subject)"
                  class="form-check-input"
                  @click="selectedSubject = sub.subject"
                  type="radio"
                  :checked="sub.subject === selectedSubject"
                  id="flexRadioDefault2"
                />
                <label class="form-check-label" for="flexRadioDefault2">
                  {{ sub.subject }}
                </label>
              </div>
              <div
                class="d-flex justify-content-between"
                style="cursor: pointer"
                @click="v_type = !v_type"
              >
                <p class="mb-3 font-weight-bold">Type</p>
                <i class="fa fa-chevron-down pt-1" v-if="!v_type"></i>
                <i class="fa fa-chevron-up pt-1" v-if="v_type"></i>
              </div>
              <div
                v-show="v_type"
                class="form-check mb-1"
                v-for="(item, index) in type"
                :key="index"
              >
                <input
                  @input="onTypeSelected(item.type)"
                  class="form-check-input"
                  @click="selectedType = item.type"
                  type="radio"
                  :checked="item.type === selectedType"
                  id="flexRadioDefault2"
                />
                <label class="form-check-label" for="flexRadioDefault2">
                  {{ item.type }}
                </label>
              </div>
            </div>
          </div>
          <div class="col-1"></div>
          <div class="col result-container">
            <b style="color: #184d47"
              >Submission found : {{ submissionCounting }} items</b
            >
            <div
              class="d-flex justify-content-center font-weight-bold"
              style="color: #2f3542"
              v-show="submissions.length == 0"
            >
              Submission not found
            </div>
            <div class="d-flex justify-content-center" v-if="loading">
              <loading-component></loading-component>
            </div>
            <div
              class="submission-item row"
              v-for="(sub, s) in submissions"
              :key="s"
            >
              <div class="col-2">
                <img
                  class="img-fluid mb-2 float-left"
                  src="/admin-template/img/logo.png"
                  width="120"
                  style="margin-right: 5px"
                />
              </div>
              <div class="col d-flex flex-column">
                <b style="color: #184d47" class="mb-1">
                  <router-link
                    :to="{
                      name: 'DetailSubmission',
                      params: { id: sub.id },
                    }"
                    >{{ sub.title }}</router-link
                  >
                </b>
                <small
                  style="color:#184d47; cursor: pointer"
                  v-on:click="onSearchByCategory(sub.category)"
                  >{{ sub.category_name }}</small
                >
                <div class="d-flex">
                  <small
                    class="mb-2"
                    v-for="(subcreator, sc) in sub.upload_form_creator"
                    :key="sc"
                  >
                    {{ subcreator.creator }},&nbsp;
                  </small>
                </div>
                <small class="font-weight-bold" style="color: black">
                  Date added: {{ sub.date }}
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
p {
  margin: 0;
  padding: 0;
}

.result-container {
  padding: 10px;
}

.apply-btn {
  background-color: #244943;
  color: white;
}

.filter-container {
  background-color: #f6f6f6;
  border-radius: 5px;
  padding: 1rem;
}

.search-box {
  display: grid;
  grid-template-columns: 2fr 1fr;
  padding-right: 1rem;
  padding-left: 1rem;
  align-content: center;
  align-items: center;
  width: 25vw;
  height: 4rem;
  border-radius: 0.5rem;
  border: 1px solid #afafaf;
  align-content: center;
}
.search-box > .form-control {
  border: 0;
  outline: none;
  box-shadow: none;
}
.title-text {
  font-size: 18px;
  font-weight: bold;
}
.sub-text {
  font-size: 14px;
}
.cat {
  color: #96bb7c;
  /* cursor: pointer; */
}

.card {
  box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
  border-radius: 1rem !important;
}
</style>

<script>
export default {
  data() {
    return {
      sort: true,
      selectedCategory: "",
      selectedType: "",
      selectedSubject: "",
      selectedCreator: "",
      options: true,
      perPage: 10,
      currentPage: 1,
      rows: 0,
      jumlahData: null,
      v_sort: true,
      v_collections: false,
      v_date: true,
      v_creator: false,
      v_subject: false,
      v_type: false,
      v_option: false,
      subject: [],
      type: [],
      submitted: false,
      submissionCounting: "",
      submissions: [],
      selectCategory: null,
      form: {
        search_key: "",
        category: "",
        type: "",
        subject: "",
        start_date: "",
        end_date: "",
      },
      loading: true,
    };
  },
  computed: {
    categories() {
      return this.$store.getters.getAllCategories;
    },
    creators() {
      this.rows = this.$store.getters.getAllCreator.length;
      return this.$store.getters.getAllCreator;
    },
  },
  created() {
    // this.jumlahData = 'haloo'
    //  this.rows = this.$store.getters.getAllCreator.length
  },
  mounted() {
    if (this.$route.params.part == "Search") {
      this.form.category = this.$route.params.category;
      this.form.search_key = this.$route.params.keySearch;
      this.onSearch();
    } else if (this.$route.params.part == "Collection") {
      this.v_collections = true;
      this.v_date = true;
      this.v_creator = false;
      this.onCategorySelect(this.$route.params.keySearch, "");
    } else if (this.$route.params.part == "This_Month") {
      this.v_collections = false;
      this.v_date = true;
      this.v_creator = false;
      this.onThisMonth();
    } else if (this.$route.params.part == "Creator") {
      this.v_collections = false;
      this.v_date = true;
      this.v_creator = true;
      this.onCreatorSelected(this.$route.params.keySearch);
    } else {
      this.v_collections = false;
      this.v_date = true;
      this.v_creator = false;
      this.getSubmissions("ASC");
    }

    this.$store.dispatch("getCategory");
    this.$store.dispatch("getCreator");

    this.getSubject();
    this.getType();
  },

  methods: {
    clearFilter() {
      this.getSubmissions("ASC");
      this.form.ctegory = "";
    },

    onSorting(event) {
      console.log(event.target.value);
      this.getSubmissions(event.target.value);
    },

    onDateRange() {
      console.log(this.form);
      // this.form.subject = subject;
      this.loading = true;
      let data = {
        title: this.form.search_key,
        category: this.form.category,
        type: this.form.type,
        subject: this.form.subject,
        start_date: this.form.start_date,
        end_date: this.form.end_date,
      };
      axios.post("/api/upload-form/search/new/title", data).then((res) => {
        this.loading = false;
        this.submissions = res.data.data.form;
        this.submissionCounting = this.submissions.length;
      });
    },

    getSubject() {
      axios.get("/api/list/data/subject").then((res) => {
        this.subject = res.data.data.data;
        // console.log(this.subject);
      });
    },

    getType() {
      axios.get("/api/list/data/type").then((res) => {
        // console.log(res);
        this.type = res.data.data.data;
        // console.log(this.type);
      });
    },

    getSubmissions(sort) {
      this.loading = true;
      axios
        .get("/api/upload-form/search/status/Approved/" + sort)
        .then((res) => {
          this.submissions = res.data.data.form;
          this.submissionCounting = this.submissions.length;
          this.loading = false;
        });
    },

    onSearch() {
      // console.log(this.form.search_key);
      this.loading = true;

      if (this.form.search_key == "" || this.form.search_key == undefined) {
        this.getSubmissions("ASC");
      } else {
        let data = {
          title: this.form.search_key,
        };
        axios.post("/api/upload-form/search/new/title", data).then((res) => {
          this.loading = false;
          this.submissions = res.data.data.form;
          this.submissionCounting = this.submissions.length;
        });
      }
    },

    onSearchByCategory(id) {
      this.clickedCategory = true;
      this.getSubmissionCategory(id);
      console.log(id);
      console.log(this.clickedCategory);
    },

    getSubmissionCategory(id) {
      this.loading = true;
      axios.get("/api/upload-form/search/category/" + id).then((res) => {
        this.submissions = res.data.data.form;
        this.submissionCounting = this.submissions.length;
        this.loading = false;
        console.log(this.submissions);
      });
    },

    onThisMonth() {
      this.loading = true;
      let data = {
        this_month: "",
      };
      axios.post("/api/upload-form/search/new/title", data).then((res) => {
        // console.log(res);
        this.loading = false;
        this.submissions = res.data.data.form;
        this.submissionCounting = this.submissions.length;
      });
    },

    onCategorySelect(id, name) {
      this.selectCategory = name;
      this.form.category = id;
      this.loading = true;
      let data = {
        category: id,
      };
      axios.post("/api/upload-form/search/new/title", data).then((res) => {
        this.loading = false;
        this.submissions = res.data.data.form;
        this.submissionCounting = this.submissions.length;
      });
    },

    onOptionSelected(type) {
      this.loading = true;
      let data = {
        right_management: type,
      };
      axios.post("/api/upload-form/search/new/title", data).then((res) => {
        // console.log(res);
        this.loading = false;
        this.submissions = res.data.data.form;
        this.submissionCounting = this.submissions.length;
      });
    },

    onCreatorSelected(type) {
      // this.form.type = type;
      this.loading = true;
      let data = {
        creator: type,
      };
      axios.post("/api/upload-form/search/new/title", data).then((res) => {
        // console.log(res);
        this.loading = false;
        this.submissions = res.data.data.form;
        this.submissionCounting = this.submissions.length;
      });
    },

    onTypeSelected(type) {
      this.form.type = type;
      this.loading = true;
      let data = {
        title: this.form.search_key,
        category: this.form.category,
        type: type,
      };
      axios.post("/api/upload-form/search/new/title", data).then((res) => {
        this.loading = false;
        this.submissions = res.data.data.form;
        this.submissionCounting = this.submissions.length;
      });
    },

    onSubjectClicked(subject) {
      this.form.subject = subject;
      this.loading = true;
      let data = {
        title: this.form.search_key,
        category: this.form.category,
        type: this.form.type,
        subject: subject,
      };
      axios.post("/api/upload-form/search/new/title", data).then((res) => {
        this.loading = false;
        this.submissions = res.data.data.form;
        this.submissionCounting = this.submissions.length;
      });
    },

    resetCategory() {
      this.form.category = "";
      console.log(this.form.category);
    },
  },
};
</script>
