<template>
  <div>
    <h1>Заголовок чего то там!!!</h1>
    <ul>
      <li v-for="(film, index) in films" :key="index">
        <div :style="{
          width: 100 + 'px',
          height: 100 + 'px',
          background: `#${film['poster_color']} url(${staticImg + film.poster})`,
        }">

        </div>
        {{film.title}}
      </li>
    </ul>
    <button @click.prevent="showFilmList">Дави</button>
  </div>
</template>

<script>

  import {mapGetters} from 'vuex';
  import {API_MY_STATIC_PATH} from '@/config.js';

  export default {
    computed: mapGetters({
      films: 'allFilms'
    }),
    data() {
      return {
        staticImg: API_MY_STATIC_PATH,
      }
    },
    created: function () {
      this.$store.dispatch('getAllFilms');
      console.log(this.films);
    },
    methods: {}
  }

</script>

<style lang="scss">

</style>
