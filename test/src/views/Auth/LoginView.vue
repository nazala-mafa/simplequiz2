<template>
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-xl-4">
      <form>
        <div class="mb-3">
          <label for="login" class="form-label">Username / Email</label>
          <input type="text" class="form-control" id="login" v-model="login" />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" v-model="password" />
        </div>
        <div class="mb-3">
          <button type="button" class="btn btn-primary w-100" @click="loginAttempt">Login</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { SERVER_URL } from "../../lib/const";
export default {
  setup() { window.document.title = 'Login' },
  data() {
    return { login: '', password: '' }
  },
  methods: {
    loginAttempt() {
      fetch(SERVER_URL+'api/login', {
        method: 'post',
        headers: { 
          "Accept": "application/json",
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          login: this.login, 
          password: this.password
        })
      }).then(res=>res.json()).then(res=>{
        localStorage.setItem('token', res.token)
        return this.$router.push('/')
      })
    }
  }
}
</script>