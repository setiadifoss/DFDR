<template>
  <div class="py-5">
    <!-- jumbotron -->
    <div class="row jumbotron-data">
      <div class="col pl-5">
        <h2 class="text-dark font-weight-bold mb-4">
          What is Repository <br />
          Institution PKTJ?
        </h2>
        <p class="repo-desc">
          Digital Repository adalah wadah untuk menampung karya-karya
          intelektual dan materi ilmiah para civitas akademika di Politeknik
          Keselamatan Transportasi Jalan dalam format digital yang dapat diakses
          secara online
        </p>
        <button
          type="submit"
          class="btn btn-primary btn-block bg-blue btn-md"
          style="width: 10rem; font-size: 0.9rem; font-weight: 600"
          v-on:click.prevent="toSearch()"
        >
          <p>Search Repository</p>
        </button>
      </div>
      <div class="col">
        <iframe
          width="664"
          height="384"
          style="border-radius: 5px"
          class="embed-responsive-item"
          :src="toEmbed('https://www.youtube.com/watch?v=T4gsroyZGk4')"
          allowfullscreen
        ></iframe>
      </div>
    </div>
    <!-- search box -->
    <div
      id="search-section"
      class="row d-flex justify-content-center text-dark font-weight-bold mb-3"
    >
      <h3>Repository Institution PKTJ</h3>
    </div>
    <div class="row d-flex justify-content-center" style="margin-bottom: 5rem">
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
    </div>
    <!-- categories -->
    <div
      class="row d-flex justify-content-center text-dark font-weight-bold mb-3"
    >
      <h3>Category</h3>
    </div>
    <div class="row d-flex justify-content-center mb-5">
      <div
        class="category-card"
        @click="onCollections(item.value)"
        v-for="(item, index) in categories"
        :key="'card-' + index"
      >
        <i :class="item.icon" class="category-icon"></i>
        <h6>{{ item.text }}</h6>
      </div>
    </div>

    <!-- Contributors and News -->
    <div class="row news-section">
      <div class="col-5">
        <h4>Contributors</h4>
        <div
          class="news-card"
          @click="onContributors(item.name)"
          v-for="(item, index) in contributors"
          :key="'contributor-' + index"
        >
          <div class="row">
            <div class="col-1">
              <i class="fa fa-solid fa-graduation-cap"></i>
            </div>
            <div style="color: #184d47" class="col pl-3 overflow-hidden">
              <h5 class="mb-2">{{ item.degree }}</h5>
              <h6 class="font-weight-bold">{{ item.name }}</h6>
              <p>{{ item.summary }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col"></div>
      <div class="col-5">
        <h4>News</h4>
        <div
          class="news-card"
          @click="onContributors(item.name)"
          v-for="(item, index) in news"
          :key="'news-' + index"
        >
          <div class="row">
            <div class="col-3">
              <img
                :src="'/storage/uploads/news_thumb/' + item.news_thumb_name"
                alt=""
                class="news-image"
              />
            </div>
            <div style="color: #184d47" class="col pl-3">
              <h5>
                <router-link
                  :to="{
                    name: 'Detailnews',
                    params: { id: item.id },
                  }"
                  class="news-title"
                  >{{ item.news_title }}</router-link
                >
              </h5>
              <p>{{ item.news_desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div>
      <carousel :per-page="1" :navigationEnabled="true">
        <template v-for="(image, i) in images">
          <slide :key="i">
            <div v-if="image.type == 1">
              <b-img
                :src="getPath(image.path)"
                fluid
                alt="Responsive image"
              ></b-img>
            </div>
            <div v-else>
              <div class="embed-responsive embed-responsive-16by9">
                <iframe
                  class="embed-responsive-item"
                  :src="toEmbed('https://www.youtube.com/watch?v=rYwpku2CBFg')"
                  allowfullscreen
                ></iframe> -->
    <!-- :src="toEmbed(image.path)" -->
    <!-- </div>
            </div>
          </slide>
        </template>

      </carousel>
    </div> -->

    <!-- section jumbotron -->
    <!-- <div class="jumbotron">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form v-on:submit.prevent="onSearch()">
                  <div class="container row mt-3">
                    <div class="col-md-10 col-sm-12 col-xs-12"></div>
                    <div class="col-md-2 col-sm-2">
                      <button
                        type="submit"
                        class="btn btn-primary btn-block bg-blue btn-lg"
                        v-on:click.prevent="onSearch()"
                      >
                        <i class="fa fa-search"></i>
                      </button>
                    </div>

                    <div class="col-md-3">
                      <div>
                        <h5>
                          <i
                            class="fa fa-angle-double-down"
                            style="font-size: 15px"
                          ></i
                          >&nbsp; <strong>Collections</strong>
                        </h5>
                        <ul style="list-style-type: circle" class="mt-2">
                          <li>
                            <p
                              class="cat"
                              style="cursor: pointer"
                              v-on:click.prevent="onCollections(3)"
                            >
                              Conference
                            </p>
                          </li>
                          <li>
                            <p
                              class="cat"
                              style="cursor: pointer"
                              v-on:click.prevent="onCollections(10)"
                            >
                              Bachelor
                            </p>
                          </li>
                          <li>
                            <p
                              class="cat"
                              style="cursor: pointer"
                              v-on:click.prevent="onCollections(11)"
                            >
                              Thesis Master
                            </p>
                          </li>
                          <li>
                            <p
                              class="cat"
                              style="cursor: pointer"
                              v-on:click.prevent="onCollections(12)"
                            >
                              Dissertation
                            </p>
                          </li>
                          <li>
                            <p
                              class="cat"
                              style="cursor: pointer"
                              v-on:click.prevent="onCollections(13)"
                            >
                              Material Review
                            </p>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div>
                        <h5>
                          <i
                            class="fa fa-angle-double-down"
                            style="font-size: 15px"
                          ></i
                          >&nbsp; <strong>Contributors</strong>
                        </h5>
                        <ul style="list-style-type: circle" class="mt-2">
                          <li v-for="(cat, c) in creators.slice(0, 5)" :key="c">
                            <p
                              class="cat"
                              style="cursor: pointer"
                              v-on:click.prevent="onContributors(cat.creator)"
                            >
                              {{ cat.creator }}
                            </p>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div>
                        <h5>
                          <i
                            class="fa fa-angle-double-down"
                            style="font-size: 15px"
                          ></i
                          >&nbsp; <strong>Lates</strong>
                        </h5>
                        <ul style="list-style-type: circle" class="mt-2">
                          <li>
                            <p
                              class="cat"
                              style="cursor: pointer"
                              v-on:click.prevent="onThisMonth()"
                            >
                              Newest Items Added
                            </p>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="row" style="margin-top: 10px">
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-2">
                <div class="card p-2">
                  <div class="card-body">
                    <h5 class="text-center">Submit Content</h5>
                    <div class="row">
                      <div class="col col-md-12 mt-2">
                        <router-link
                          :to="{ name: 'Login' }"
                          class="
                            btn btn-primary btn-sm btn-block
                            margin-top
                            bg-blue
                          "
                          >Login</router-link
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-2">
                <div class="card p-2">
                  <div class="card-body">
                    <h5 class="text-center">Registration</h5>
                    <div class="row">
                      <div class="col-md-12 mt-2">
                        <router-link
                          :to="{ name: 'Register' }"
                          class="btn btn-primary btn-sm btn-block bg-blue"
                          >Register</router-link
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-2">
                <div class="card p-2">
                  <div class="card-body">
                    <h5 class="text-center">About Digital Repository</h5>
                    <div class="row">
                      <div class="col-md-12 mt-2">
                        <router-link
                          :to="{ name: 'About' }"
                          class="btn btn-primary btn-sm btn-block bg-blue"
                          >Learn More</router-link
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
    </div> -->

    <!-- section news -->
    <!-- <div class="container-fluid mt-4 mb-4">
      <div class="row">
        <div class="col-md-3 mt-2">
          <div class="card p-1">
            <div class="card-body">
              <h4 class="text-center">Whats Is <b v-html="title">?</b></h4>
              <p class="text-justify mt-2" v-html="description">
                &nbsp;&nbsp;&nbsp;&nbsp;<b v-html="title"></b>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="text-center" v-if="loading">
            <loading-component></loading-component>
          </div>
          <div v-if="!loading">
            <div class="card mt-2" v-for="(feed, n) in news" :key="n">
              <div class="card-body">
                <div class="row p-2">
                  <div class="col-md-9 p-4">
                    <h4>
                      <router-link
                        :to="{
                          name: 'Detailnews',
                          params: { id: feed.id },
                        }"
                        >{{ feed.news_title }}</router-link
                      >
                    </h4>
                    <div v-html="feed.news_desc"></div>
                  </div>
                  <div class="col-md-3 d-none d-sm-none d-md-block"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
  </div>
</template>

<style scoped>
.repo-desc {
  font-size: 1.2rem;
  margin-bottom: 1.5rem;
  word-wrap: break-word;
  width: 30rem;
}

.jumbotron-data {
  margin-bottom: 8rem;
}

.news-section > .col-5 > h4 {
  color: #184d47;
}

.news-section > .col-5 > .news-card > .row > .col-1 > i {
  font-size: 2rem;
  color: #184d47;
}

.news-title {
  color: #184d47 !important;
}

.news-image {
  width: 90%;
  height: 130px;
}

.news-title:hover {
  color: #184d47 !important;
  text-decoration: none;
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
.card {
  box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
  border-radius: 1rem !important;
}

.category-card {
  cursor: pointer;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 10rem;
  height: 10rem;
  border-radius: 6px;
  margin: auto 0.7rem;
  margin-bottom: 1rem;
  background-color: #96bb7c;
}

.category-card > .category-icon {
  color: #184d47;
  font-size: 4.5rem;
  margin-bottom: 1rem;
}

.category-card > h6 {
  color: #184d47;
  font-weight: 600;
}

.news-card {
  background-color: #e8ecea;
  cursor: pointer;
  height: 11rem;
  padding: 1.5rem 2rem;
  border-radius: 8px;
  margin-bottom: 1rem;
}

img,
video,
object,
embed {
  max-width: 100%;
  height: auto;
  overflow: hidden !important;
}

.btn-primary {
  border-color: transparent;
}
@media only screen and (max-width: 600px) {
  .example {
    margin-top: 30px;
  }
}
</style>
<script>
import { Carousel, Slide } from "vue-carousel";
export default {
  components: {
    Carousel,
    Slide,
  },
  data() {
    return {
      showVideo: false,
      isInstalled: false,
      videoId: null,
      images: [],
      news: [],
      title: null,
      embed: null,
      description: null,
      loading: false,
      slide: 0,
      sliding: null,
      install: true,
      form: {
        search_key: "",
      },
      contributors: [
        {
          degree: "Bachelor",
          name: "Ali Mayzaldi",
          summary:
            "Kajian Penerapan Ruang Henti Khusus Sepeda Motor Dalam Meningkatkan Keselamatan di Simpang Bersinyal Dengan Menggunakan Simulasi Visiim (Studi Kasus Kota Palangkaraya)",
        },
        {
          degree: "Bachelor",
          name: "Dr. Siti Maimunah, S.Si, M.SE,, et al",
          summary:
            "Upaya Peningkatan Keselamatan Jalan pada Simpang Tak Bersinyal dengan Metode Hazard Identification Risk and Assessment (HIRA) Studi Kasus: Simpang 4 Damri Jalan Ahmad Yani Kota Surakarta",
        },
      ],
      categories: [
        {
          text: "Conference",
          icon: "fa fa-solid fa-users",
          value: 3,
        },
        {
          text: "Bachelor",
          icon: "fa fa-solid fa-graduation-cap",
          value: 10,
        },
        {
          text: "Thesis Master",
          icon: "fa fa-solid fa-file",
          value: 11,
        },
        {
          text: "Dissertation",
          icon: "fa fa-solid fa-flask",
          value: 12,
        },
        {
          text: "Material Review",
          icon: "fa fa-solid fa-book-open",
          value: 13,
        },
      ],
    };
  },
  computed: {
    categories() {
      return this.$store.getters.getAllCreator;
    },
    creators() {
      return this.$store.getters.getAllCreator;
    },
  },
  mounted() {
    this.preUsed();
    this.$store.dispatch("getCreator");
    this.getImages();
    this.preAdmin();
    // this.$store.dispatch("getCategory");
    this.getNews();
    this.getDescription();
    this.getHeader();
    // this.getYoutube("https://www.youtube.com/watch?v=qXlZVDA_S_s");

    // console.log(this.creators);

    // console.log("homepage");
  },
  methods: {
    toSearch() {
      const el = document.querySelector("#search-section");
      const input = document.querySelector("#search");
      el.scrollIntoView();
      input.focus();
    },
    toEmbed(url) {
      var str = url;
      var res = str.split("=");
      var embeddedUrl = "https://www.youtube.com/embed/" + res[1];
      // document.getElementById("demo").innerHTML = res;
      this.embed = embeddedUrl;
      return embeddedUrl;
    },
    getYoutube(url) {
      return this.$youtube.getIdFromURL(url);
      this.startTime = this.$youtube.getTimeFromURL(url);
    },
    getPath(link) {
      var filename = link.substring(link.lastIndexOf("/") + 1);
      let file_path = "/storage/uploads/file_upload/" + filename;
      return file_path;
    },
    getImages() {
      axios
        .get("/api/template/images")
        .then((response) => {
          this.images = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    onSlideStart(slide) {
      this.sliding = true;
    },
    onSlideEnd(slide) {
      this.sliding = false;
    },
    getDescription() {
      axios.get("/api/template/home/2").then((response) => {
        this.description = response.data.data.content;
      });
    },
    getHeader() {
      axios.get("/api/template/home/1").then((response) => {
        this.title = response.data.data.content;
      });
    },

    preUsed() {
      // var val;

      axios.get("/api/preUsed").then((res) => {
        console.log(res.data.data);
        this.install = res.data.data.file;

        if (!this.install) {
          window.location.href = "/install";
          // this.$router.push("/install");
        }
      });

      // return val;
    },

    preAdmin() {
      axios.get("/api/preAdmin").then((res) => {
        // console.log(res.data.data);
        var count = res.data.data.data;

        if (count == 0) {
          this.$router.push("/adm-config");
        }
      });
    },

    getNews() {
      this.loading = true;
      axios.get("/api/news").then((res) => {
        this.news = res.data.data.news;
        this.loading = false;
        // console.log(res.data);
      });
    },

    onSearch() {
      this.$router.push({
        name: "SubmissionFilter",
        params: { keySearch: this.form.search_key, part: "Search" },
      });
    },

    onCollections(val) {
      this.$router.push({
        name: "SubmissionFilter",
        params: { keySearch: val, part: "Collection" },
      });
    },

    onThisMonth() {
      this.$router.push({
        name: "SubmissionFilter",
        params: { keySearch: "", part: "This_Month" },
      });
    },

    onContributors(val) {
      this.$router.push({
        name: "SubmissionFilter",
        params: { keySearch: val, part: "Creator" },
      });
    },
  },
};
</script>
