<!--НЕ ЗАБЫТЬ ПОУБИРАТЬ ЭТИ ТРОТРЛИНГИ ИЛИ СДЕЛАТЬ ИХ НЕ В ОДНУ СЕКУНДУ-->
<!--ОЧЕНЬ ОЧЕНЬ СИЛЬНО НАТУПИЛ С ВЕРСТКОЙ НУЖНО БЫЛО РАЗБИТЬ НА БОЛЬШЕ КОМПОНЕТОВ И ПРОСТО СОБРАТЬ ВСЕ В ОДНО :с-->

<template>
  <section class="global-header">
    <header class="top-bar  container">

      <section class="logo  top-bar__logo">
        <div class="logo__wrapper">
          <router-link to="/">
            <img class="logo__img" src="../../assets/logo.png" alt="site-logo">
          </router-link>
        </div>
      </section>

      <section class="auto-select  input__wrapper  top-bar__auto-select">
        <input
          v-model="queryFromUser"
          class="input  input--primary  auto-select__input"
          type="text"
          v-on:focus="inputFocus = true"
          v-on:blur="inputFocus = false">

        <div v-show="inputFocus && queryFromUser.length > 3 && listFindFilms.length > 0"
             class="find-form__autoselect-menu"
             v-on:scroll="setCurrentPage($event)">

          <ul class="find-form__autoselect-list">
            <li
              v-for="(film, index) in listFindFilms" v-bind:key="index"
              class="find-form__autoselect-item">
              <router-link :to="{name: 'film',  params: {filmID: film.imdbID}}" class="find-form__autoselect-info">
                <img class="find-form__autoselect-img"
                     v-show="film.Poster"
                     v-bind:src="film.Poster"
                     v-bind:atr='"img" + index'>
                <p class="find-form__autoselect-link" href="#">{{film.Title}}</p>
              </router-link>
            </li>
          </ul>

        </div>
      </section>


    </header>
  </section>
</template>

<script>

  import * as utils from '../../utils.js'
  import {sendRequestToListSearch} from './apiRequest.js'

  export default {
    name: 'TopBar',
    data() {
      return {
        listFindFilms: [],
        queryFromUser: '',
        inputFocus: false,
        currentPage: 1,
        allPage: 0,
        scrollElem: false,
        scrollValue: 0,
        marginTop: 0,
        scrollItem: 0,
        scrollWindow: 0,
      }
    },
    watch: {
      queryFromUser: function (val, oldVal) {
        this.$throtling(() => {
          if (val.length < 3) {
            this.listFindFilms = [];
          }
          this.getListFilm(val);
        }, 1000);
      },
      inputFocus: function (val) {
        val ? document.body.style.overflow = 'hidden' : document.body.style.overflow = '';
      }
    },
    methods: {
      setCurrentPage: function (evt) {
        this.$throtling(() => {
          // фи как длино и не красиво
          if (this.scrollWindow.clientHeight >= this.scrollItem.getBoundingClientRect().bottom - this.marginTop.getBoundingClientRect().top) {
            this.currentPage = this.currentPage < this.allPage ? ++this.currentPage : 1;
            this.getListFilm(this.queryFromUser, this.currentPage);
          }
        }, 1000);
      },

      getListFilm: function (partTitle, page = 1) {
        if (this.queryFromUser.length > 3) {
          sendRequestToListSearch(partTitle, page).then(data => {
            if (!data.Error) {
              this.allPage = data.totalResults;
              this.listFindFilms = this.listFindFilms.concat(data.Search);
            } else {
              this.listFindFilms = [];
            }
          });
        }
      }
    },
    mounted: function () {
      this.marginTop = document.querySelector('.find-form__autoselect-menu');
      this.scrollItem = document.querySelector('.find-form__autoselect-list');
      this.scrollWindow = document.querySelector('.find-form__autoselect-menu');
    },
  }
</script>

<style lang="scss">

</style>
