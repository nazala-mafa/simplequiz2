<template>
  <h2>Your Score Is</h2>
  <h1>{{myScore}}</h1>
  <h3 v-if="isPassedTest">Congrats you has been passed the test</h3>
  <h3 v-else>You haven't passed the test, keep learning and don't give up</h3>
</template>

<script>
import { SERVER_URL } from '../../lib/const'
export default {
  name: 'GetScore',
  setup() {},
  data() {
    return {
      myScore: 0,
      isPassedTest: true,
    }
  },
  beforeCreate() {
    fetch(SERVER_URL+'api/test/get-score/'+this.$route.params.slug+'/'+1, {
      method: 'post',
      headers: { 
        'Content-Type': 'application/json',
        "Accept": "application/json",
        "Authorization": 'Bearer '+localStorage.getItem('token') 
      },
      body: localStorage.getItem('userAnswers')
    }).then(res=>res.json()).then(({score, isPassed})=>{ 
      this.myScore = score*100
      this.isPassedTest = isPassed
    }).then(()=>{ localStorage.removeItem('userAnswers') })
  }
}
</script>