import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/page/Index.vue'

Vue.use(Router);

const list = {
  template: `<h1>Список фильмов по 10</h1>`
};

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
          component: list
        },
        {
          path: 'film',
          component: soloFilm
        }
      ]
    }
  ]
})
