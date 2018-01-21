import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/page/Index.vue'
import FilmList from '@/components/FilmList.vue'
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
      name: 'Index',
      component: Index,
      children: [
        {
          path: '',
          component: FilmList,
        },
        {
          path: 'film',
          component: soloFilm,
        }
      ]
    }
  ]
})
