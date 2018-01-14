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

      <div class="find-form__autoselect-menu">

        <ul
          v-if="queryFromUser.length >= 3 && inputFocus"
          class="find-form__autoselect-list">

          <li
            v-for="(film, index) in listFindFilms" v-bind:key="index"
            class="find-form__autoselect-item">

            <a href="#" class="find-form__autoselect-info">

              <img class="find-form__autoselect-img"
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

  var throtlingFlaf = '';

  export default {
    name: 'TopBar',
    data() {
      return {
        listFindFilms: [],
        queryFromUser: '',
        inputFocus: false,
      }
    },
    watch: {
      queryFromUser: function (val, oldVal) {
        // вот из за этого тротлинга оно не работает так быстро как хотелось
        // но что делать если у меня всеголишь 1000 запросов в день :с
        this.$throtling(() => {
          sendRequestToListSearch(val).then(data => this.listFindFilms = data);
        }, 1000);
      }
    }
  }
</script>

<style lang="scss" scoped>
  .find-form {
    &__autoselect-menu {
      max-width: 500px;
      min-width: 200px;
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
