<template>
  <form @submit.prevent="login" action="#">
      <label for="email">Email</label>
      <input v-model="user.email" type="email" id="email">
      <label for="password">Password</label>
      <input v-model="user.password" type="password" id="password">
      <button type="submit">Login</button>
  </form>
</template>

<script>
export default {
    data: function () {
        return {
            user: {
                email: '',
                password: '',
            }
        }
    },
    methods: {
        login: function() {
            this.$store.dispatch('loginFromForm', this.user);
        },
    }
};
</script>

<style>

</style>
