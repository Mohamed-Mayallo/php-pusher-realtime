<template>
  <v-container>
    <form @submit.prevent="login">
      <v-text-field v-model="email" label="E-mail" required type="email"></v-text-field>
      <v-text-field v-model="password" label="Password" required type="password"></v-text-field>

      <v-btn class="mr-4" type="submit">Login</v-btn>
    </form>
  </v-container>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      email: null,
      password: null
    };
  },
  created() {
    if (localStorage && localStorage.getItem("token")) {
      this.$router.push("/");
    }
  },
  methods: {
    async login() {
      try {
        let { data } = await axios.post("/api/auth/login", {
          email: this.email,
          password: this.password
        });
        if (data.access_token) {
          localStorage.setItem("token", data.access_token);
          localStorage.setItem("user", JSON.stringify(data.user));
          window.location = "/forum";
        }
      } catch (e) {
        console.log(e);
      }
    }
  }
};
</script>
