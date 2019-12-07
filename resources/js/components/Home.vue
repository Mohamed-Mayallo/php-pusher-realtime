<template>
  <div>
    <toolbar></toolbar>
    <router-view></router-view>
    <app-footer></app-footer>
  </div>
</template>

<script>
import toolbar from "./Toolbar";
import footer from "./Footer";

export default {
  components: {
    toolbar,
    "app-footer": footer
  }
};
</script>
