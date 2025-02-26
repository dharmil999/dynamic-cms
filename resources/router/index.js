import { createRouter, createWebHistory } from 'vue-router'
import PageManagement from '../views/PageManagement.vue' // CRUD (Listing + Tree)
import PageView from '../views/PageView.vue' // Displays Page Content

const routes = [
  { path: '/', component: PageManagement }, // Page Management (CRUD)
  { path: '/:slug(.*)', component: PageView }, // Dynamic Page Content
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
