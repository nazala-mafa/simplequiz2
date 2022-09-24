<template>
  <h1>Edit Test</h1>
  <form @submit.prevent="submitTest">
    <input type="text" placeholder="Test title" v-model="formData.title" />
    <textarea
      rows="4"
      placeholder="Test description"
      v-model="formData.desc"
    ></textarea>
    <button class="btn btn-primary" type="submit">Update Test</button>
    <a class="btn btn-warning" :href="'/test/addQuestion/' + formData.id">Add Questions</a>
  </form>
</template>

<script>
import { SERVER_URL } from "../../lib/const";
import store from "../../store";
export default {
  data() {
    return {
      formData: {
        id: "",
        title: "",
        desc: "",
      },
    };
  },
  methods: {
    submitTest() {
      fetch(SERVER_URL + "api/test/" + this.$route.params.id, {
        method: "put",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        body: JSON.stringify(this.formData),
      })
        .then((res) => res.json())
        .then((data) => {
          console.log(data);
          store.commit("setAlert", {
            status: "success",
            messages: data.message,
          });
          this.$router.push("/test");
        });
    },
  },
  created() {
    fetch(SERVER_URL + "api/test/" + this.$route.params.id, {
      method: "get",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("token"),
      }
    })
      .then((res) => res.json())
      .then(({data}) => {
        if(data.test) {
          this.formData = data.test
        }
      });
  },
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
  input,
  textarea {
    display: block;
    padding: 0.2rem;
    width: 100%;
  }
}
</style>