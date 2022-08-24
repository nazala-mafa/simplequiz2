<template>
  <form class="card card-body text-start">
    <div class="mb-3 w-100">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" v-model="name" id="name">
    </div>
    <div class="mb-3 w-100">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" v-model="email" id="email">
    </div>
    <div class="mb-3 w-100">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" v-model="password" id="password">
    </div>
    <button class="btn btn-primary w-100" type="button" @click="createUser()">Tambah</button>
  </form>
</template>

<style lang="scss" scoped>
form {
  display: flex;
  flex-direction: column;
  max-width: 400px;
  align-items: flex-start;
  margin: auto;
}
</style>

<script>
import { SERVER_URL } from '../../lib/const'
export default {
  name: 'UserCreate',
  setup() {},
  data() {
    return { 
      name: '', email: '', password: '' 
    }
  },
  methods: {
    createUser() {
      fetch(SERVER_URL+'api/users', {
        method: 'post',
        headers: { 
          "Content-Type": "application/json",
          "Authorization": 'Bearer '+localStorage.getItem('token'),
        },
        body: JSON.stringify({
          name: this.name, 
          email: this.email, 
          password: this.password
        })
      }).then(res=>res.json()).then(()=>{ this.$router.push('/users') })
    }
  }
}
</script>