import * as types from '../mutation-types.js';
import {API_MY_LIST} from '@/config.js';
import axios from 'axios';

// init state
// информация приложеия \ модуля
const state = {
  all: [],
};

// getters
// обычно используется для возвращения состояний
const getters = {
  allFilms: function (state) {
    console.log(state);
    return state.all;
  }
};

// actions
// используется для получения информации и так далее.
// так как только в нем позволены асинхронные методы (обращения к api и так далее)
// обычно делают какую то логику и вызывают mutations, что бы переписать состояния
const actions = {
  getAllFilms({commit, state}) {

    axios.get(API_MY_LIST)
      .then(data => { return data.data} )
      .then(data => commit(types.SET_FILM_ITEMS, {items: data}))
      .catch(console.log("Все пропало!"));

  }
};

// mutations
// используется для изменения состояний. Не могуть быть асинхроными.
const mutations = {
  [types.SET_FILM_ITEMS](state, {items}) {
    state.all = items;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
}
