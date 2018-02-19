import * as types from '../mutation-types.js';
import {API_MY_LIST, API_MY_FIND_FILM} from '@/config.js';
import axios from 'axios';

// init state
// информация приложеия \ модуля
const state = {
  all: {
    filmList: {},
    countPage: 0
  },
  currentPage: 1,
  film: false,
};

// getters
// обычно используется для возвращения состояний
const getters = {
  allFilms: function (state) {
    return state.all;
  },
  getCurrentPage: function (state) {
    return state.currentPage;
  },
  getFilm: function (state) {
    return state.film;
  }
};

// actions
// используется для получения информации и так далее.
// так как только в нем позволены асинхронные методы (обращения к api и так далее)
// обычно делают какую то логику и вызывают mutations, что бы переписать состояния
const actions = {
  getAllFilms({commit, state}) {

    axios.get(API_MY_LIST + state.currentPage)
      .then(data => {
        return data.data
      })
      .then(data => {
        commit(types.SET_FILM_ITEMS, {items: data});
      })
      .catch(err => console.log(err));

  },

  getFilm({commit, state}, id) {

    let film = false;

    for (let i in state.all) {
      if (state.all[i].imdbid === id) {
        film = state.all[i];
        commit(types.SET_FILM, {film: film});
        return null;
      }
    }

    if(!film) {
      axios({
        url: API_MY_FIND_FILM + id,
        headers: {"Access-Control-Allow-Origin": "topfilmsapi.com/"},
      })
        .then(data => {
          return data.data
        })
        .then(data => {
          commit(types.SET_FILM, {film: data});
        })
        .catch(err => console.log(err));
    }

  }
};

// mutations
// используется для изменения состояний. Не могуть быть асинхроными.
const mutations = {

  [types.SET_FILM_ITEMS](state, {items}) {
    state.all.filmList = Object.assign({}, state.all.filmList, items.filmList);
    state.all.countPage = items.countPage;
  },

  [types.INCREMENT_CURRENT_PAGE](state) {
    ++state.currentPage;
  },

  [types.SET_FILM](state, {film}) {
    state.film = film;
  }

};

export default {
  state,
  getters,
  actions,
  mutations
}
