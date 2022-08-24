<template>
  <h1>Tambah Post Baru</h1>
  <div class="form-group">
    <label for="title">Judul</label><br>
    <input id="title" type="text" v-model="data.title"><br>
  </div>
  <div class="form-group">
    <label for="body">Konten</label><br>
    <textarea id="body" cols="30" rows="10" v-model="data.body"></textarea>
  </div>
  <button class="blue" @click="submitPost()">Tambah</button>
</template>

<script>
import store from '../../store';
import { SERVER_URL } from '../../lib/const';

export default {
  name: 'add post',
  data() {
    return {
      data: {
        title: '',
        body: '',
      }
    }
  },
  methods: {
    submitPost() {
      fetch(SERVER_URL+'api/posts',{
        method: 'post',
        headers: { 
          "Content-Type": "application/json",
          "Accept": "application/json",
          "Authorization": 'Bearer '+localStorage.getItem('token') 
        },
        body: JSON.stringify(this.data)
      }).then(res=>res.json()).then(data=>{
        store.commit('setAlert', {
          status: 'success',
          messages: data.message
        })
        this.$router.push('/posts')
      })
    }
  }
}
</script>

<style scoped>
.form-group {
  margin-bottom: 1em;
}
</style>