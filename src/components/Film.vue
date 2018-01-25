<template>
  <article v-if="film" class="film">
    <img :src="PATH_TO_IMG + film.poster" alt="film-poster">
    <h2 class="film__title">{{film.title}}</h2>
    <p class="film__year">{{film.year}}</p>
    <p class="film__runtime">{{film.runtime}}</p>
    <p class="film__imdbrating">{{film.imdbrating}}</p>
    <p v-for="rating in allRatings" class="film__ratings">
      <span>{{rating.Source}}</span>
      <span>{{rating.Value}}</span>
    </p>

  </article>
</template>

<script>

  import {mapGetters} from 'vuex';
  import {API_MY_STATIC_PATH} from '@/config.js';


  export default {
    props: ['filmID'],
    created: function () {
      this.$store.dispatch('getFilm', this.filmID);
    },
    data() {
      return {
        PATH_TO_IMG: API_MY_STATIC_PATH,
      }
    },
    computed: {
      ...mapGetters({
        film: 'getFilm',
      }),
      allRatings: function () {
        return JSON.parse(this.film.ratings);
      }
    }

  }

</script>

<style lang="scss">


</style>
