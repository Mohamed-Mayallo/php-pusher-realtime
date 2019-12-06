<template>
  <div>
    <toolbar></toolbar>
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
