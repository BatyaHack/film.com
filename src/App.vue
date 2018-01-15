<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>

<!--И вот тут мы должны писать глобальные стили! А не праиться со сборкой стилей-->

<style lang="scss">

  @import "./style/_btn.scss";
  @import "./style/_reset.scss";

</style>
