import { createStore } from 'vuex'

export default createStore({
  state: {
    alert: null,
    time: null
  },
  getters: {
    getAlert(state) { return state }
  },
  mutations: {
    setAlert(state, payload) {
      state.alert = payload
    },
    countDown(state, payload) {
      state.time = payload
      for (let i = 0; i < state.time; i++) {
        setInterval(function(){
          --state.time;
        }, 1000)
      }
    }
  },
  actions: {
  },
  modules: {
  }
})
