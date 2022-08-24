export default [
  {
    path: '/posts',
    component: () => import('../views/Posts/PostsView.vue'),
  },{
    path: '/posts/new',
    component: () => import('../views/Posts/AddPostView.vue')
  },{
    path: '/posts/:id',
    component: () => import('../views/Posts/PostView.vue')
  },{
    path: '/posts/:id/edit',
    component: () => import('../views/Posts/EditPostView.vue')
  }
];