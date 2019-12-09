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
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "SingleQuestion",
  data() {
    return {
      question: {},
      loading: false
    };
  },
  async created() {
    try {
      this.loading = true;
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
  }
};
</script>
