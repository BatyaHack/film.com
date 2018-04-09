<template>
  <form @submit.prevent="registerNewUser" action="#">

      <label for="name">Name</label>
      <input v-model="user.name" 
             :class="{ 'isError' : errors.has('name') }" 
             name="name" type="text" id="name">
      <span v-show="errors.has('name')">{{ errors.first('name') }}</span>

      <label for="email">Email</label>
      <input v-model="user.email" 
             :class="{ 'isError' : errors.has('email') }" 
             name="email" type="text" id="email">
      <span v-show="errors.has('email')">{{ errors.first('email') }}</span>

      <label for="password">Password</label>
      <input v-model="user.password" 
             :class="{ 'isError' : errors.has('password') }" 
             name="password" type="password" id="password">
      <span v-show="errors.has('password')">{{ errors.first('password') }}</span>

      <label for="rpassword">Repeat password</label>
      <input v-model="user.rpassword"
             v-validate="'confirmed:password'"
             :class="{ 'isError' : errors.has('rpassword')}"
             name="rpassword" type="password" id="rpassword">
      <span v-show="errors.has('rpassword')">{{ errors.first('rpassword') }}</span>        

      <button type="submit">Login</button>        

  </form>

</template>

<script>
import axios from "axios";
import { API_MY_BASIC_URL } from "@/config";

export default {
  data: function() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        rpassword: ""
      }
    };
  },
  created() {
    this.$validator.attach({
      name: "name",
      rules: "required"
    });

    this.$validator.attach({
      name: "email",
      rules: "required|email"
    });

    this.$validator.attach({
      name: "password",
      rules: "required"
    });

    this.$validator.attach({
      name: "rpassword",
      rules: "required"
    });
  },
  methods: {
    registerNewUser: function() {
      console.log(this.user.password, this.user.rpassword);
      this.$validator.validateAll({
        name: this.user.name,
        email: this.user.email,
        password: this.user.password.trim(),
        rpassword: this.user.rpassword.trim()
      })
      .then(result => console.log(result));
    }
  }
};
</script>

<style lang="scss">

</style>