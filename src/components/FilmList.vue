<template>
  <div class="content__row">
    <!--Нет смысла выносить в отдельный компонет. Почему? Потому-что
    Хотя можно было бы. Так как роут в нутри article не очень модно и стильно-->
    <router-link
      v-for="(film, index) in films.filmList"
      :key="index"
      :to = "{ name: 'film', params: { filmID: film.imdbid }}"
      tag="article"
      class="film-card  film-card--small  content__film-card">


        <header
          :style=" {
              backgroundColor: `#${film['poster_color']}`,
              backgroundImage: `url(${PATH_TO_IMG + film.poster})`
           }"
          class="film-card__img-wrapper">

        </header>

        <div class="film-card__slide">
          <div class="film-card__content">
            <h2 class="film-card__title">{{film.title}}</h2>
            <p class="film-card__type">Movies
            </p>
            <!--TODO так же сделать "обрезание" строке до определенного колва символов через фильтр-->
            <p class="film-card__description">Lorem Ipsum is simply dummy text of the printing & typesetting
              industry.</p>
          </div>
          <footer class="film-card__footer">
            <div class="rating  film-card__rating">
              <ul class="rating__list">
                <li class="rating__item">
                  <span class="rating__name">IMDB</span>
                  <span class="rating__value">{{film.imdbrating}}</span>
                </li>

                <li v-for="(rating, index) in JSON.parse(film.ratings)" class="rating__item">
                  <span class="rating__name">{{rating.Source}}:</span>
                  <span class="rating__value">{{rating.Value}}</span>
                </li>

              </ul>
            </div>
          </footer>
        </div>

      </router-link>

  </div>
</template>

<script>

  import {mapGetters, mapMutations} from 'vuex';
  import * as mutationsTypes from '@/store/mutation-types.js';
  import mixin from '@/mixins/mixin.js'

  export default {
    // фильтр для вывода одного рейтинга
    // пример использования {{film.ratings | parseJson('Value')}}
    filters: {
      parseJson(message, key) {
        if (!message) return '';
        return JSON.parse(message)[0][key];
      }
    },
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
          if (this.scrollItem.getBoundingClientRect().bottom <= this.windowH && this.films.countPage > this.countPage) {
            this.$store.commit(mutationsTypes['INCREMENT_CURRENT_PAGE']);
            this.$store.dispatch('getAllFilms');
            ++this.countPage;
          }

        }, 1000);
      })
    },
    mounted: function () {
      this.scrollItem = document.querySelector('.content__row');
      this.windowH = window.innerHeight;
    },
    methods: {
      showFilmList: function () {
      }
    }
  }

</script>

<style lang="scss">

</style>
