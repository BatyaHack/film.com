<template>
  <section class="main-container">
    <top-bar/>
    <transition name="bounce"  mode="out-in">
      <router-view></router-view>
    </transition>
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

<style lang="scss" scope>

</style>

