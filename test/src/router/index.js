import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import post from './post'
import test from './test'
import user from './user'
import auth from './auth'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  ...user,
  ...post,
  ...test,
  ...auth,
]

const router = createRouter({
  history: createWebHistory(undefined),
  routes
})

export default router
