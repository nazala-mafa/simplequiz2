<template>
  <div v-if="alert" :class="`message-block ${alert.status}`">
    {{ alert.messages }}
    <span class="close" @click="closeBox">x</span>
  </div>
</template>

<script>
import store from '../store'
export default {
  name: 'MessageBlock',
  data(){
    return { 
      alert: null
    }
  },
  methods: {
    closeBox() {
      this.alert = null;
      store.commit('setAlert', null)
    }
  },
  created() {
    this.alert = this.$store.state.alert
  }
}
</script>

<style scoped>
.close {
  position: absolute;
  right: 15px;
  cursor: pointer;
}
.message-block {
  position: relative;
  border: 1px solid;
  border-radius: 5px;
  padding: 7px 40px 7px 20px;
  margin: 10px auto;
  width: fit-content;
}
.success {
  background-color: var(--blue);
  color: var(--white);
  border-color: var(--blue);
}
</style>