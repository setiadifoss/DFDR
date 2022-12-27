<template>
  <div class="jumbotron">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12 col-xs-12">
          <div
            class="card"
            style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;"
          >
            <div class="px-4 py-4">
              <h6 class="text-dark mb-3 mb-lg-4 bold-text mt-sm-0 mt-5">
                <b>ADDRESS</b>
              </h6>
              <!-- <p class="mb-1" v-html="address"></p> -->
              <p class="text-dark">
                <b>Politeknik Keselamatan Transportasi Jalan</b>
              </p>
              <p class="mb-4">
                Jl. Perintis Kemerdekaan No. 17, Slerok, Kec, Tegal Timur, Kota
                Tegal, Jawa Tengah 52125
              </p>
              <div
                v-for="(item, index) in contacts"
                :key="'contact-' + index"
                class="d-flex mb-2"
              >
                <i :class="item.icon" class="mr-3"></i>
                <p>{{ item.text }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import pdf from "vue-pdf";
// import "pdfjs-dist/build/pdf.worker.entry";

export default {
  components: {
    pdf,
  },

  data() {
    return {
      address: null,
      contacts: [
        {
          text: "library@pktj.ac.id",
          icon: "fa fa-solid fa-envelope",
        },
        {
          text: "library.pktj.ac.id",
          icon: "fa fa-solid fa-mouse-pointer",
        },
        {
          text: "(0283) 351061",
          icon: "fa fa-solid fa-phone",
        },
        {
          text: "(0283) 358965",
          icon: "fa fa-solid fa-download",
        },
      ],
    };
  },
  created() {
    this.getContact(1);
  },
  methods: {
    getContact(contentId) {
      axios.get("/api/template/contact/" + contentId).then((response) => {
        this.address = response.data.data.content;
      });
    },
  },
};
</script>
