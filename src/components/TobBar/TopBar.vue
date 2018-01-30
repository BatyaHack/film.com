<!--НЕ ЗАБЫТЬ ПОУБИРАТЬ ЭТИ ТРОТРЛИНГИ ИЛИ СДЕЛАТЬ ИХ НЕ В ОДНУ СЕКУНДУ-->

<template>
  <section>
    <div>
      <input
        v-model="queryFromUser"
        class="input  input--primary  find-form__input"
        type="text"
        v-on:focus="inputFocus = true"
        v-on:blur="inputFocus = false">

      <button class="btn  find-form__btn">Найти</button>
    </div>


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
          if(val.length < 3) {
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

<style lang="scss" scoped>
  .find-form {

    position: relative;

    &__autoselect-menu {
      position: absolute;
      max-width: 500px;
      min-width: 200px;
      height: 400px;
      overflow-y: scroll;
    }

    &__autoselect-list {
      display: flex;
      width: 100%;
      flex-wrap: wrap;
    }

    &__autoselect-item {
      margin-right: 20px;
      margin-bottom: 20px;
    }

    &__autoselect-img {
      width: 100px;
      height: 150px;
      object-fit: contain;
    }

    &__autoselect-info {
      display: block;
      max-width: 100px;
    }

    &__autoselect-link {
      text-align: center;
      display: block;
      width: 100%;
    }

  }
</style>
