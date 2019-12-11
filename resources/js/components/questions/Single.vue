<template>
  <v-container>
    <v-card class="mx-auto mb-2">
      <v-skeleton-loader
        v-if="loading"
        ref="skeleton"
        boilerplate
        type="article"
        :tile="false"
        transition="scale-transition"
        class="mx-auto"
      ></v-skeleton-loader>
      <v-list-item three-line v-else>
        <v-list-item-content>
          <v-list-item-title class="headline mb-1">{{ question.title }}</v-list-item-title>
          <v-list-item-subtitle>{{ question.user }} asked {{ question.created_at }}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-card-text>
        <div class="text--primary">{{ question.body }}</div>
      </v-card-text>
      <v-card-actions v-if="user && question.user_id === user.id">
        <v-btn text color="warning" @click="deleteQuestion">Delete</v-btn>
        <router-link :to="`/forum/edit/${question.slug}`">
          <v-btn text olor="primary">Edit</v-btn>
        </router-link>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "SingleQuestion",
  data() {
    return {
      question: {},
      loading: false,
      user: null
    };
  },
  async created() {
    try {
    this.loading = true;
    let { data: currentUser } = await axios.post("/api/auth/me");
    this.user = currentUser;
      let { data } = await axios.get(
        `/api/questions/${this.$route.params.slug}`
      );
      if (data.data) {
        this.question = data.data;
      }
    } catch (e) {
      console.log(e);
    } finally {
      this.loading = false;
    }
  },
  methods: {
    async deleteQuestion() {
      try {
        await axios.delete(`/api/questions/${this.question.slug}`);
        this.$router.push("/forum");
      } catch (e) {
        console.log(e);
      }
    }
  }
};
</script>
