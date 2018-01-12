<template>
  <section>
    <form action="#" class="find-form">
      <div class="find-form__autoselect">
        <input v-model="queryFromUser" class="find-form__input" type="text">
        <div class="find-form__autoselect-menu">
          <ul class="find-form__autoselect-list">
            <li class="find-form__autoselect-item">
              <a class="find-form__autoselect-link" href="#"></a>
            </li>
          </ul>
        </div>
      </div>
      <button class="btn  find-form__btn">Найти</button>
    </form>
  </section>
</template>

<script>

  import * as utils from '../utils.js'
  var throtlingFlaf = '';

  export default {
    name: 'TopBar',
    data() {
      return {
        listFindFilms: [],
        queryFromUser: '',
      }
    },
    watch: {
      queryFromUser: function (val, oldVal) {
        this.$throtling(() => console.log('ss'), 1000);
      }
    }
  }
</script>

<style lang="scss">

</style>
