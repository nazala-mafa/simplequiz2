<template>
  <div class="row justify-content-md-center">
    <div class="col-12 col-md-8">
      <form class="card card-body text-start">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" v-model="name" id="name">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" v-model="email" id="email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" v-model="password" id="password">
        </div>
        <button class="btn btn-primary" type="button" @click="updateUser()">Simpan</button>
      </form>
    </div>
  </div>
</template>

<script>
import { SERVER_URL } from '../../lib/const'
export default {
  name: 'UserEdit',
  setup() { window.document.title = 'Edit User'; },
  data() {
    return { 
      name: '', email: '', password: ''
    }
  },
  methods: {
    updateUser() {
      fetch(SERVER_URL+'api/users/'+this.$route.params.id, {
        method: 'put',
        headers: {
          "Accept": "application/json",
          "Content-Type": "application/json",
          "Authorization": 'Bearer '+localStorage.getItem('token'),
        },
        body: JSON.stringify({
          name: this.name,
          email: this.email,
          password: this.password
        })
      }).then(() => { this.$router.push('/users') })
    }
  },
  created() {
    fetch(SERVER_URL+'api/users/'+this.$route.params.id, {
      "Accept": "application/json",
      headers: { "Authorization": 'Bearer '+localStorage.getItem('token') }
    }).then(res=>res.json()).then(({data})=>{
      this.name = data.name;
      this.email = data.email;
    })
  }
}
</script>