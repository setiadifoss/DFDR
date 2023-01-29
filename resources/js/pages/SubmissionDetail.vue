<template>
  <div class="container-fluid mt-4 mb-4">
    <div class="text-center" v-if="loading">
      <loading-component></loading-component>
    </div>
    <div class="row justify-content-center" v-else>
      <div class="row mb-5">
        <div class="col-2">
          <div class="image-template"></div>
        </div>
        <div
          style="width: 100%;"
          class="col-10 d-flex flex-column justify-content-between"
        >
          <div>
            <h4>
              <b class="primary-text">{{ submissions.title }} </b>
            </h4>
          </div>
          <div class="d-flex">
            <i class="fa fa-solid fa-eye pt-1 mr-2"></i>
            <b class="mr-2">{{ tView }} Views</b>
            <i class="fa fa-solid fa-download pt-1 mr-2"></i>
            <b>{{ tDownload }} Downloads</b>
          </div>
        </div>
      </div>
      <div class="col-8 p-4 card">
        <h5 class="primary-text mb-3">
          <b>Detail Information</b>
        </h5>
        <div class="information-table card">
          <div class="information-row">
            <p>Contributor</p>
            <p
              v-for="(cont, cnt) in submissions.upload_form_contributor"
              :key="cnt"
            >
              {{ cont.contributor + ", " }}
            </p>
          </div>
          <div class="information-row">
            <p>Creator</p>
            <p v-for="(cre, cr) in submissions.upload_form_creator" :key="cr">
              {{ cre.creator + ", " }}
            </p>
          </div>
          <div class="information-row">
            <p>Description</p>
            <p>
              {{ submissions.description }}
            </p>
          </div>
          <div class="information-row">
            <p>Coverage</p>
            <ul>
              <li
                v-for="(cov, cv) in submissions.upload_form_coverage"
                :key="cv"
              >
                <p>{{ cov.coverage }}</p>
              </li>
            </ul>
          </div>
          <div class="information-row">
            <p>Publisher</p>
            <p>{{ submissions.publisher }}</p>
          </div>
          <div class="information-row">
            <p>Relation</p>
            <p>{{ submissions.relation }}</p>
          </div>
          <div class="information-row">
            <p>Subject</p>
            <ul>
              <li
                v-for="(sub, sb) in submissions.upload_form_subject"
                :key="sb"
              >
                {{ sub.subject }}
              </li>
            </ul>
          </div>
          <div class="information-row">
            <p>Type</p>
            <ul>
              <li v-for="(typ, ty) in submissions.upload_form_type" :key="ty">
                {{ typ.type }}
              </li>
            </ul>
          </div>
          <div class="information-row">
            <p>Languange</p>
            <p>{{ languange }}</p>
          </div>
          <div class="information-row">
            <p>Division</p>
            <ul>
              <li
                v-for="(div, dv) in submissions.upload_form_division"
                :key="dv"
              >
                {{ div.division }}
              </li>
            </ul>
          </div>
          <div class="information-row">
            <p>Format</p>
            <ul>
              <li
                v-for="(form, fr) in submissions.upload_form_format"
                :key="fr"
              >
                {{ form.format }}
              </li>
            </ul>
          </div>
          <div class="information-row">
            <p>Identifier</p>
            <ul>
              <li
                v-for="(iden, id) in submissions.upload_form_identifier"
                :key="id"
              >
                {{ iden.identifier }}
              </li>
            </ul>
          </div>
          <div class="information-row">
            <p>Source</p>
            <ul>
              <li v-for="(src, sr) in submissions.upload_form_source" :key="sr">
                {{ src.source }}
              </li>
            </ul>
          </div>
          <div class="information-row">
            <p>Date Added</p>
            <p>{{ submissions.date }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col p-2" @click="isShowFile = false">
            <div
              class="button d-flex justify-content-center"
              :class="{ active: !isShowFile }"
            >
              Abstract
            </div>
          </div>
          <div class="col p-2" @click="isShowFile = true">
            <div
              class="button d-flex justify-content-center"
              :class="{ active: isShowFile }"
            >
              File
            </div>
          </div>
        </div>
        <div v-if="!isShowFile" class="row p-3">
          <p>
            {{ submissions.description }}
          </p>
        </div>
        <div v-else class="row p-3">
          <div class="row" style="width: 100%">
            <div v-show="submissions.file != null" class="col-1 primary-text">
              <img :src="pdfLogo" alt="pdf-logo" />
            </div>
            <div v-show="submissions.file != null" class="col-11 mb-3">
              <p class="mb-2">{{ submissions.file }}</p>
              <button @click="pdfLibrary(submissions.file)" class="pdf-btn">
                Open
              </button>
            </div>
            <div v-show="submissions.file != null" class="col-1 primary-text">
              <img :src="pdfLogo" alt="pdf-logo" />
            </div>
            <div v-show="submissions.file != null" class="col-11 mb-3">
              <p class="mb-2">{{ submissions.file }}</p>
              <button @click="viewPdf(submissions.file)" class="pdf-btn">
                Open
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="col"></div>
      <div class="col-3 p-3 card" style="background-color: #f6f6f6;">
        <div class="row px-3">
          <h5 class="primary-text mb-3">
            <b>Related Paper</b>
          </h5>
          <div
            v-for="(paper, index) in relatedPaper"
            :key="index"
            class="d-flex mb-2"
          >
            <i class="fa fa-solid fa-chevron-right pt-1 mr-3"></i>
            <h6 class="primary-text">
              {{ paper.text }}
            </h6>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div v-if="!loading">
          <div v-if="showDetail">
            <div class="card p-4 mt-3">
              <div class="card-body">
                <a v-on:click="onDetail()" style="cursor: pointer; color: blue">
                  Show simple item record</a
                >
                <div class="row">
                  <div class="col-md-12">
                    <h3>File in this Submission</h3>
                    <b-row>
                      <b-col cols="4" md="4" class="mb-3">
                        <b-button
                          @click="viewPdf(submissions.file)"
                          v-show="submissions.file != null"
                          >{{ submissions.file }} (first page)</b-button
                        >
                      </b-col>
                      <b-col cols="4" md="4" class="mb-3">
                        <b-button
                          variant="success"
                          @click="pdfLibrary(submissions.file)"
                          v-show="submissions.file != null"
                          >{{ submissions.file }} (full view)</b-button
                        >
                      </b-col>
                    </b-row>

                    <ul class="list-group">
                      <li
                        class="list-group-item"
                        v-for="(file, f) in submissions.upload_form_file"
                        :key="f"
                      >
                        <a
                          :href="
                            '/storage/uploads/file_upload/' + file.file_name
                          "
                          target="_blank"
                          v-if="file.is_private != 1"
                        >
                          {{ file.file_name }} ( {{ file.file_size }} )
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 mt-4">
                    <h3>This item appears in the following category</h3>
                    <h5 class="cat">{{ this.category_name }}</h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 mt-4">
                    <a
                      v-on:click="onDetail()"
                      style="cursor: pointer; color: blue"
                    >
                      Show simple item record</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div v-if="!showDetail">
            <div class="row">
              <div class="col-md-9">
                <div class="card p-4 mb-4">
                  <div class="card-body">
                    <div v-html="submissions.description"></div>

                    <br />
                    <hr />
                    <h6>This submission appears in the following category:</h6>
                    <p class="sub-text cat">{{ this.category_name }}</p>

                    <!-- <template>
                      <pdf src="/storage/uploads/file_upload/file.pdf"></pdf>
                    </template> -->

                    <div id="pdf-view"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card p-2">
                  <div class="card-body">
                    <h6>File</h6>
                    <ul class="list-group">
                      <li
                        class="list-group-item text-center"
                        v-for="(file, f) in submissions.upload_form_file"
                        :key="f"
                      >
                        <p
                          v-show="submissions.right_management == 'Close'"
                          style="font-size: 13px"
                        >
                          {{ file.file_name }}
                        </p>
                        <!-- <p
                          v-on:click.prevent="
                            downloadedFile(submissions.id, file.file_name)
                          "
                        ></p> -->
                        <!-- <a
                          :href="
                            '/storage/uploads/file_upload/' + file.file_name
                          "
                          target="_blank"
                          v-show="submissions.right_management == 'Open'"
                        >
                          {{ file.file_name }}
                        </a> -->
                        <hr v-show="submissions.right_management == 'Close'" />
                        <p
                          v-show="submissions.right_management == 'Close'"
                          style="font-size: 9px"
                        >
                          <router-link
                            style="color: blue"
                            :to="{
                              name: 'Login',
                            }"
                            >Login
                          </router-link>
                          to Download / View file
                        </p>

                        <button
                          v-show="submissions.right_management == 'Open'"
                          type="button"
                          class="btn btn-primary btn-sm"
                          style="margin-right: 2px"
                          v-on:click.prevent="downloadedFile(file)"
                        >
                          <i class="fa fa-download"></i>
                        </button>
                        <button
                          v-show="submissions.right_management == 'Open'"
                          type="button"
                          class="btn btn-success btn-sm"
                          v-on:click.prevent="readFile(file)"
                        >
                          <i class="fa fa-eye"></i>
                        </button>
                      </li>
                    </ul>
                    <hr />
                    <hr />
                    <hr />
                    <div>
                      <h6>Creator :</h6>
                      <ul style="margin: 0px; padding-left: 15px">
                        <li
                          style="margin-left: 15px; padding: 0px"
                          v-for="(creator,
                          f) in submissions.upload_form_creator"
                          :key="f"
                        >
                          {{ creator.creator }}
                        </li>
                      </ul>
                    </div>
                    <hr />
                    <div>
                      <h6>Metadata :</h6>
                      <a
                        v-on:click="onDetail()"
                        style="
                          cursor: pointer;
                          color: blue;
                          font-size: 13px;
                          padding-left: 15px;
                        "
                      >
                        Show Full Records</a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
  border-radius: 0.1rem !important;
}
.image-template {
  height: 200px;
  width: 95%;
  background-color: rgb(97, 243, 97);
}
.primary-text {
  color: #184d47;
}
.information-table {
  border: 1px solid #f6f6f6;
  border-radius: 0.4rem;
  padding: 1rem;
  margin-bottom: 2rem;
  background-color: #f7f7f7;
}
.information-table > .information-row {
  grid-template-columns: repeat(2, 1fr);
  width: 100%;
  display: grid;
  border-bottom: 1px solid #e2d5d5;
  height: 100%;
  padding-bottom: 0.3rem;
  margin-bottom: 1rem;
}
.button {
  border-radius: 0.5rem;
  padding: 0.4rem;
  cursor: pointer;
}
.active {
  background-color: #184d47;
  color: white;
}
.pdf-btn {
  border: 0.3px solid #bcd0c0;
  border-radius: 0.4rem;
  color: #184d47;
  padding: 0.1rem;
  width: 5rem;
  font-weight: 600;
  height: 30px;
}
</style>

