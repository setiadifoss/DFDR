<template>
  <div>
    <div class="row">
      <div class="col-4">
        <img :src="campusImage" alt="campus-image" />
      </div>
      <div class="col" style="margin: auto">
        <div class="row">
          <div class="col-3"></div>
          <div class="col-5">
            <h3
              class="font-weight-bold"
              style="color: #184d47; margin-bottom: 2rem"
            >
              Login
            </h3>
            <form>
              <div class="form-group" style="margin-bottom: 2rem">
                <label for="email" class="font-weight-bold text-dark"
                  >Email</label
                >
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  aria-describedby="emailHelp"
                  placeholder="Type your email.."
                  v-model="form.email"
                />
                <!-- <small id="emailHelp" class="form-text text-muted"
                    >We'll never share your email with anyone else.</small> -->
              </div>
              <div class="form-group">
                <label for="password" class="font-weight-bold text-dark"
                  >Password</label
                >
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  placeholder="Type your password.."
                  v-model="form.password"
                />
                <small>
                  <router-link
                    :to="{ name: 'ForgotPassword' }"
                    class="form-text float-right"
                  >
                    Forgot Password?
                  </router-link>
                </small>
              </div>
              <!-- <div class="form-group"> -->
              <!-- <a href="">Lupa Password?</a> -->

              <!-- </div> -->
              <div class="form-group" style="margin-top: 50px;">
                <button
                  type="submit"
                  class="btn btn-primary btn-block bg-blue"
                  v-on:click.prevent="handleLogin()"
                >
                  Login
                </button>
              </div>
            </form>
            <p class="text-dark text-center d-flex justify-content-center">
              No have an account?
              <router-link :to="{ name: 'Register' }" class="nav-link p-0 pl-2"
                ><span class="font-weight-bold align-middle text-dark"
                  >Register</span
                ></router-link
              >
            </p>
          </div>
          <div class="col"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import campus from "../../../assets/campus_photo.svg";
export default {
  data() {
    return {
      campusImage: campus,
      form: {
        email: "",
        password: "",
      },
    };
  },
  mounted() {},

  methods: {
    handleLogin() {
      console.log("clicked");
      let email = this.form.email;
      let password = this.form.password;
      this.$store
        .dispatch("postLogin", { email, password })
        .then((res) => {
          // console.log(res);
          if (localStorage.getItem("role") == "Editor") {
            this.$router.push("/my-upload").then(() => {
              window.location.reload();
            });
          } else if (
            localStorage.getItem("role") == "Admin" ||
            localStorage.getItem("role") == "User"
          ) {
            this.$router.push("/dashboard").then(() => {
              window.location.reload();
            });
          }
        })
        .catch((err) => {
          Vue.swal({
            icon: "error",
            title: "Login Error!",
            text: "Please check your account activation or login data",
          });
          console.log(err);
        });
    },
  },
};
</script>
