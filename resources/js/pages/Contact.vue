<template>
  <div class="jumbotron">
    <div class="container">
      <div
        class="row justify-content-center"
        style="padding: 3rem; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px; background-color: white; border-radius: .3rem;"
      >
        <div class="col">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15844.692444718597!2d109.11491088796437!3d-6.869849916876277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fbfcb9d0bfb8f%3A0x6d0465b97b0034a5!2sPoliteknik%20Keselamatan%20Transportasi%20Jalan!5e0!3m2!1sid!2sid!4v1672239252299!5m2!1sid!2sid"
            width="400"
            height="310"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
        <div class="col">
          <div>
            <div class="px-4 py-4">
              <h6 class="text-dark mb-3 mb-lg-4 bold-text mt-sm-0 mt-5">
                <b>ADDRESS</b>
              </h6>
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
