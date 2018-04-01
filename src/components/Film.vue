<template>

  <transition name="bounce" mode="out-in">

    <article v-if="film && !load" class="film" ref="soloFilm">

      <div class="film__poster" :style="{
          backgroundImage: `url(${PATH_TO_IMG + film.poster})`,
          backgroundColor: `#${film['poster_color']}`
      }">
      </div>

      <div class="content__container  container">

        <div class="film__content">
          <h2 class="film__title">{{film.title}}</h2>

          <span class="film__year">Year: <span>{{film.year}}</span></span>
          <span class="film__runtime">Run-time: <span>{{film.runtime}} minutes</span></span>

          <p class="film__description">{{film.plot}}</p>

          <section class="film__ratings-wrapper">
            <p class="film__label">Ratings:</p>

            <ul class="film__rating-list">
              <li class="film__ratings">
                <span>IMDB:</span>
                <span>{{film.imdbrating}}</span>
              </li>
              <li v-for="(rating, index) in allRatings" class="film__ratings" :key="index">
                <span>{{rating.Source}}</span>
                <span>{{rating.Value}}</span>
              </li>
            </ul>


          </section>
        </div>

      </div>


    </article>

  </transition>


</template>

<script>

  import {mapGetters} from 'vuex';
  import router from '@/router'
  import mixin from '@/mixins/mixin.js'

  export default {

    mixins: [mixin],
    props: ['filmID'],
    created: function () {
      this.$store.dispatch('getFilm', this.filmID);
    },
    data() {
      return {
        load: true,
      }
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
