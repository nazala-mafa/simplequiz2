<template>
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <textarea rows="4" class="form-control" placeholder="Quest" v-model="formData.quest"></textarea>
          </div>
          <div id="answers">
            <div class="input-group mb-3" v-for="(answer, idx) in formData.answers" :key="idx">
              <div class="input-group-text">
                <input class="form-check-input mt-0" type="checkbox" v-model="formData.answers[idx].is_true" aria-label="Checkbox for following text input">
              </div>
              <input type="text" class="form-control" aria-label="Answer" :placeholder="'Answers ' + (idx+1)" v-model="formData.answers[idx].text">
              <div class="input-group-text" v-if="idx">
                <button class="btn btn-danger" @click="deleteAnswerInput(idx)">delete</button>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <button type="button" class="btn btn-primary mb-2 w-100" @click="addAnswerInput">Add Answer</button>
            <button v-if="!question_id" type="submit" class="btn btn-primary mb-2 w-100">Submit</button>
            <button v-if="question_id" type="submit" class="btn btn-warning mb-2 w-100">Update</button>
            <button v-if="question_id" class="btn btn-warning mb-2 w-100" @click="cancelUpdate">Cancel</button>
          </div>
        </form>
      </div>
      <div class="col-md-7">
        <div class="card">
          <div class="card-body" style="height: 80vh; overflow: scroll;">

            <div class="card mb-3 text-start" v-for="quest in questions" :key="quest.qId">
              <div class="card-body">
                <div class="mb-2">{{quest.quest}}</div>
                <div v-for="(answer, idx) in quest.answers" :key="idx">
                  <div :class="'border rounded-2 p-2 mb-1 '+(answer.is_true && 'bg-primary text-white')">
                    {{abc[idx]}}, {{answer.text}}
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-end">
                <button class="btn btn-primary btn-sm px-3" @click="editQuestion(quest)">edit</button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const abc = ['A','B','C','D','E','F','G']
import { SERVER_URL } from '../../lib/const';
export default {
  data() {
    return {
      formData: {
        quest: '',
        test_id: null,
        question_id: null,
        answers: [
          {
            text: null,
            is_true: false
          }
        ],
      },
      questions: [],
      question_id: null,
      abc,
    }
  },
  methods: {
    submitForm() {
      // if(this.formData.quest == '' || this.formData.answers[0].text != null) return;
      console.log(this.formData);

      fetch(SERVER_URL + "api/question", {
        method: "post",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        body: JSON.stringify(this.formData)
      })
        .then((res) => res.json())
        .then(({message}) => {
          console.log(message);
          this.renderQuestions()
        });

      this.cancelUpdate()
    },
    renderQuestions() {
      fetch(SERVER_URL + "api/question?id="+this.$route.params.id, {
          method: "get",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
          .then((res) => res.json())
          .then(({data}) => {
            this.questions = data.questions;
          });
    },
    addAnswerInput() {
      this.formData.answers.push({
        text: null,
        is_true: false
      })
    },
    editQuestion(quest) {
      this.formData.quest = quest.quest;
      this.formData.question_id = quest.id;
      this.question_id = quest.id;
      if(quest.answers.length) {
        this.formData.answers = quest.answers;
      }else{
        this.formData.answers = [
          {
            text: null,
            is_true: false
          }
        ]
      }
    },
    cancelUpdate() {
      this.formData = {
        ...this.formData,
        quest: '',
        question_id: null,
        answers: [
          {
            text: null,
            is_true: false
          }
        ],
      }
      this.question_id = null
    },
    deleteAnswerInput(idx) {
      this.formData.answers = this.formData.answers.filter(function(_, thisIdx) {
        return idx != thisIdx;
      })
    }
  },
  created() {
    this.formData.test_id = this.$route.params.id;
    this.renderQuestions()
  }
}
</script>