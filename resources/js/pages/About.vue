<template>
  <div>
    <div class="container-fluid">
      <section id="tabs">
        <div class="p-4">
          <div class="card-body">
            <div class="container mt-4">
              <h6 class="section-title h1 text-center">About Us</h6>
              <div class="row mb-5">
                <div
                  @click="isShow.about = !isShow.about"
                  class="col d-flex justify-content-between accordion-header"
                >
                  <h5 class="font-weight-bold">
                    What is Repository Institution PKTJ?
                  </h5>
                  <i class="fa fa-chevron-down" v-if="!isShow.about"></i>
                  <i class="fa fa-chevron-up" v-if="isShow.about"></i>
                </div>
                <div v-if="isShow.about" class="px-2">
                  <p>
                    Digital Repository adalah wadah untuk menampung karya-karya
                    intelektual dan materi ilmiah para civitas akademika di
                    Politeknik Keselamatan Transportasi Jalan dalam format
                    digital yang dapat diakses secara online
                  </p>
                </div>
              </div>
              <div class="row mb-5">
                <div
                  @click="isShow.whoUse = !isShow.whoUse"
                  class="col d-flex justify-content-between accordion-header"
                >
                  <h5 class="font-weight-bold">
                    Who use Repository Institution PKTJ?
                  </h5>
                  <i class="fa fa-chevron-down" v-if="!isShow.whoUse"></i>
                  <i class="fa fa-chevron-up" v-if="isShow.whoUse"></i>
                </div>
                <div v-if="isShow.whoUse" class="px-2">
                  <p>
                    Dengan menggunakan digital repository milik Perpustakaan
                    Politeknik Keselamatan Transportasi Jalan maka pihak kita
                    bisa :
                  </p>
                  <ol type="1">
                    <li>
                      Menghimpun hasil karya seluruh civitas akademika sehingga
                      dapat terdata dan terdigitalisasi sehingga tidak tercecer.
                    </li>
                    <li>
                      Civitas akademika dapat terus melihat hasil karya
                      intelektual dan materi ilmiah yang telah mereka buat di
                      Politeknik Keselamatan Transportasi Jalan tanpa takut
                      hilang.
                    </li>
                    <li>
                      Memperkaya koleksi Perpustakaan Politeknik Keselamatan
                      Transportasi Jalan.
                    </li>
                  </ol>
                </div>
              </div>
              <div class="row mb-5 d-block">
                <div
                  @click="isShow.offer = !isShow.offer"
                  class="col d-flex justify-content-between accordion-header"
                >
                  <h5 class="font-weight-bold">
                    Repository Institution PKTJ Service Offering
                  </h5>
                  <i class="fa fa-chevron-down" v-if="!isShow.offer"></i>
                  <i class="fa fa-chevron-up" v-if="isShow.offer"></i>
                </div>
                <div v-if="isShow.offer" class="px-2">
                  <p>
                    Digital Repository PKTJ
                  </p>
                </div>
              </div>
              <!-- <div class="row">
                <div class="col-xs-12">
                  <nav>
                    <div
                      class="nav nav-tabs nav-fill"
                      id="nav-tab"
                      role="tablist"
                    >
                      <a
                        class="nav-item nav-link active"
                        id="nav-home-tab"
                        data-toggle="tab"
                        href="#nav-home"
                        role="tab"
                        aria-controls="nav-home"
                        aria-selected="true"
                        >What is
                        <p v-html="header"></p>
                        ?</a
                      >
                      <a
                        class="nav-item nav-link"
                        id="nav-profile-tab"
                        data-toggle="tab"
                        href="#nav-profile"
                        role="tab"
                        aria-controls="nav-profile"
                        aria-selected="false"
                        >Why use
                        <p v-html="header"></p>
                        ?</a
                      >
                      <a
                        class="nav-item nav-link"
                        id="nav-contact-tab"
                        data-toggle="tab"
                        href="#nav-contact"
                        role="tab"
                        aria-controls="nav-contact"
                        aria-selected="false"
                        ><p v-html="header"></p>
                        Service Offerings</a
                      >
                    </div>
                  </nav>
                  <div
                    class="tab-content py-3 px-3 px-sm-0"
                    id="nav-tabContent"
                  >
                    <div
                      class="tab-pane fade show active"
                      id="nav-home"
                      role="tabpanel"
                      aria-labelledby="nav-home-tab"
                    >
                      <p v-html="what_is"></p>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="nav-profile"
                      role="tabpanel"
                      aria-labelledby="nav-profile-tab"
                    >
                      <p v-html="why_we_use"></p>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="nav-contact"
                      role="tabpanel"
                      aria-labelledby="nav-contact-tab"
                    >
                      <p v-html="service_offering"></p>
                    </div>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>
<script>
export default {
  name: "AboutComponent",
  data() {
    return {
      what_is: null,
      why_we_use: null,
      service_offering: null,
      header: null,
      description: null,
      isShow: {
        about: true,
        whoUse: true,
        offer: true,
      },
    };
  },
  methods: {
    getHeader() {
      axios.get("/api/template/home/1").then((response) => {
        this.header = response.data.data.content;
      });
    },
    getDescription() {
      axios.get("/api/template/home/2").then((response) => {
        this.description = response.data.data.content;
      });
    },
    getAboutUs(contentId) {
      axios.get(`/api/template/about-us/${contentId}`).then((response) => {
        switch (contentId) {
          case 1:
            this.what_is = response.data.data.content;
            break;
          case 2:
            this.why_we_use = response.data.data.content;
            break;
          case 3:
            this.service_offering = response.data.data.content;
            break;

          default:
            break;
        }
      });
    },
  },
  created() {
    this.getHeader();
    this.getAboutUs(1);
    this.getAboutUs(2);
    this.getAboutUs(3);
  },
};
</script>

<style scoped>
section .section-title {
  text-align: start;
  color: #007b5e;
  margin-bottom: 50px;
  /* text-transform: uppercase; */
}
.active {
  font-weight: normal !important;
}

.accordion-header {
  cursor: pointer;
}

#tabs {
  /* background: #007b5e; */
  color: #2f3542;
}
#tabs h6.section-title {
  color: #2f3542;
}

#tabs .nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
  color: #184d47;
  background-color: transparent;
  border-color: transparent transparent #184d47;
  border-bottom: 4px solid !important;
  font-size: 20px;
  font-weight: bold;
}
#tabs .nav-tabs .nav-link {
  border: 1px solid transparent;
  border-top-left-radius: 0.25rem;
  border-top-right-radius: 0.25rem;
  color: #2f3542;
  font-size: 20px;
}
</style>
