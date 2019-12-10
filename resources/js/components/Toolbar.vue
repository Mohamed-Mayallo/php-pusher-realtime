<template>
  <div>
    <v-toolbar>
      <router-link to="/">
        <v-toolbar-title>PHP-Pusher</v-toolbar-title>
      </router-link>

      <v-spacer></v-spacer>

      <div>
        <router-link v-if="isLogged" to="/forum">
          <v-btn text>Forum</v-btn>
        </router-link>
        <router-link v-if="isLogged" to="/forum/ask">
          <v-btn text>Ask a question</v-btn>
        </router-link>
        <v-btn text>Contact</v-btn>
        <router-link v-if="!isLogged" to="/login">
          <v-btn text>Login</v-btn>
        </router-link>
        <router-link v-if="!isLogged" to="/signup">
          <v-btn text>Signup</v-btn>
        </router-link>
        <v-btn v-if="isLogged" text @click="logout">Logout</v-btn>
      </div>
    </v-toolbar>
  </div>
</template>

<script>
export default {
  name: "Toolbar",
  mounted() {
    $bus.$on("loggedIn", () => {
      this.isLogged = true;
    });
  },
  methods: {
    logout() {
      localStorage.removeItem("token");
      this.isLogged = false;
      this.$router.push("/login");
    }
  }
};
</script>
