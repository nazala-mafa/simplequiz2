<template>
  <h1>Tambah Test</h1>
  <form @submit.prevent="submitTest">
    <input type="text" placeholder="Test title" v-model="formData.title">
    <textarea rows="4" placeholder="Test description" v-model="formData.desc"></textarea>
    <button type="submit">Create Test</button>
  </form>
</template>

<script>
import { SERVER_URL } from '../../lib/const';
import store from '../../store';
export default {
  data() {
    return {
      formData: {
        title: '',
        desc: ''
      }
    }
  },
  methods: {
    submitTest(){
      fetch(SERVER_URL+'api/test',{
        method: 'post',
        headers: { 
          "Content-Type": "application/json",
          "Accept": "application/json",
          "Authorization": 'Bearer '+localStorage.getItem('token') 
        },
        body: JSON.stringify(this.formData)
      }).then(res=>res.json()).then(data=>{
        store.commit('setAlert', {
          status: 'success',
          messages: data.message
        })
        this.$router.push('/test')
      })
    }
  }
}
</script>

<style lang="scss" scoped>
form {
  width: 30%;
  min-width: 300px;
  margin: auto;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  input, textarea {
    display: block;
    padding: .2rem;
    width: 100%;
  }
}
</style>