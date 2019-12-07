<template>
  <div>
    <v-toolbar>
      <v-toolbar-title>PHP-Pusher</v-toolbar-title>

      <v-spacer></v-spacer>

      <div>
        <v-btn text>Forum</v-btn>
        <v-btn text>Ask a question</v-btn>
        <v-btn text>Contact</v-btn>
        <router-link to="/login">
          <v-btn text>Login</v-btn>
        </router-link>
      </div>
    </v-toolbar>
  </div>
</template>

<script>
export default {
  name: "Toolbar"
};
</script>
