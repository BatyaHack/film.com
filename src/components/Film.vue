<template>
  <article v-if="film && !load" class="film">
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
  import router from '@/router'
  import mixin from '@/mixins/mixin.js'

  export default {
    data() {
      return {
        load: true,
      }
    },
    mixins: [mixin],
    props: ['filmID'],
    created: function () {
      this.$store.dispatch('getFilm', this.filmID);
    },
    computed: {
      ...mapGetters({
        film: 'getFilm',
      }),
      allRatings: function () {
        return JSON.parse(this.film.ratings);
      }
    },
    watch: {
      film: function () {
        this.load = false;
      }
    },
    beforeRouteUpdate (to, from, next) {
      const partUrlID = 9;
      this.$store.dispatch('getFilm', to.path.slice(partUrlID));
      next();
    }
  }

</script>

<style lang="scss">


</style>
