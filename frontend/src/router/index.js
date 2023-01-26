import Vue from "vue";
import VueRouter from "vue-router";
import Cookies from "js-cookie";
import { routes } from "./routes.js";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.auth)) {
    const isLoggedIn = Cookies.get("token");
    if (typeof isLoggedIn == "undefined" || isLoggedIn == "") {
      next({
        path: "/login",
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
