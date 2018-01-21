import * as types from '../mutation-types.js';
import {API_MY_LIST} from '@/config.js';
import axios from 'axios';

// init state
// информация приложеия \ модуля
const state = {
  all: [],
  currentPage: 1,
};

// getters
// обычно используется для возвращения состояний
const getters = {
  allFilms: function (state) {
    return state.all;
  },
  getCurrentPage: function (state) {
    return state.currentPage;
  }
};

// actions
// используется для получения информации и так далее.
// так как только в нем позволены асинхронные методы (обращения к api и так далее)
// обычно делают какую то логику и вызывают mutations, что бы переписать состояния
const actions = {
  getAllFilms({commit, state}) {

    axios.get(API_MY_LIST + state.currentPage)
      .then(data => { return data.data} )
      .then(data => {
        commit(types.SET_FILM_ITEMS, {items: data});
      })
      .catch(err => console.log(err));

  }
};

// mutations
// используется для изменения состояний. Не могуть быть асинхроными.
const mutations = {

  [types.SET_FILM_ITEMS](state, {items}) {
    state.all = Object.assign({}, state.all, items);
  },

  [types.INCREMENT_CURRENT_PAGE](state) {
    ++state.currentPage;
  }

};

export default {
  state,
  getters,
  actions,
  mutations
}
