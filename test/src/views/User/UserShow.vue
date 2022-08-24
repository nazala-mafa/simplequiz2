<template>
  <div v-if="user" class="row justify-content-center">
    <div class="col-8">
      <table class="table text-start">
        <tbody>
          <tr>
            <td>Nama</td>
            <td>: {{ user.name }}</td>
          </tr>
          <tr>
            <td>Role</td>
            <td>: {{ user.role }}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>: {{ user.email }}</td>
          </tr>
          <tr>
            <td>Terverifikasi pada</td>
            <td>: {{ user.email_verified_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div v-else>Loading ...</div>
</template>

<script>
import { SERVER_URL } from "../../lib/const";
export default {
  name: "UserShow",
  setup() {
    window.document.title = "Detail User";
  },
  data() {
    return { user: null };
  },
  created() {
    fetch(SERVER_URL + "api/users/" + this.$route.params.id)
      .then((res) => res.json())
      .then(({ data }) => {
        this.user = data;
      });
  },
};
</script>