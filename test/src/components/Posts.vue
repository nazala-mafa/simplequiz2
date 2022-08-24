<template>
  <div class="row mx-3">
    <div class=" col-md-4 col-lg-3 p-2 position-relative" v-for="post in posts" :key="post.id">
      <div class="card card-body h-100 border-info">
        <router-link :to="`/posts/${post.id}`" class="text-decoration-none text-start text-dark">
          <h4>{{ ( post.title.length>40 ) ? post.title.slice(0, 40)+' ...' : post.title }}</h4>
          <p>{{ post.body.slice(0, 150)+' ...' }}</p>
        </router-link>
      </div>
      <router-link class="btn btn-warning btn-sm" :to="`/posts/${post.id}/edit`">edit</router-link>
      <button class="btn btn-danger btn-sm" @click="deletePost(post.id)">hapus</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Posts',
  props: { posts: Array, deletePost: Function },
}
</script>

<style lang="scss" scoped>
.btn {
  position: absolute;
  bottom: 1rem;
  &.btn-danger { right: 1rem; }
  &.btn-warning { right: 5rem; }
}
</style>