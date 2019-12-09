<template>
  <div>
    <v-card class="mx-auto mb-2" outlined hover shaped :to="question.path">
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
  </div>
</template>

<script>
export default {
  props: {
    question: {
      type: Object,
      default: () => ({})
    }
  }
};
</script>
