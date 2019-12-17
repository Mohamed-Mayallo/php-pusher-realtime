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
          <v-btn text color="primary">Edit</v-btn>
        </router-link>
      </v-card-actions>
    </v-card>
    <template v-if="question.replies && question.replies.length">
      <v-container>
        <h2 class="mb-4 mt-4">Replies ({{ question.replies_count }})</h2>
        <template v-if="loading">
          <v-card v-for="n in 2" :key="n" style="margin-bottom:10px">
            <v-skeleton-loader boilerplate type="article" :tile="false"></v-skeleton-loader>
          </v-card>
        </template>
        <list-item
          v-else
          v-for="reply in question.replies"
          :key="reply.id"
          :currentUser="user"
          :question="reply"
        ></list-item>
      </v-container>
    </template>

    <h2 class="mb-4 mt-4">Reply</h2>
    <form @submit.prevent="reply">
      <v-text-field v-model="body" label="Content" type="textarea"></v-text-field>
      <p class="red--text" v-if="errors.body">{{ errors.body[0] }}</p>

      <v-btn class="mr-4 mt-5" type="submit">Reply</v-btn>
    </form>
  </v-container>
</template>

<script>
import ListItem from "./ListItem";

export default {
  name: "SingleQuestion",
  components: {
    ListItem
  },
  data() {
    return {
      body: null,
      question: {},
      loading: false,
      user: null,
      errors: []
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
  mounted() {
    $bus.$on("replyDeleted", replyId => {
      this.question.replies = this.question.replies.filter(
        r => r.id !== replyId
      );
    });
    $bus.$on("updateReply", async reply => {
      await this.updateReply(reply);
    });
  },
  methods: {
    async reply() {
      try {
        let { data } = await axios.post(
          `/api/questions/${this.question.slug}/replies`,
          {
            body: this.body
          }
        );
        this.question.replies.unshift(data.data);
        window.scrollTo(0, 0);
      } catch (e) {
        if (e.response && e.response.data.errors)
          this.errors = e.response.data.errors;
      }
    },
    async deleteQuestion() {
      try {
        await axios.delete(`/api/questions/${this.question.slug}`);
        this.$router.push("/forum");
      } catch (e) {
        console.log(e);
      }
    },
    async updateReply(reply) {
      try {
        await axios.patch(
          `/api/questions/${reply.question_slug}/replies/${reply.id}`,
          {
            body: reply.body
          }
        );
        $bus.$emit("replyUpdated");
      } catch (e) {
        console.log(e);
      }
    }
  }
};
</script>
