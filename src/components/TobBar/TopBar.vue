<template>
  <section>
    <form action="#" class="find-form">

      <input
        v-model="queryFromUser"
        class="input  input--primary  find-form__input"
        type="text"
        v-on:focus="inputFocus = true"
        v-on:blur="inputFocus = false">

      <button class="btn  find-form__btn">Найти</button>

      <div v-if="queryFromUser.length >= 3 && inputFocus"
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

    </form>
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
      }
    },
    watch: {
      queryFromUser: function (val, oldVal) {
        this.$throtling(() => {
          this.getListFilm(val);
        }, 1000);
      }
    },
    methods: {
      setCurrentPage: function (evt) {

        if(!this.checkScrollToBottom()) return null;

        this.$throtling(() => {
          this.currentPage = this.currentPage < this.allPage ? ++this.currentPage : 1;
          console.log(this.currentPage);
          this.getListFilm(this.queryFromUser, this.currentPage);
        }, 1000);
      },

      getListFilm: function (partTitle, page = 1) {
        sendRequestToListSearch(partTitle, page).then(data => {
          this.allPage = data.totalResults;
          this.listFindFilms = this.listFindFilms.concat(data.Search);
        });
      },

      checkScrollToBottom: function () {

        if (this.scrollValue < document.querySelector('.find-form__autoselect-menu').scrollTop) {
          this.scrollValue = document.querySelector('.find-form__autoselect-menu').scrollTop;
          return true;
        } else {
          return false;
        }

      }
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
      margin-top: 20px;
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
