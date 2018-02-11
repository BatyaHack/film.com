<!--НЕ ЗАБЫТЬ ПОУБИРАТЬ ЭТИ ТРОТРЛИНГИ ИЛИ СДЕЛАТЬ ИХ НЕ В ОДНУ СЕКУНДУ-->
<!--ОЧЕНЬ ОЧЕНЬ СИЛЬНО НАТУПИЛ С ВЕРСТКОЙ НУЖНО БЫЛО РАЗБИТЬ НА БОЛЬШЕ КОМПОНЕТОВ И ПРОСТО СОБРАТЬ ВСЕ В ОДНО :с-->

<template>
  <nav class="navigation">

    <div class="navigation__wrapper container">

      <section class="logo  navigation__logo">
        <div class="logo__img-wrapper">
          <img class="logo__img" src="../../assets/logo.png" alt="pinball logo site">
        </div>
        <h1 hidden>сайт с самыми лучшими фильмами</h1>
      </section>

      <section class="search  navigation__search">
        <div class="input__wrapper-icon  input__wrapper-icon--loop search__wrapper-input">
          <input
            v-model="queryFromUser"
            id="searchInput"
            class="input  input--primary  input__search"
            type="text"
            title="Поиск фильма"
            v-on:focus="testFocus()"
            v-on:blur="testFocus()">
        </div>
        <label for="searchInput"
               v-show="inputFocus && queryFromUser.length > 3 && listFindFilms.length > 0"
               class="search__frame"
               v-on:scroll="setCurrentPage($event)">

          <ul class="search__list">
            <li class="search__item"
                v-for="(film, index) in listFindFilms" v-bind:key="index">

              <router-link :to="{name: 'film',  params: {filmID: film.imdbID}}" class="search__autoselect-info">
                <img class="search__autoselect-img"
                     v-show="film.Poster"
                     v-bind:src="film.Poster"
                     v-bind:atr='"img" + index'>
                <p class="search__autoselect-link" href="#">{{film.Title}}</p>
              </router-link>

            </li>
          </ul>
        </label>

      </section>

      <section class="login-block  navigation__login-block">
        <div class="login-block__img-wrapper">
          <img class="login-block__img" width="40px" height="40px" src="../../assets/user.jpg" alt="users photo">
        </div>
        <p class="login-block__user-name">Welcome John</p>
      </section>

    </div>

  </nav>
</template>

<script>

  import * as utils from '../../utils.js'
  import {sendRequestToListSearch} from './apiRequest.js'

  const magicConst = 10; // что бы немного раньше срабатывала подгрузка фильмов

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
          if (this.scrollWindow.clientHeight >= this.scrollItem.getBoundingClientRect().bottom - this.marginTop.getBoundingClientRect().top - magicConst) {
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
      },

      testFocus: function () {
        setTimeout(()=>{
          this.inputFocus = !this.inputFocus;
        }, 500);
      }
    },
    mounted: function () {
      this.marginTop = document.querySelector('.search__frame');
      this.scrollItem = document.querySelector('.search__list');
      this.scrollWindow = document.querySelector('.search__frame');
    },
  }
</script>

<style lang="scss">

</style>
