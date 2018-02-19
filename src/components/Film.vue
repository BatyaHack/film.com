<template>

  <transition name="bounce" mode="out-in">

    <article v-if="film && !load" class="film" ref="soloFilm">
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

  </transition>


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
    methods: {},
    // тут мы используем slice с url та как filmID ссылается на текущий фильм, а не на который мы перешли
    beforeRouteUpdate(to, from, next) {
      const partUrlID = -9;
      // TODO придумать какое нибудь плавное изчезновение
      this.load = true;
      this.$store.dispatch('getFilm', to.path.slice(partUrlID));
      next();
    }
  }

</script>

<style lang="scss">

</style>
