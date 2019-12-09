<template>
  <v-container>
    <single v-for="question in questions" :key="question.id" :question="question"></single>
  </v-container>
</template>

<script>
import Single from "./Single";

export default {
  components: {
    Single
  },
  data() {
    return {
      questions: []
    };
  },
  async created() {
    try {
      let { data } = await axios.get("/api/questions");
      if (data.data) {
        this.questions = data.data;
      }
    } catch (e) {
      console.log(e);
    }
  }
};
</script>
