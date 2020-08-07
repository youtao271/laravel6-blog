
<template>
  <div class="col-lg-8 col-md-10 mx-auto">
    <postListItem v-for="item in list" :key="item.id" :item="item"></postListItem>
  </div>
</template>

<script>
import postListItem from "./PostListItem.vue"
export default {
  components: {
    postListItem,
  },
  props: ["list"],
};
</script>