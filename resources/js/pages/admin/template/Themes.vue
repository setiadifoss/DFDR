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
</style>
