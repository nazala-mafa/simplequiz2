export default [
  {
    path: '/login',
    component: () => import('../views/Auth/LoginView.vue')
  },{
    path: '/logout',
    component: () => import('../views/Auth/LogoutView.vue')
  }
];