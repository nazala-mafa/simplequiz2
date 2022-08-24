<template>
  <div v-if="!tests">Loading ...</div>
  <div v-else class="mx-lg-4 mx-sm-2">
    <h1>List Test Page</h1>
    <div class="tests">
      <div class="test" v-for="test in tests" :key="test.id">
        <a :href="'/test/' + test.id">
          <h2>{{ test.title }}</h2>
          <p>{{ test.desc }}</p>
        </a>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.tests {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  gap: 1em;
  .test {
    padding: 0.5em;
    border: solid 2px #555;
    border-radius: 1em;
    a {
      color: #000;
      text-decoration: none;
    }
  }
}
</style>

<script>
import { addMeta } from '../../lib/utils';
import { SERVER_URL } from '../../lib/const';

export default {
  name: "ListTestView",
  setup() {
    window.document.title = 'Daftar Test';
    addMeta('description', 'konten deskripsi')
  },
  data() {
    return {
      tests: null,
    };
  },
  created() {
    fetch(SERVER_URL+'api/test', {
      headers: {
        "Accept": "application/json",
        "Authorization": 'Bearer '+localStorage.getItem('token') 
      }
    }).then(res=>{
      if(res.status == 401) return this.$router.push('/login');
      return res.json();
    }).then(data => {
      this.tests = data
    })
  }
};
</script>