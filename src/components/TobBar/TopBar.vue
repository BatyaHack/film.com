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


    <div v-show="true"
         class="find-form__autoselect-menu"
         v-on:scroll="setCurrentPage($event)">

      <ul class="find-form__autoselect-list">

        <li
          v-for="(film, index) in listFindFilms" v-bind:key="index"
          class="find-form__autoselect-item">

          <a href="#" class="find-form__autoselect-info">

            <img class="find-form__autoselect-img"
                 v-show="film.Poster"
                 v-bind:src="film.Poster"
                 v-bind:atr='"img" + index'>

            <p class="find-form__autoselect-link" href="#">{{film.Title}}</p>

          </a>

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
            if(this.scrollWindow >= this.scrollItem.getBoundingClientRect().bottom - this.marginTop) {
              this.currentPage = this.currentPage < this.allPage ? ++this.currentPage : 1;
              console.log(this.currentPage);
              this.getListFilm(this.queryFromUser, this.currentPage);
            }
        }, 1000);
      },

      getListFilm: function (partTitle, page = 1) {
        sendRequestToListSearch(partTitle, page).then(data => {
          this.allPage = data.totalResults;
          this.listFindFilms = this.listFindFilms.concat(data.Search);
        });
      }
    },
    mounted: function () {
      this.marginTop = document.querySelector('.find-form__autoselect-menu').getBoundingClientRect().top;
      this.scrollItem = document.querySelector('.find-form__autoselect-list');
      this.scrollWindow = document.querySelector('.find-form__autoselect-menu').clientHeight;
    }
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
