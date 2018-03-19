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
  disableNetwork: {
    filmList: {
      0: {
        awards:"Nominated for 1 Oscar. Another 77 wins & 170 nominations.",
        created_at:"2018-02-20 21:23:55",
        director:"Nicolas Winding Refn",
        id:1,
        imdbid:"tt0780504",
        imdbrating:7.8,
        plot:"Лучший",
        poster:"ag3OeKn0E5CTUNU8xW3354TvpcMIXI2A.jpg",
        poster_color:"000000",
        rated:"R",
        ratings:'[{"Value": "7.8/10", "Source": "Internet Movie Database"}, {"Value": "93%", "Source": "Rotten Tomatoes"}, {"Value": "78/100", "Source": "Metacritic"}]',
        released:"2011-09-16",
        runtime:100,
        title:"Drive",
        updated_at:"2018-02-20 21:23:55",
        year:2011,
      }
    },
  }
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
  },
  getStaticFilm: function (state) {
    return state.disableNetwork;
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
        console.log(err);
        commit(types.SET_FILM_ITEMS, {items: state.disableNetwork});
      });

  },

  getFilm({commit, state}, id) {

    let film = false;
    let self = this;

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
          console.log(self);
          let connectDB = new self.$connectIndexedDB();
          connectDB.connect.then((evt) => {
            console.log(evt);
          });

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
