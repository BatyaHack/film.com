<template>
  <div>
    <h1>Заголовок чего то там!!!</h1>
    <ul class="list__wrapper">
      <li v-for="(film, index) in films.filmList" :key="index">
        <router-link :to="{ name: 'film', params: { filmID: film.imdbid } }" class="list__link">

          <div
            :style=" { background: `#${film['poster_color']} url(${PATH_TO_IMG + film.poster})`} "
            class="imgBackground"
          >
          </div>
          <span>{{film.title}}</span>
        </router-link>
      </li>
    </ul>
    <button @click.prevent="showFilmList">Дави</button>
  </div>
</template>

<script>

  import {mapGetters, mapMutations} from 'vuex';
  import * as mutationsTypes from '@/store/mutation-types.js';
  import mixin from '@/mixins/mixin.js'

  export default {
    mixins: [mixin],
    data() {
      return {
        scrollItem: false,
        windowH: false,
        countPage: 1,
      }
    },
    computed: mapGetters({
      films: 'allFilms'
    }),
    created: function () {
     this.$store.dispatch('getAllFilms');
     document.addEventListener('scroll', (evt) => {
        this.$throtling(() => {
          if (this.scrollItem.getBoundingClientRect().bottom < this.windowH && this.films.countPage > this.countPage) {
            this.$store.commit(mutationsTypes['INCREMENT_CURRENT_PAGE']);
            this.$store.dispatch('getAllFilms');
            ++this.countPage;
          }

        }, 1000);
      })
    },
    mounted: function () {
      this.scrollItem = document.querySelector('.list__wrapper');
      this.windowH = window.innerHeight;
    },
    methods: {
      showFilmList: function () {
      }
    }
  }

</script>

<style lang="scss" scope>

  .imgBackground {
    width: 300px;
    height: 400px;
    background: url(http://topfilmsapi.com/public/img/lTIwt0Af4UEmXxbACNT4bCINgatfSScb.jpg) rgb(0, 0, 0);
    background-repeat: no-repeat;
    background-position-y: top;
  }

  .list__link {
    display: block;
    cursor: pointer;
  }

</style>
