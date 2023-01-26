<template>
  <div
    class="about d-flex flex-column justify-center align-center"
    style="height: 100vh"
  >
    <h1>Hello Welcome To Laravel AUTH Using JWT</h1>
    <div class="text-left grey">
      <div>ID USER: {{ userInfo?.id_user }}</div>
      <div>NAMA LENGKAP: {{ userInfo?.nama_lengkap }}</div>
      <div>EMAIL: {{ userInfo?.email }}</div>
      <div>RBAC: {{ userInfo?.rbac }}</div>
    </div>
    <base-button
      :color="'teal'"
      @onClick="logout"
      class="mt-5"
      :disabled="counter > 0 || isRobot"
    >
      <div class="white--text">LOGOUT</div>
    </base-button>
  </div>
</template>

<script>
import Cookies from "js-cookie";
export default {
  components: {
    BaseButton: () => import("@/components/Base/BaseButton.vue"),
  },
  data() {
    return {
      userInfo: {},
    };
  },
  created() {
    const res = Cookies.get("userInfo");
    this.userInfo = JSON.parse(res);
  },
  methods: {
    logout() {
      Cookies.remove("token");
      this.$router.push({
        name: "login",
      });
    },
  },
};
</script>