<script>
import pdf from "vue-pdf";
import pdfLogo from "../../../assets/pdfLogo.svg";

export default {
  components: {
    pdf,
  },
  props: ["id"],
  data() {
    return {
      pathFile: null,
      isShowFile: false,
      showDetail: false,
      submissions: {},
      pdfLogo,
      tDownload: "",
      tView: "",
      loading: true,
      category_name: "",
      language: "",
      relatedPaper: [
        {
          text:
            "Upaya Peningkatan Keselamatan Jalan pada Simpang Tak Bersinyal dengan Metode Hazard Identification Risk And Assessment (HIRA) Studi Kasus: Simpang 4 Damri Jalan Ahmad Yani Kota Surakarta",
        },
        {
          text:
            "Upaya Peningkatan Keselamatan Jalan pada Simpang Tak Bersinyal dengan Metode Hazard Identification Risk And Assessment (HIRA) Studi Kasus: Simpang 4 Damri Jalan Ahmad Yani Kota Surakarta",
        },
        {
          text:
            "Upaya Peningkatan Keselamatan Jalan pada Simpang Tak Bersinyal dengan Metode Hazard Identification Risk And Assessment (HIRA) Studi Kasus: Simpang 4 Damri Jalan Ahmad Yani Kota Surakarta",
        },
        {
          text:
            "Upaya Peningkatan Keselamatan Jalan pada Simpang Tak Bersinyal dengan Metode Hazard Identification Risk And Assessment (HIRA) Studi Kasus: Simpang 4 Damri Jalan Ahmad Yani Kota Surakarta",
        },
        {
          text:
            "Upaya Peningkatan Keselamatan Jalan pada Simpang Tak Bersinyal dengan Metode Hazard Identification Risk And Assessment (HIRA) Studi Kasus: Simpang 4 Damri Jalan Ahmad Yani Kota Surakarta",
        },
        {
          text:
            "Upaya Peningkatan Keselamatan Jalan pada Simpang Tak Bersinyal dengan Metode Hazard Identification Risk And Assessment (HIRA) Studi Kasus: Simpang 4 Damri Jalan Ahmad Yani Kota Surakarta",
        },
        {
          text:
            "Upaya Peningkatan Keselamatan Jalan pada Simpang Tak Bersinyal dengan Metode Hazard Identification Risk And Assessment (HIRA) Studi Kasus: Simpang 4 Damri Jalan Ahmad Yani Kota Surakarta",
        },
        {
          text:
            "Upaya Peningkatan Keselamatan Jalan pada Simpang Tak Bersinyal dengan Metode Hazard Identification Risk And Assessment (HIRA) Studi Kasus: Simpang 4 Damri Jalan Ahmad Yani Kota Surakarta",
        },
      ],
    };
  },
  mounted() {
    this.getDetailSubmission();
    console.log(this.id);
    this.getPath();
  },

  methods: {
    viewPdf(fileName) {
      console.log(fileName);
      let route = this.$router.resolve({
        name: "PdfView",
        params: { id: fileName },
      });

      // this.$store.dispatch('getJson', payload);
      // let route = this.$router.resolve({name: 'routeName', query: {data: "someData"}});
      window.open(route.href, "_blank");
    },
    viewPdfFull(fileName) {
      console.log(fileName);
      let route = this.$router.resolve({
        name: "PdfViewNew",
        params: { id: fileName },
      });

      // this.$store.dispatch('getJson', payload);
      // let route = this.$router.resolve({name: 'routeName', query: {data: "someData"}});
      window.open(route.href, "_blank");
    },
    pdfLibrary(fileName) {
      // str.slice(0, -2)
      let removeExt = fileName.slice(0, -4);
      let params = `/storage/pdfjs/web/viewer.html?${removeExt}`;
      console.log(fileName);

      // this.$store.dispatch('getJson', payload);
      // let route = this.$router.resolve({name: 'routeName', query: {data: "someData"}});
      window.open(params, "_blank");
    },
    getPath() {
      axios.get("/api/template/get-path").then((response) => {
        this.pathFile = response.data.data.path;
        console.log(this.pathFile);
      });
    },
    downloadedFile(filename) {
      let formData = {
        click: "Download",
      };

      axios
        .post("/api/upload-form/increments/" + this.id, formData)
        .then((res) => {
          console.log(res.data.data);
          if (res) {
            var file_path =
              "/storage/uploads/file_upload/" + filename.file_name;
            var a = document.createElement("A");
            a.href = file_path;
            a.download = file_path.substr(file_path.lastIndexOf("/") + 1);
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            // this.reGetSubmission();
          }
        });
    },
    readFile(filename) {
      // --- view PDF with browser default setting & without IDM force download (On Page) ---
      // var file_path = "/storage/uploads/file_upload/" + filename.file_name;
      // var obj = document.createElement('object');
      // obj.style.width = '100%';
      // obj.style.height = '530pt';
      // obj.type = 'application/pdf';
      // obj.data = file_path;
      // window.open(obj);
      // document.getElementById("pdf-view").appendChild(obj);

      let formData = {
        click: "View",
      };

      axios
        .post("/api/upload-form/increments/" + this.id, formData)
        .then((res) => {
          console.log(res.data.data);
          if (res) {
            // --- view PDF with browser default setting & without IDM force download (Off Page) ---
            var file_path =
              "/storage/uploads/file_upload/" + filename.file_name;
            window.open(file_path, "fullscreen=yes");

            // this.reGetSubmission();
          }
        });
    },

    toDetailCategory(id) {
      this.updated = true;
      axios.get("/api/category/" + id).then((res) => {
        this.category_name = res.data.data.category.category_name;
      });
    },
    toDetailLanguage(id) {
      this.updated = true;
      axios.get("/api/language/" + id).then((res) => {
        this.language = res.data.data.language.language_name;
      });
    },
    getDetailSubmission() {
      this.loading = true;
      axios.get("/api/upload-form/" + this.id).then((res) => {
        this.submissions = res.data.data.form;

        var datArr = this.submissions.total_download.split("-");
        this.tDownload = datArr[0];
        this.tView = datArr[1];

        this.loading = false;
        this.toDetailCategory(res.data.data.form.category);
        this.toDetailLanguage(res.data.data.form.language);
        // console.log(this.submissions);
      });
    },
    reGetSubmission() {
      axios.get("/api/upload-form/" + this.id).then((res) => {
        var datArr = this.submissions.total_download.split("-");
        this.tDownload = datArr[0];
        this.tView = datArr[1];
      });
    },

    onDetail() {
      this.showDetail = !this.showDetail;
      console.log(this.showDetail);
    },
  },
};
</script>
