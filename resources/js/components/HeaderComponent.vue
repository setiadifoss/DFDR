<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primer p-4">
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarTogglerDemo02"
        aria-controls="navbarTogglerDemo02"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse row" id="navbarTogglerDemo02">
        <div class="col d-flex">
          <img :src="logo" alt="logo" class="mr-3" />
          <div class="pt-2">
            <h4>Repository Institution</h4>
            <h4>PKTJ</h4>
          </div>
        </div>
        <div class="col">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0 row justify-content-end">
            <li class="nav-item">
              <router-link :to="{ name: 'Homepage' }" class="nav-link"
                >Home</router-link
              >
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'DescSubmission' }" class="nav-link"
                >Submissions</router-link
              >
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'About' }" class="nav-link"
                >About</router-link
              >
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'Contact' }" class="nav-link"
                >Contact</router-link
              >
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'Login' }" class="nav-link"
                >Login</router-link
              >
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'Register' }" class="nav-link"
                >Register</router-link
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
import logo from "../../../assets/logo.svg";

export default {
  name: "HeaderComponent",
  data() {
    return {
      header: null,
      logo: logo,
    };
  },
  methods: {
    getHeader() {
      axios.get("/api/template/home/1").then((response) => {
        this.header = response.data.data.content;
      });
    },
  },
  created() {
    this.getHeader();
  },
};
</script>
<style>
* {
  font-family: "Roboto", sans-serif;
}
.bg-primer {
  background-color: #184d47;
  color: white;
}

h4 {
  font-weight: 450;
}

.navbar {
  font-weight: 300;
  letter-spacing: 0.01rem;
  font-size: 0.9rem;
}

.nav-item {
  margin-right: 1rem;
  margin-left: 1rem;
}
</style>
