<template>
  <div v-if="post" class="single-post">
    <h2>{{ post.title }}</h2>
    <p>{{ post.body }}</p>

    <p>
      dibuat oleh 
      <a :href="`/users/${post.user_id}`">{{ post.author }}</a>
    </p>
  </div>
  <div v-else>
    loading ...
  </div>
</template>

<script>
import { SERVER_URL } from '../../lib/const';
export default {
  name: 'Post',
  data() {
    return {
      post: null,
    }
  },
  beforeCreate() {
    fetch(SERVER_URL+`api/posts/${this.$route.params.id}`, {
      method: 'GET',
      headers: {
        "Accept": "application/json",
        "Authorization": 'Bearer '+localStorage.getItem('token') 
      }
    }).then(res=>res.json()).then(({data})=>{
      console.log(data);
      this.post = data
    })
  }
}
</script>