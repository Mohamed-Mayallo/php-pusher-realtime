<template>
  <v-container>
    <form @submit.prevent="signup">
      <v-text-field v-model="name" label="Name" required type="text"></v-text-field>
      <span class="red--text" v-if="errors.name">{{ errors.name[0] }}</span>

      <v-text-field v-model="email" label="E-mail" required type="email"></v-text-field>
      <span class="red--text" v-if="errors.email">{{ errors.email[0] }}</span>

      <v-text-field v-model="password" label="Password" type="password"></v-text-field>
      <span class="red--text" v-if="errors.password">{{ errors.password[0] }}</span>

      <v-text-field
        v-model="password_confirmation"
        label="Confim password"
        required
        type="password"
      ></v-text-field>

      <v-btn class="mr-4" type="submit">Signup</v-btn>
    </form>
  </v-container>
</template>

<script>
export default {
  name: "Signup",
  data() {
    return {
      name: null,
      email: null,
      password: null,
      password_confirmation: null,
      errors: {}
    };
  },
  created() {
    if (localStorage && localStorage.getItem("token")) {
      this.$router.push("/forum");
    }
  },
  methods: {
    async signup() {
      try {
        let { data } = await axios.post("/api/auth/signup", {
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
          name: this.name
        });
        if (data.access_token) {
          localStorage.setItem("token", data.access_token);
          localStorage.setItem("user", data.user);
          this.$router.push("/");
        }
      } catch (e) {
        if (e.response && e.response.data.errors)
          this.errors = e.response.data.errors;
      }
    }
  }
};
</script>
