export default [
  {
    path: '/users',
    component: () => import('../views/User/UserIndex.vue')
  },{
    path: '/users/:id',
    component: () => import('../views/User/UserShow.vue')
  },{
    path: '/users/:id/edit',
    component: () => import('../views/User/UserEdit.vue')
  },{
    path: '/users/create',
    component: () => import('../views/User/UserCreate.vue')
  },
];