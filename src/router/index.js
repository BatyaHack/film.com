import Vue from 'vue'
import Router from 'vue-router'
import FilmList from '@/components/FilmList.vue'
import Film from '@/components/Film.vue'
import {mapGetters} from 'vuex'
import store from '../store/index.js'


Vue.use(Router);
Vue.use(store);


export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: FilmList,
    },
    {
      path: '/film/:filmID',
      name: 'film',
      component: Film,
      props: (route) => {
        // console.log(route.params.filmID);
        return {filmID: route.params.filmID};
      },
    }
  ]
})
