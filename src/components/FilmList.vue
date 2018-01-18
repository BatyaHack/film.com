<template>
  <div>
    <h1>Заголовок чего то там!!!</h1>
    <ul>
      <li v-for="(film, index) in films" :key="index">
        <div :style="{width: 100 + 'px', height: 100 + 'px', backgroundColor: '#' + film['poster_color']}">

        </div>
        {{film['poster_color']}}
        {{film.title}}
      </li>
    </ul>
    <button @click.prevent="showFilmList">Дави</button>
  </div>
</template>

<script>

  import {mapGetters} from 'vuex';

  export default {
    computed: mapGetters({
      films: 'allFilms'
    }),
    created: function () {
      this.$store.dispatch('getAllFilms');
    },
    methods: {
      showFilmList: function () {
        console.log(this.films);
      }
    }
  }

</script>

<style lang="scss">

</style>
