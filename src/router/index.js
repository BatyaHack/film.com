import Vue from 'vue'
import Router from 'vue-router'
import FilmList from '@/components/FilmList.vue'
import Film from '@/components/Film.vue'
import {mapGetters} from 'vuex'
import store from '../store/index.js'


Vue.use(Router);
Vue.use(store);

const soloFilm = {
  template: `<h1>Один фильм</h1>`
};


export default new Router({
routes: [
    {
      path: '/',
      component: FilmList,
      children: [
        {
          path: '/film/:filmID',
          name: 'film',
          component: Film,
          props: (route) => {
            return { filmID: route.params.filmID };
          },
        }
      ]
    }
  ]
})
