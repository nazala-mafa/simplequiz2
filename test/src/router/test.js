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
  }
];