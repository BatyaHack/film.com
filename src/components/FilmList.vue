<template>
  <div>
    <h1>Заголовок чего то там!!!</h1>
    <ul class="list__wrapper">
      <li v-for="(film, index) in films" :key="index">
        <div :style="{
          background: `#${film['poster_color']} url(${PATH_TO_IMG + film.poster})`,
        }"
             class="imgBackground">

        </div>
        {{film.title}}
      </li>
    </ul>
    <button @click.prevent="showFilmList">Дави</button>
  </div>
</template>

<script>

  import {mapGetters, mapMutations} from 'vuex';
  import {API_MY_STATIC_PATH} from '@/config.js';
  import * as mutationsTypes from '@/store/mutation-types.js';


  export default {
    data() {
      return {
        PATH_TO_IMG: API_MY_STATIC_PATH,
        scrollItem: false,
        windowH: false,
      }
    },
    computed: mapGetters({
      films: 'allFilms'
    }),
    created: function () {
      this.$store.dispatch('getAllFilms');

      document.addEventListener('scroll', (evt) => {
        this.$throtling(() => {
          if (this.scrollItem.getBoundingClientRect().bottom < this.windowH)
          {
            this.$store.commit(mutationsTypes['INCREMENT_CURRENT_PAGE']);
            this.$store.dispatch('getAllFilms');
          }

        }, 1000);
      })
    },
    mounted: function () {
      this.scrollItem = document.querySelector('.list__wrapper');
      this.windowH = window.innerHeight;
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

</style>
