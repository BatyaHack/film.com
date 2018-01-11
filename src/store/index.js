import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions.js'
import * as mutations from './mutations.js'

Vue.use(Vuex);


export default new Vuex.Store({
  state: {
    count: 100,
  },
  mutations: {
    increment (state) {
      state.count++;
    }
  }
})
