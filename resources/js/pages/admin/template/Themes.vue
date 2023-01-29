<template>
  <div>
    <h3 class="mb-3">Web Management</h3>
    <div class="d-flex justify-content-between mb-5">
      <h4>All Themes: 4</h4>
      <div class="search-box">
        <input
          type="text"
          class="form-control form-control-lg"
          id="search"
          placeholder="Search"
        />
        <i class="fa fa-solid fa-search d-flex justify-content-end pr-3"></i>
      </div>
    </div>
    <div class="row">
      <div
        class="col-3"
        v-for="(theme, index) in themes"
        :key="'theme-' + index"
      >
        <div class="theme-card">
          <div class="theme-data p-3">
            <h4>{{ theme.name }}</h4>
            <p>{{ theme.isActive && "Active" }}</p>
          </div>
        </div>
      </div>
    </div>
    <input type="file" v-show="false" ref="file" />
    <button
      @click="addTheme()"
      class="btn pmd-btn-fab pmd-ripple-effect btn-primary pmd-btn-raised add-button"
      type="button"
    >
      <i class="material-icons pmd-sm">add</i>
    </button>
  </div>
</template>

<script>
export default {
  name: "Themes",
  data() {
    return {
      themes: [
        {
          name: "Theme 1",
          isActive: true,
        },
        {
          name: "Theme 2",
          isActive: true,
        },
        {
          name: "Theme 3",
          isActive: true,
        },
        {
          name: "Theme 4",
          isActive: true,
        },
        {
          name: "Theme 5",
          isActive: true,
        },
        {
          name: "Theme 6",
          isActive: true,
        },
        {
          name: "Theme 7",
          isActive: true,
        },
      ],
    };
  },
  methods: {
    addTheme() {
      this.$refs.file.click();
    },
  },
};
</script>

<style>
.theme-card {
  width: 100%;
  height: 20rem;
  border: 2px solid #c2c2c2;
  border-radius: 0.5rem;
  background-color: #00d2e3;
  margin-bottom: 2rem;
  display: flex;
  flex-direction: column;
  justify-content: end;
}

.theme-card > .theme-data {
  color: black;
  background-color: white;
}

.theme-card > .theme-data > p {
  color: grey;
}

.search-box {
  display: grid;
  grid-template-columns: 2fr 1fr;
  align-content: center;
  align-items: center;
  width: 20vw;
  height: 3.1rem;
  border-radius: 0.5rem;
  border: 1px solid #afafaf;
  align-content: center;
}
.search-box > .form-control {
  border: 0;
  outline: none;
  height: 2rem;
  background-color: transparent;
  box-shadow: none;
}

.add-button {
  border-radius: 50%;
  font-size: 20px;
  font-weight: 600;
  width: 4rem;
  height: 4rem;
  position: absolute;
  bottom: 4rem;
  right: 4rem;
}
</style>
