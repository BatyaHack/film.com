<template>
  <section>
    <form action="#">
      <input type="text">
      <button class="btn">Найти</button>
    </form>
  </section>
</template>

<script>
  export default {
    name: 'TopBar',
    data() {
      return {
        msg: "asd text",
      }
    }
  }
</script>

<!-- scoped ограничивает css только этим компонентом -->
<style scoped lang="scss">

</style>
