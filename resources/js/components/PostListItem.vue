
<template>
  <div class="post-preview">
    <a :href="getHref">
      <h2 class="post-title">{{ item.title }}</h2>
      <h3 v-if="item.subtitle" class="post-subtitle">{{ item.subtitle }}</h3>
    </a>
    <p class="post-meta">
      Posted on {{ item.published_at }}
      <span v-if="item.tags.length">in <span v-html="joinTags"></span></span>
    </p>
  </div>
</template>

<style>
.post-meta span>a{text-decoration: none;}
</style>

<script>
export default {
  /* data (){
    return {

    }
  }, */
  props: ["item"],
  computed: {
    getHref: function(){
      return '/post/'+this.item.slug
    },
    joinTags: function(){
      let html = ''
      this.item.tags.forEach(tag => {
        html += `<a href="/post?tag=${tag.tag}">${tag.tag}</a> `
      });
      return html;
    }
  }
};
</script>