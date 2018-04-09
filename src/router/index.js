import Vue from 'vue'
import Router from 'vue-router'
import FilmList from '@/components/FilmList.vue'
import Film from '@/components/Film.vue'
import Login from '@/components/auth/Login.vue'
import Registration from '@/components/auth/Registration.vue'
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
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
      path: '/registration',
      name: 'registration',
      component: Registration,
    },
  ]
})
