<template>
  <v-container>
    <v-skeleton-loader
      v-if="loading"
      ref="skeleton"
      boilerplate
      type="article"
      :tile="false"
      transition="scale-transition"
      class="mx-auto"
    ></v-skeleton-loader>
    <form @submit.prevent="update" v-else>
      <v-text-field v-model="question.title" label="Title" type="text"></v-text-field>
      <span class="red--text" v-if="errors.title">{{ errors.title[0] }}</span>

      <v-text-field v-model="question.body" label="Content" required type="textarea"></v-text-field>
      <span class="red--text" v-if="errors.body">{{ errors.body[0] }}</span>

      <v-combobox
        type="object"
        item-text="name"
        :value="questionCategory.name"
        @change="setCategory"
        :items="categories"
        label="Select the question category"
      ></v-combobox>
      <span class="red--text" v-if="errors.body">{{ errors.body[0] }}</span>

      <span class="red--text" v-if="errors.category_id">{{ errors.category_id[0] }}</span>

      <v-btn class="mr-4" type="submit">Update</v-btn>
    </form>
  </v-container>
</template>

<script>
export default {
  name: "UpdateAQuestion",
  data() {
    return {
      question: {},
      errors: {},
      categories: [],
      questionCategory: {},
      loading: false
    };
  },
  async created() {
    if (!localStorage.getItem("token")) {
      this.$router.push("/");
    }

    try {
      this.loading = true;
      let { data } = await axios.get("/api/categories");
      if (data.data) {
        this.categories = data.data;
      }

      let { data: q } = await axios.get(
        `/api/questions/${this.$route.params.slug}`
      );
      if (q.data) {
        this.question = q.data;
        this.questionCategory = this.question.category;
      }
    } catch (e) {
      console.log(e);
    } finally {
      this.loading = false;
    }
  },
  methods: {
    setCategory(item) {
      this.question.category_id = item.id;
    },
    async update() {
      try {
        let { data } = await axios.patch(
          `/api/questions/${this.$route.params.slug}`,
          {
            title: this.question.title,
            category_id: this.question.category_id,
            body: this.question.body
          }
        );
        this.$router.push("/forum");
      } catch (e) {
        if (e.response && e.response.data.errors)
          this.errors = e.response.data.errors;
      }
    }
  }
};
</script>
