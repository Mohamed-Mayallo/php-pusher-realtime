<template>
  <v-container>
    <template v-if="loading">
      <v-card v-for="n in 10" :key="n" style="margin-bottom:10px">
        <v-skeleton-loader boilerplate type="article" :tile="false"></v-skeleton-loader>
      </v-card>
    </template>

    <list-item
      v-else
      v-for="question in questions"
      :currentUser="currentUser"
      :key="question.id"
      :question="question"
    ></list-item>
  </v-container>
</template>

<script>
import ListItem from "./ListItem";

export default {
  components: {
    ListItem
  },
  data() {
    return {
      questions: [],
      loading: false,
      currentUser: null
    };
  },
  async created() {
    try {
      this.loading = true;
      let { data: currentUser } = await axios.post("/api/auth/me");
      this.currentUser = currentUser;
      let { data } = await axios.get("/api/questions");
      if (data.data) {
        this.questions = data.data;
      }
    } catch (e) {
      console.log(e);
    } finally {
      this.loading = false;
    }
  }
};
</script>
