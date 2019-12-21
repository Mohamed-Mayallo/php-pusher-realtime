<template>
  <v-menu bottom origin="center center" transition="scale-transition">
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on">
        <v-icon color="red">mdi-bell-plus</v-icon>
        {{ unreadNotificationCount }}
      </v-btn>
    </template>
    <v-list>
      <v-list-item
        v-for="(item, index) in unreadNotifications"
        :key="item.id"
        @click="markAsRead(index)"
      >
        <router-link :to="item.path">
          <v-list-item-title>{{ item.question }}</v-list-item-title>
        </router-link>
      </v-list-item>
    </v-list>
    <v-divider></v-divider>
    <v-list>
      <v-list-item v-for="item in readNotifications" :key="item.id">
        <v-list-item-title>{{ item.question }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
export default {
  props: {
    path: {
      type: String,
      default: "/"
    }
  },
  data() {
    return {
      readNotifications: {},
      unreadNotifications: {},
      unreadNotificationCount: 0
    };
  },
  async created() {
    let currentUser = JSON.parse(localStorage.getItem("user"));
    Echo.private("App.User." + currentUser.id).notification(notification => {
      this.unreadNotifications.unshift(notification);
      this.unreadNotificationCount++;
    });

    await this.loadNotifications();

    $bus.$on("newReply", async () => {
      await this.loadNotifications();
    });
  },
  methods: {
    async loadNotifications() {
      try {
        let { data } = await axios.post("/api/notifications");
        this.readNotifications = data.readNotifications;
        this.unreadNotifications = data.unreadNotifications;
        this.unreadNotificationCount = data.unreadNotifications.length;
      } catch (e) {
        if (
          ["token_absent", "token_expired", "token_invalid"].includes(
            e.response.data.error
          )
        ) {
          this.logout();
          return;
        }
      }
    },
    async markAsRead(index) {
      let notification = this.unreadNotifications[index];
      await axios.post("/api/notifications/markAsRead", {
        id: notification.id
      });
      this.unreadNotifications.splice(index, 1);
      this.readNotifications.push(notification);
      this.unreadNotificationCount--;
    }
  }
};
</script>
