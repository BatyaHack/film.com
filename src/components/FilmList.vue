<template>

  <div class="content__container  container">
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
            <p class="film-card__description">{{film.plot | cutFilter}}</p>
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


      <section v-show="load" class="load-block">
        <!--TODO сделать красиво через SVG-->
        <div class="load-block__wrapper-img">
          <img class="load-block__img" width="100px" src="../assets/loadData.gif" alt="load circle img">
        </div>
      </section>


    </div>
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
      },
      cutFilter(value, cutSymbol = 100) {
        const descriptionLength = cutSymbol;
        if (!value) return '';
        // TODO скорее всего можно как то короче, но и так стильно, модно, молодежно
        let cutLine = value.slice(0, descriptionLength);
        let lastSpice = cutLine.lastIndexOf(' ') !== -1 ? cutLine.lastIndexOf(' ') : descriptionLength;
        return value.slice(0, lastSpice) + '...';
      }

    },
    mixins: [mixin],
    data() {
      return {
        scrollItem: false,
        windowH: false,
        countPage: 1,
        load: false,
      }
    },
    computed: {
      films: function () {
        this.load = false;
        console.log('ss');
        return this.$store.getters.allFilms;
      }
    },
    created: function () {
     this.$store.dispatch('getAllFilms');
     document.addEventListener('scroll', (evt) => {
        this.$throtling(() => {
          if (this.scrollItem.getBoundingClientRect().bottom <= this.windowH && this.films.countPage > this.countPage) {
            this.load = true;
            this.$store.commit(mutationsTypes['INCREMENT_CURRENT_PAGE']);
            this.$store.dispatch('getAllFilms');
            ++this.countPage;
          } else {
            this.load = false;
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
