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
        <v-btn text color="warning" @click="deleteReply">Delete</v-btn>
        <v-btn text color="primary" @click.stop="dialog=true">Edit</v-btn>
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
    }
  },
  data() {
    return {
      dialog: false
    };
  },
  mounted() {
    $bus.$on("close", () => {
      this.dialog = false;
    });
  },
  methods: {
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
