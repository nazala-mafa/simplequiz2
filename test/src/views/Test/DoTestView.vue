<template>
  <div v-if="questions">
    <div class="header">
      <h1>{{ title }}</h1>
      <div>
        <span class="finishTest" @click="finishTest()">Akhiri Test</span>
      </div>
    </div>
    <div class="question">
      <div class="number">{{ currentQuestionIdx + 1 }}</div>
      <div class="quest">{{ questions[currentQuestionIdx].quest }}</div>
      <div class="answers">
        <label
          v-for="(answer, idx) in questions[currentQuestionIdx].answers"
          :class="{answered: (idx === userAnswers[currentQuestionIdx].answerIdx)}"
          :key="answer.id"
          @click="
            answering(
              questions[currentQuestionIdx].id,
              currentQuestionIdx,
              answer.aId,
              idx
            )
          "
          >{{ abc[idx] }}. {{ answer.text }}</label
        >
      </div>
    </div>
    <div class="navigate">
      <button class="prev" @click="prevQuestion()">Sebelumnya</button>
      <button :class="{hesitant: true, active: userAnswers[currentQuestionIdx].isHesitant}" @click="hesitantAnswer(currentQuestionIdx)">Ragu-ragu</button>
      <button class="next" @click="nextQuestion()">Selanjutnya</button>
      <label>
        <input type="checkbox" value="1" v-model="isAutoNext" />auto next
      </label>
    </div>

    <button id="show-answers" @click="isUserAnswerShown = !isUserAnswerShown">
      <h5 class="m-0">&#9783;</h5>
    </button>
    <div :class="{ 'user-answers': true, 'active': isUserAnswerShown }">
      <div>
        <div :class="{card: true, hesitant: ua.isHesitant}" v-for="(ua, idx) in userAnswers" :key="idx" @click="changeQuestion(idx)">
          {{ idx + 1 }}, {{ abc[ua.answerIdx] }}
        </div>
      </div>
      <button id="close-answers" @click="isUserAnswerShown = !isUserAnswerShown">Close</button>
    </div>
  </div>
  <p v-else>Loading ...</p>
</template>

<script>
import { SERVER_URL } from '../../lib/const';
const ABC = ["a", "b", "c", "d", "e", "f", "g"]
export default {
  name: "DoTestView",
  data() {
    return {
      abc: ABC,
      title: "Contoh Soal",
      questions: null,
      currentQuestionIdx: 0,
      isAutoNext: false,
      isUserAnswerShown: false,
      userAnswers: null
    };
  },
  methods: {
    prevQuestion() {
      this.currentQuestionIdx !== 0 && this.currentQuestionIdx--;
    },
    nextQuestion() {
      this.currentQuestionIdx !== this.questions.length - 1 && this.currentQuestionIdx++;
    },
    answering(qId, qIdx, aId, aIdx) {
      // main answering
      this.userAnswers[qIdx].answerId = aId; // Answer ID
      this.userAnswers[qIdx].answerIdx = aIdx; // Answer Index
      this.userAnswers[qIdx].isHesitant = false;
      
      // save to localStorage
      localStorage.setItem('userAnswers', JSON.stringify(this.userAnswers))

      //auto next
      if (this.isAutoNext) this.nextQuestion();
    },
    changeQuestion(qIdx){
      this.isUserAnswerShown = false
      this.currentQuestionIdx = qIdx
      let aIdx = this.userAnswers[qIdx].answerIdx
    },
    hesitantAnswer(dIdx) {
      this.userAnswers[dIdx].isHesitant = true
    },
    finishTest() {
      // localStorage.removeItem('userAnswers')
      this.$router.push(`/test/${this.$route.params.slug}/getScore`);
    }
  },
  created() {
    let localUA = localStorage.getItem('userAnswers');
    if( localUA ) this.userAnswers = JSON.parse( localUA );

    fetch(SERVER_URL+'api/test/'+this.$route.params.slug, {
      headers: {
        "Accept": "application/json",
        "Authorization": 'Bearer '+localStorage.getItem('token') 
      }
    }).then(res=>res.json()).then(({data})=>{
      
      this.questions = data.questions
      this.userAnswers = this.userAnswers || data.questions.map(function (q) {
        return {
          isHesitant: false,
          questionId: q.id,
          answerId: null,
          answerIdx: null,
        };
      })

    })
  }
};
</script>

<style lang="scss" scoped>
%cardWidth {
  width: 90vw;
  max-width: 500px;
  margin: auto;
}
.question {
  @extend %cardWidth;
  padding: 1rem 3rem;
  border: 1px solid #555;
  position: relative;
  .number {
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 1.8rem;
    width: 1.8rem;
    border-radius: 2rem;
    border: 1px #555 solid;
    top: 0.5rem;
    left: 0.5rem;
  }
  .quest {
    text-align: left;
    margin: 0.2rem 0 0.4rem;
  }
  .answers {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    label {
      text-align: left;
      padding: 0.2rem;
      margin: 0.2rem;
      cursor: pointer;
      &.answered {
        background-color: lightgreen;
        color: #333;
      }
    }
  }
}
.navigate {
  @extend %cardWidth;
  margin-top: 1rem;
  display: flex;
  gap: 1rem;
  > button {
    cursor: pointer;
    width: 100%;
    border: none;
    padding: 0.4rem 1rem;
  }
  > label {
    white-space: nowrap;
    > input {
      margin-top: 4px;
    }
  }
  .hesitant.active {
    background-color: lightblue;
    color: white;
  }
}
#show-answers {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #666;
  border-radius: 2rem;
  border: none;
  width: 3.2rem;
  height: 3.2rem;
  color: #fff;
  cursor: pointer;
  position: fixed;
  bottom: 10vh;
  right: 10vw;
  transition: all 0.5s;
  &:hover {
    bottom: 12vh;
    background-color: #444;
    box-shadow: #999 0 10px 3px 0;
  }
}
.user-answers {
  position: fixed;
  top: 0;
  left: 0;
  opacity: 0;
  z-index: -10;
  transition: all .3s;
  > div {
    display: grid;
    grid-template-columns: repeat(5,1fr);
    gap: .4rem;
    margin: 1rem 1rem .6rem;
    padding: 1rem;
    border-radius: 1rem;
    border: 1px solid #fff;
    .card {
      border: 1px solid #ccc;
      border-radius: .4rem;
      padding: .3rem;
      cursor: pointer;
    }
  }
  > div::before {
    content: "";
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: #333e;
    z-index: -1;
  }
  #close-answers {
    padding: .4rem 1.4rem;
    border-radius: .6rem;
    cursor: pointer;
    border: 1px solid white;
    background-color: #333e;
    color: white;
  }
  &.active {
    opacity: 1;
    z-index: 1;
  }
  .card.hesitant {
    background-color: lightblue;
  }
}
.header {
  display: flex;
  justify-content: space-between;
  align-content: center;
  max-width: 600px;
  margin: auto;
  > div {
    display: flex;
    .finishTest {
      margin: auto;
      padding: .3rem 1rem;
      border-radius: .3rem;
      background-color: #555;
      color: white;
      cursor: pointer;
    }
  }
}
</style>
