<template>
<MessageBlock />
<div v-if="users">

  <header class="d-flex justify-content-between w-75 m-auto">
    <h1>Daftar User</h1>
    <div>
      <router-link class="btn btn-primary" to="/users/create">tambah user</router-link>
    </div>
  </header>
  <table class="table table-bordered w-75 m-auto">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="user, idx in users" :key="idx">
        <td>{{ idx+1 }}</td>
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.role }}</td>
        <td>
          <router-link class="mx-1 btn btn-sm btn-info" :to="`/users/${user.id}`">detail</router-link>
          <router-link class="mx-1 btn btn-sm btn-warning" :to="`/users/${user.id}/edit`">edit</router-link>
          <button class="mx-1 btn btn-sm btn-danger" @click="deleteUser(user.id)">delete</button>
        </td>
      </tr>
    </tbody>
  </table>
  
</div>
<div v-else>Loading ...</div>
</template>

<script>
import { SERVER_URL } from '../../lib/const';
import MessageBlock from '../../components/MessageBlock.vue';
import store from '../../store';

export default {
  name: 'UserIndex',
  components: {
    MessageBlock,
  },
  setup() { window.document.title = 'Daftar User'; },
  data() {
    return {
      'users': null
    }
  },
  methods: {
    deleteUser(uId) {
      fetch(SERVER_URL+'api/users/'+uId, { 
        method: 'delete',
        headers: { 
          "Accept": "application/json",
          'Authorization': 'Bearer '+localStorage.getItem('token') 
        }
      }).then(res=>res.json()).then((data)=>{
        fetch(SERVER_URL+'api/users', {
          headers: { 
            "Accept": "application/json",
            'Authorization': 'Bearer '+localStorage.getItem('token'),
          }
        }).then(res=>res.json()).then(data=>{ this.users = data })
        store.commit('setAlert', {
          status: 'success',
          messages: data.message
        })
      })
    }
  },
  created() {
    fetch(SERVER_URL+'api/users', {
      headers: { 
        "Accept": "application/json",
        'Authorization': 'Bearer '+localStorage.getItem('token') 
      }
    }).then(res=>{
      if(res.status == 401) return this.$router.push('/login');
      return res.json();
    }).then(data=>{ this.users = data })
  }
}
</script>