<template>
  <MessageBlock />
  <div v-if="posts.length">
    <header>
      <input type="text" v-model="searchVal" class="search-box">
      <button class="blue" @click="addPost">Tambah Post</button>
    </header>
    <Posts :posts="filterPost" :deletePost="deletePost" />
  </div>
</template>

<script>
import Posts from '../../components/Posts.vue';
import MessageBlock from '../../components/MessageBlock.vue';
import { SERVER_URL } from '../../lib/const';

export default {
  name: 'PostsView',
  data() {
    return {
      posts: [],
      searchVal: ''
    }
  },
  components: {
    Posts,
    MessageBlock
  },
  methods: {
    addPost() {
      this.$router.push('/posts/new')
    },
    deletePost(postId) {
      fetch(SERVER_URL+'api/posts/'+postId, { 
        method: 'delete',
        headers: { 
          "Accept": "application/json",
          "Authorization": 'Bearer '+localStorage.getItem('token') 
        }
      }).then(res=>res.json()).then(res=>{ 
        fetch(SERVER_URL+'api/posts', {
          headers: { 
            "Accept": "application/json",
            "Authorization": 'Bearer '+localStorage.getItem('token') 
          }
        }).then(res=>res.json()).then(data=>{ this.posts = data })
      })
    }
  },
  beforeCreate() {
    window.document.title = 'Daftar Artikel';
    fetch(SERVER_URL+'api/posts', {
      headers: { 
        "Accept": "application/json",
        "Authorization": 'Bearer '+localStorage.getItem('token') 
      }
    }).then(res=>{
      if(res.status == 401) return this.$router.push('/login');
      return res.json();
    }).then(data=>{ this.posts = data })
  },
  computed: {
    filterPost() {
      return this.posts.filter(item=>{
        return item.title.match(this.searchVal)
      })
    }
  }
}
</script>

<style scoped>
  .search-box {
    padding: 6px;
    margin-right: 5px;
    border-radius: 6px;
    border-color: var(--blue-light);
  }
  .search-box:focus-visible{
    outline-color: var(--blue);
  }
</style>