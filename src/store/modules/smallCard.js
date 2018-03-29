import * as types from '../mutation-types.js';
import connectIndexedDB from '../../MiniOrm';
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
      .catch(err => {
        connectIndexedDB.getAll(function (evt) {
          commit(types.SET_FILM_ITEMS, {items: {filmList: evt.target.result}})
        })
      });

  },

  getFilm({commit, state}, id, isDisabledNetwork = false) {

    let film = false;
    let self = this;

    // if(isDisabledNetwork)
    for (let i in state.all.filmList) {
      if (state.all.filmList[i].imdbid === id) {
        film = state.all.filmList[i];
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

          if(data.data.findFlag) {
            connectIndexedDB.connect
              .then(evt => {
                connectIndexedDB.openTransaction().put(data.data[0]);
              });
          }

          return data.data[0]
        })
        .catch(err => {
            if(err.message === 'Network Error') {
              connectIndexedDB.connect
                .then(evt => {
                  console.log(`id = ${id}`);
                  connectIndexedDB.openTransaction().get(id).onsuccess = function (indexedData) {
                    commit(types.SET_FILM, {film: indexedData.target.result})
                  };
                });
            }
        })
        .then(data => {
          commit(types.SET_FILM, {film: data});
        })
        .catch(err => console.error(err.message));
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
