<template>
  <div v-if="data">
    <h1>Edit Post Baru</h1>
    <div class="form-group">
      <label for="title">Judul</label><br />
      <input id="title" type="text" v-model="data.title" /><br />
    </div>
    <div class="form-group">
      <label for="body">Konten</label><br />
      <textarea id="body" cols="30" rows="10" v-model="data.body"></textarea>
    </div>
    <button class="blue" @click="submitPost">Simpan</button>
  </div>
  <p v-else>Loading ...</p>
</template>

<script>
import { SERVER_URL } from "../../lib/const";
export default {
  name: "EditPostView",
  setup() {
    window.document.title = "Edit User";
  },
  data() {
    return {
      data: null,
    };
  },
  methods: {
    submitPost() {
      fetch(SERVER_URL+'api/posts/'+this.$route.params.id, {
        method: 'put',
        headers: { 
          'Content-Type': 'application/json',
          "Accept": "application/json",
          "Authorization": 'Bearer '+localStorage.getItem('token') 
        },
        body: JSON.stringify({
          title: this.data.title,
          body: this.data.body
        })
      }).then(res=>res.json()).then(data=>{
        this.$router.push('/posts')
      })
    }
  },
  beforeCreate() {
    fetch(SERVER_URL+'api/posts/'+this.$route.params.id, {
      headers: {
        "Accept": "application/json",
        "Authorization": 'Bearer '+localStorage.getItem('token') 
      }
    }).then(res=>res.json()).then(({data})=>{
      this.data = data
    })
  }
};
</script>