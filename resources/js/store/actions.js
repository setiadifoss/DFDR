//to handle actions
const actions = {
  getUsers({ commit }) {
    axios.get("/api/user").then((response) => {
      commit("SET_USERS", response.data.data.user);
    });
  },
};
