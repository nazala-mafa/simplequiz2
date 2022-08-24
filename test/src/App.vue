<template>
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/users">Users</router-link> | 
    <router-link to="/posts">Posts</router-link> | 
    <router-link to="/test">Test</router-link> |
    <span v-if="isLogged">
      <router-link to="/login">Login</router-link>
    </span>
    <span v-else>
      <router-link to="/logout">Logout</router-link>
    </span>
  </nav>
  <router-view/>
</template>

<script>
export default {
  data() {
    return {
      isLogged: localStorage.getItem('token') === null
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
