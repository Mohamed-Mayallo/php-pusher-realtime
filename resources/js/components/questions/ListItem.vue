<template>
  <div>
    <v-card v-if="question.path" class="mx-auto mb-2" outlined hover shaped :to="question.path">
      <v-list-item three-line>
        <v-list-item-content>
          <v-list-item-title class="headline mb-1">{{ question.title }}</v-list-item-title>
          <v-list-item-subtitle>{{ question.user }} asked {{ question.created_at }}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-card-text>
        <div class="text--primary">{{ question.body }}</div>
      </v-card-text>
      <v-card-actions>
        <router-link :to="question.path">
          <v-btn text color="info">More</v-btn>
        </router-link>
      </v-card-actions>
    </v-card>
    <v-card v-else class="mx-auto mb-2">
      <v-list-item three-line>
        <v-list-item-content>
          <v-list-item-title class="headline mb-1">{{ question.title }}</v-list-item-title>
          <v-list-item-subtitle>{{ question.user }} replied {{ question.created_at }}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-card-text>
        <div class="text--primary">{{ question.body }}</div>
      </v-card-text>
      <v-card-actions>
        <v-btn
          v-if="currentUser && currentUser.id === question.user_id"
          text
          color="warning"
          @click="deleteReply"
        >Delete</v-btn>
        <v-btn
          v-if="currentUser && currentUser.id === question.user_id"
          text
          color="primary"
          @click.stop="dialog=true"
        >Edit</v-btn>
        <v-btn @click.prevent="like" icon>
          <v-icon :color="question.is_liked ? 'red' : 'grey'">mdi-heart</v-icon>
          {{ question.likes_count }}
        </v-btn>
      </v-card-actions>
    </v-card>
    <Dialog :dialog="dialog" :reply="question"></Dialog>
  </div>
</template>

<script>
import Dialog from "../Dialog";

export default {
  components: {
    Dialog
  },
  props: {
    question: {
      type: Object,
      default: () => ({})
    },
    currentUser: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      dialog: false
    };
  },
  created() {
    Echo.channel("likeChannel").listen("LikeEvent", e => {
      if (this.question.id === e.id) {
        e.type === 1
          ? this.question.likes_count++
          : this.question.likes_count--;
      }
    });

    Echo.channel("deleteReplyChannel").listen("DeleteReplyEvent", e => {
      if (this.question.id === e.id) {
        $bus.$emit("replyDeleted", this.question.id);
      }
    });
  },
  mounted() {
    $bus.$on("close", () => {
      this.dialog = false;
    });
  },
  methods: {
    async like() {
      let url = this.question.is_liked
        ? `/api/replies/${this.question.id}/unlike`
        : `/api/replies/${this.question.id}/like`;
      let { data } = await axios[this.question.is_liked ? "delete" : "post"](
        url
      );
      this.question.is_liked
        ? this.question.likes_count--
        : this.question.likes_count++;
      this.question.is_liked = !this.question.is_liked;
    },
    async deleteReply() {
      try {
        await axios.delete(
          `/api/questions/${this.question.question_slug}/replies/${this.question.id}`
        );
        $bus.$emit("replyDeleted", this.question.id);
      } catch (e) {
        console.log(e);
      }
    }
  }
};
</script>
