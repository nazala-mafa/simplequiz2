export default [
  {
    path: '/test',
    component: () => import('../views/Test/ListTestView.vue')
  },{
    path: '/test/:slug',
    component: () => import('../views/Test/DoTestView.vue')
  },{
    path: '/test/:slug/getScore',
    component: () => import('../views/Test/GetScore.vue')
  },{
    path: '/test/add',
    component: () => import('../views/Test/CreateTestView.vue')
  },{
    path: '/test/edit/:id',
    component: () => import('../views/Test/EditTestView.vue')
  },{
    path: '/test/addQuestion/:id',
    component: () => import('../views/Test/AddQuestionView.vue')
  }
];