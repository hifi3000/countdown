import { createRouter, createWebHistory } from "vue-router";
import Page from "../pages/Page.vue";
import Login from "../pages/Login.vue";

const routes = [
  { path: "/", component: Page },
  { path: "/login", component: Login },
  { path: "/:notFound(.*)", component: Page },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
