<template>
  <div>
    <div
      class="container-fluid bg-primer pb-0 mb-0 justify-content-center text-light "
    >
      <footer>
        <div class="row my-1 justify-content-center pt-4">
          <div class="col-12 px-5">
            <div class="row mb-5" style="align-items: center">
              <img :src="logo" alt="logo" class="mr-3" />
              <div class="pt-2">
                <h4>Repository Institution PKTJ</h4>
              </div>
            </div>
            <div class="row mb-4">
              <!-- <div class="col-xl-8 col-md-4 col-sm-4 col-12 mx-auto a">
                <h3 class="text-muted mb-md-0 mb-2 bold-text">
                  <b v-html="title"></b>
                </h3>
                <br />

                <img
                  v-for="(fi, i) in footerImage"
                  :key="i"
                  :src="getPath(fi.path)"
                  alt="."
                  style="width: 34%;margin:10px 0px:padding:30px"
                />
              </div> -->
              <div class="col-xl-2 col-md-4 col-sm-4 col-12">
                <h5 class="mb-3 mb-lg-5"><b>Menu</b></h5>
                <ul class="list-unstyled">
                  <li
                    v-for="(item, index) in menus"
                    :key="'menu-' + index"
                    class="my-4"
                  >
                    <router-link :to="{ name: item.to }">{{
                      item.text
                    }}</router-link>
                  </li>
                </ul>
              </div>
              <div class="col-xl-2 col-md-4 col-sm-4 col-12">
                <h5 class="mb-3 mb-lg-5"><b>Category</b></h5>
                <ul class="list-unstyled">
                  <li
                    style="cursor: pointer"
                    v-for="(item, index) in categories"
                    :key="'menu-' + index"
                    class="my-4"
                    v-on:click.prevent="onCollections(item.value)"
                  >
                    <span>{{ item.text }}</span>
                  </li>
                </ul>
              </div>
              <div class="col-xl-4 col-md-4 col-sm-4 col-12">
                <h5 class="mb-3 mb-lg-4 mt-sm-0 mt-5">
                  <b>Address</b>
                </h5>
                <p class="address-title" v-html="address.title"></p>
                <p class="address-detail" v-html="address.detail"></p>
              </div>
            </div>
            <div class="row">
              <div
                class="col-xl-12 col-md-4 col-sm-4 col-auto my-md-0 mt-5 order-sm-1 order-3 align-self-end d-flex justify-content-center"
              >
                <small class="rights"
                  ><span>&#174;</span> Framework Digital Repository All Rights
                  Reserved.</small
                >
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
</template>
<script>
import logo from "../../../assets/logo.svg";

export default {
  name: "FooterComponent",
  data() {
    return {
      emails: null,
      logo: logo,
      address: null,
      title: null,
      footerImage: null,
      menus: [
        {
          text: "Home",
          to: "Homepage",
        },
        {
          text: "Submission",
          to: "DescSubmission",
        },
        {
          text: "About",
          to: "About",
        },
        {
          text: "Contact",
          to: "Contact",
        },
      ],
      categories: [
        {
          text: "Conference",
          value: 3,
        },
        {
          text: "Bachelor",
          value: 10,
        },
        {
          text: "Thesis Master",
          value: 11,
        },
        {
          text: "Dissertation",
          value: 12,
        },
        {
          text: "Material Review",
          value: 13,
        },
      ],
      address: {
        title: "Politeknik Keselamatan Transportasi Jalan",
        detail:
          "Jl. Perintis Kemerdekaan No. 17, Slerok, Kec. Tegal Timur, Kota Tegal, Jawa Tengah 52125",
      },
    };
  },
  methods: {
    onCollections(val) {
      this.$router.push({
        name: "SubmissionFilter",
        params: { keySearch: val, part: "Collection" },
      });
    },
    getFooterImage() {
      axios.get("/api/template/footer-image").then((response) => {
        this.footerImage = response.data.data;
      });
    },
    getPath(link) {
      var filename = link.substring(link.lastIndexOf("/") + 1);
      let file_path = "/storage/uploads/file_upload/" + filename;
      return file_path;
    },
    getAddress() {
      axios.get("/api/template/home/5").then((response) => {
        this.address = response.data.data.content;
      });
    },
    getTitle() {
      axios.get("/api/template/home/1").then((response) => {
        this.title = response.data.data.content;
      });
    },
    getEmails() {
      axios.get("/api/template/home/4").then((response) => {
        this.emails = response.data.data;
      });
    },
  },
  created() {
    this.getFooterImage();
    // this.getAddress();
    this.getTitle();
    this.getEmails();
  },
};
</script>
<style scoped>
.bg-primer {
  background-color: #184d47;
  color: white;
}
.address-title {
  font-size: 1.2rem;
}
.address-detail {
  font-size: 1rem;
}
/* @import url("https://fonts.googleapis.com/css?family=Rubik&display=swap"); */
.container-fluid {
  overflow: hidden;
  color: #f5f6fa !important;
  margin-bottom: 0;
  padding-bottom: 0;
}

.container-fluid a {
  color: #f5f6fa !important;
}

small {
  font-size: calc(
    12px + (15 - 12) * ((100vw - 360px) / (1600 - 360))
  ) !important;
}

.mt-55 {
  margin-top: calc(
    50px + (60 - 50) * ((100vw - 360px) / (1600 - 360))
  ) !important;
}

h3 {
  font-size: calc(
    34px + (40 - 34) * ((100vw - 360px) / (1600 - 360))
  ) !important;
}

h4,
h5 {
  color: #96bb7c;
}

.social {
  font-size: 21px !important;
}

.rights {
  font-size: calc(
    10px + (12 - 10) * ((100vw - 360px) / (1600 - 360))
  ) !important;
}
</style>
