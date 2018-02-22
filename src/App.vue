<template>
  <section class="global-wrapper">
    <top-bar/>

    <main class="content">

        <transition name="bounce"  mode="out-in">
          <router-view></router-view>
        </transition>

    </main>

  </section>
</template>

<script>
  import TopBar from './components/TobBar/TopBar.vue'

  export default {
    name: 'App',
    components: {
      TopBar
    }
  }
</script>

<style lang="scss">
  @import "./style/style";

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

