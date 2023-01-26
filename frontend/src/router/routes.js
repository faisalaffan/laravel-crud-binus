export const routes = [
  {
    path: "/",
    name: "home",
    component: () =>
      import(/* webpackChunkName: "HomeView" */ "@/views/HomeView.vue"),
    meta: {
      auth: true,
    },
  },
  {
    path: "/about",
    name: "about",
    component: () =>
      import(/* webpackChunkName: "AboutView" */ "@/views/AboutView.vue"),
    meta: {
      auth: true,
    },
  },
  {
    path: "/login",
    name: "login",
    component: () =>
      import(/* webpackChunkName: "LoginView" */ "@/views/LoginView.vue"),
    meta: {
    },
  },
  {
    path: "/register",
    name: "register",
    component: () =>
      import(/* webpackChunkName: "LoginView" */ "@/views/RegisterView.vue"),
    meta: {
    },
  },
  {
    path: "/forgot-password",
    name: "forgot-password",
    component: () =>
      import(/* webpackChunkName: "LoginView" */ "@/views/ForgotPasswordView.vue"),
    meta: {
    },
  },
];
