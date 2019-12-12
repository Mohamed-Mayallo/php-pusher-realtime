<template>
  <v-container>
    <template v-if="loading">
      <v-card style="margin-bottom:10px">
        <v-skeleton-loader boilerplate type="table" :tile="false"></v-skeleton-loader>
      </v-card>
    </template>

    <template v-else>
      <v-data-table
        :headers="[{ text: 'Name', value: 'name' }, { text: 'Actions', value: 'action', sortable: false }]"
        :items="categories"
        class="elevation-1"
      >
        <template v-slot:top>
          <v-toolbar flat color="white">
            <v-toolbar-title>Categories</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn color="primary" dark class="mb-2" v-on="on">New category</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col>
                        <v-text-field v-model="editedItem.name" label="Category name"></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>
        <template v-slot:item.action="{ item }">
          <v-icon small class="mr-2" @click="editItem(item)">edit</v-icon>
          <v-icon small @click="deleteItem(item)">delete</v-icon>
        </template>
      </v-data-table>
    </template>
  </v-container>
</template>

  </v-container>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
      categories: [],
      loading: false,
      name: null,
      editedIndex: -1,
      editedItem: {
        name: ""
      },
      defaultItem: {
        name: ""
      }
    };
  },
  watch: {
    dialog(val) {
      val || this.close();
    }
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },
  async created() {
    try {
      this.loading = true;
      let { data } = await axios.get("/api/categories");
      if (data.data) {
        this.categories = data.data;
      }
    } catch (e) {
      console.log(e);
    } finally {
      this.loading = false;
    }
  },
  methods: {
    editItem(item) {
      this.editedIndex = this.categories.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    async deleteItem(item) {
      const index = this.categories.indexOf(item);
      await axios.delete(`/api/categories/${item.slug}`);
      this.categories.splice(index, 1);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    async save() {
      if (this.editedIndex > -1) {
        // Edit
        await axios.patch(`/api/categories/${this.editedItem.slug}`, {
          name: this.editedItem.name
        });
        Object.assign(this.categories[this.editedIndex], this.editedItem);
      } else {
        // Create
        const { data } = await axios.post(`/api/categories`, {
          name: this.editedItem.name
        });
        this.categories.unshift(data.data);
      }
      this.close();
    }
  }
};
</script>
