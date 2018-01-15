// init state
// информация приложеия \ модуля
const state = {
  all: [],
};

// getters
// обычно используется для возвращения состояний
const getters = {
  allFilms: state => state.all
};

// actions
// используется для получения информации и так далее.
// так как только в нем позволены асинхронные методы (обращения к api и так далее)
// обычно делают какую то логику и вызывают mutations, что бы переписать состояния
const actions = {
  getAllFilms () {
    commit('setFilmList', { listFilms })
  }
};

// mutations
// используется для изменения состояний. Не могуть быть асинхроными.
const mutations = {
  setFilmList (state, { listFilms }) {
    state.all = listFilms;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
}
