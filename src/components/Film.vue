<template>
  <article class="film">
    <img src="film__poster" alt="film-poster">
    <h2 class="film__title">Title poster ;P</h2>
    <span>{{film}}</span>
  </article>
</template>

<script>

  import {mapGetters} from 'vuex';

  export default {
    computed: mapGetters({
      film: 'getFilm'
    }),
    props: ['filmID'],
    created: function () {
      this.$store.dispatch('getFilm', this.filmID);
    }
  }

</script>

<style lang="scss">


</style>
