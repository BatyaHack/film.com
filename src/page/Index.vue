<template>
  <section class="main-container">
    <top-bar/>
    <transition name="bounce"  mode="out-in">
      <router-view></router-view>
    </transition>
  </section>
</template>

<script>
  import TopBar from '../components/TobBar/TopBar.vue'

  export default {
    name: 'Index',
    components: {
      TopBar
    }
  }
</script>

<style lang="scss" scope>
  .bounce-enter-active {
    animation: bounce-in .5s;
  }

  .bounce-leave-active {
    animation: bounce-in .5s reverse;
  }

  @keyframes bounce-in {
    0% {
      opacity: 0;
    }
    100% {
      opacity: 1;
    }
  }

</style>
