<template>
  <v-container>
    <form @submit.prevent="ask">
      <v-text-field v-model="title" label="Title" type="text"></v-text-field>
      <span class="red--text" v-if="errors.title">{{ errors.title[0] }}</span>

      <v-text-field v-model="body" label="Content" required type="textarea"></v-text-field>
      <span class="red--text" v-if="errors.body">{{ errors.body[0] }}</span>

      <v-combobox
        type="object"
        item-text="name"
        @change="setCategory"
        :items="categories"
        label="Select the question category"
      ></v-combobox>
      <span class="red--text" v-if="errors.body">{{ errors.body[0] }}</span>

      <span class="red--text" v-if="errors.category_id">{{ errors.category_id[0] }}</span>

      <v-btn class="mr-4" type="submit">Ask</v-btn>
    </form>
  </v-container>
</template>

<script>
export default {
  name: "AskAQuestion",
  data() {
    return {
      title: null,
      body: null,
      category_id: null,
      errors: {},
      categories: []
    };
  },
  async created() {
    if (!localStorage.getItem("token")) {
      this.$router.push("/");
    }

    let { data } = await axios.get("/api/categories");
    if (data.data) {
      this.categories = data.data;
    }
  },
  methods: {
    setCategory(item) {
      this.category_id = item.id;
    },
    async ask() {
      try {
        let { data } = await axios.post("/api/questions", {
          title: this.title,
          category_id: this.category_id,
          body: this.body
        });
        this.$router.push("/forum");
      } catch (e) {
        if (e.response && e.response.data.errors)
          this.errors = e.response.data.errors;
      }
    }
  }
};
</script>
