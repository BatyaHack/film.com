<template>
  <form @submit.prevent="checkAvailabilityUser" action="#">
      <label for="email">Email</label>

      <input v-model="user.email" 
             :class="{ 'isError' : errors.has('email') }" 
             name="email" type="text" id="email">

      <span v-show="errors.has('email')">{{ errors.first('email') }}</span>

      <label for="password">Password</label>

      <input v-model="user.password" 
             :class="{ 'isError' : errors.has('password') }" 
             name="password" type="password" id="password">

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
        email: "",
        password: ""
      }
    };
  },
  created() {
    this.$validator.extend("check_user", {
      getMessage: (field, params, data) => {
        return data.message;
      },
      validate: value =>
        this.$store
          .dispatch("loginFromForm", {
            email: this.user.email,
            password: this.user.password
          })
          .then(data => {
            let response = data.data;
            return {
              validate: response.success,
              data: {
                message: response.error
              }
            };
          })
          .catch(ex => console.log(ex))
    });

    this.$validator.attach({
      name: "email",
      rules: "required|email|check_user"
    });
    this.$validator.attach({
      name: "password",
      rules: "required"
    });
  },
  methods: {
    checkAvailabilityUser: function() {
      this.$validator
        .validateAll({ email: this.user.email, password: this.user.password })
        .then(result => console.log(result));
    },
    login: function() {
      // this.$store.dispatch('loginFromForm', this.user);
    }
  }
};
</script>

<style>

</style>
