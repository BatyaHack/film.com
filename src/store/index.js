import Vue from 'vue'
import Vuex from 'vuex'
import smallCard from './modules/smallCard.js'
import user from './modules/user.js'
import * as actions from './actions.js'
import * as mutations from './mutations.js'

Vue.use(Vuex);


export default new Vuex.Store({
  modules: {
    smallCard,
    user
  }
})
