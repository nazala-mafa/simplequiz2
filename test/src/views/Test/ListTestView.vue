<template>
  <div v-if="!tests">Loading ...</div>
  <div v-else class="mx-lg-4 mx-sm-2">
    <header>
      <h1>List Test Page</h1>
      <a href="/test/add">Add test</a>
    </header>
    <div class="tests">
      <div class="test" v-for="test in tests" :key="test.id">
        <h2>{{ test.title }}</h2>
        <p>{{ test.desc }}</p>
        <div class="action">
          <a class="do-test" :href="'/test/' + test.id">Do test</a>
          <a v-if="role == 'admin'" class="edit-test" :href="'/test/edit/' + test.id">Edit test</a>
          <a v-if="role == 'admin'" class="edit-test" @click="deleteTest(test.id)">Delete test</a>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
%btn {
  color: #333;
  border-radius: 0.3rem;
  border: solid 1px #333;
  padding: 0.3rem 1rem;
  margin-bottom: 0.1rem;
  text-decoration: none;
}

header {
  display: flex;
  justify-content: space-between;
  margin: 0 30% 1rem;
  a {
    @extend %btn;
    height: 100%;
  }
}

.tests {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  gap: 1em;
  .test {
    padding: 0.5em;
    border: solid 2px #555;
    border-radius: 1em;
    .action {
      justify-content: center;
      display: flex;
      gap: 0.4rem;
      a {
        color: #000;
        text-decoration: none;
        @extend %btn;
      }
    }
  }
}
</style>

<script>
import { addMeta, getUser } from "../../lib/utils";
import { SERVER_URL } from "../../lib/const";
import store from '../../store';

export default {
  name: "ListTestView",
  setup() {
    window.document.title = "Daftar Test";
    addMeta("description", "konten deskripsi");
  },
  data() {
    return {
      tests: null,
      role: null
    };
  },
  created() {
    getUser().then(data => {
      this.role = data.role
    })

    fetch(SERVER_URL + "api/test", {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("token"),
      },
    })
      .then((res) => {
        if (res.status == 401) return this.$router.push("/login");
        return res.json();
      })
      .then((data) => {
        this.tests = data;
      });
  },
  methods: {
    deleteTest(id) {
      fetch(SERVER_URL + "api/test/" + id, {
        method: "delete",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        body: JSON.stringify(this.formData),
      })
        .then((res) => res.json())
        .then((data) => {
          store.commit("setAlert", {
            status: "success",
            messages: data.message,
          });
          
          // refresh
          fetch(SERVER_URL + "api/test", {
            headers: {
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          })
            .then((res) => {
              if (res.status == 401) return this.$router.push("/login");
              return res.json();
            })
            .then((data) => {
              this.tests = data;
            });

        });
    },
  },
};
</script>