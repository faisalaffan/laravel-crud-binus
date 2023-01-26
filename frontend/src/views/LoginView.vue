<template>
  <div style="height: 100vh" class="d-flex justify-center align-center">
    <v-card
      elevation="2"
      width="30rem"
      height="30rem"
      class="d-flex justify-center align-stretch flex-column"
      rounded="xl"
    >
      <div
        class="d-flex justify-center align-stretch mb-15 text-h3 font-weight-medium"
      >
        LOGIN
      </div>
      <base-input
        label="Email"
        :loading="false"
        placeholder=""
        v-model="email"
        class="px-10"
        :disabled="counter > 0 || isRobot"
        @onEnter="login"
      />
      <app-password
        label="Password"
        :loading="false"
        placeholder=""
        v-model="password"
        class="px-10"
        :show="true"
        :disabled="counter > 0 || isRobot"
        @onEnter="login"
      />
      <base-button
        :color="'teal'"
        @onClick="login"
        class="mx-15"
        :disabled="counter > 0 || isRobot"
      >
        <div class="white--text">LOGIN</div>
      </base-button>
      <vue-recaptcha
        sitekey="6LdiKiokAAAAAPPwgbZnY_Qp973ew_1m-aUyk7mV"
        @verify="verifyMethod"
        @expired="expiredMethod"
        @render="renderMethod"
        @error="errorMethod"
        class="d-flex justify-center align-stretch pt-1 primary--text"
      >
      </vue-recaptcha>
      <div
        class="d-flex justify-center align-stretch pt-5 primary--text"
        style="cursor: pointer"
        v-if="counter == 0"
      >
        <span class="mx-3" @click="toRegister">REGISTER</span>
        <span class="mx-3" @click="toForgotPassword">FORGOT PASSWORD</span>
      </div>
      <div
        class="d-flex justify-center align-stretch pt-5 primary--text"
        style="cursor: pointer"
        v-if="counter > 0"
      >
        <span class="mx-3">Tunggu Beberapa saat</span>
        <span class="mx-3">{{ counter }}</span>
      </div>
    </v-card>
  </div>
</template>

<script>
import { VueRecaptcha } from "vue-recaptcha";
import Cookies from "js-cookie";
import Swal from "@/utils/Swal";
import AuthService from "@/usecase/AuthService";

export default {
  components: {
    AppPassword: () => import("@/components/AppPassword.vue"),
    BaseInput: () => import("@/components/Base/BaseInput.vue"),
    BaseButton: () => import("@/components/Base/BaseButton.vue"),
    VueRecaptcha,
  },
  data() {
    return {
      email: "faisallionel@gmail.com",
      password: "Password.1",
      missPassCount: 0,
      counter: 0,
      intervalCounter: null,
      isRobot: true,
    };
  },
  watch: {
    counter() {
      if (this.counter == 0) {
        clearInterval(this.intervalCounter);
        this.intervalCounter = null;
      }
    },
    missPassCount() {
      if (this.missPassCount == 3) {
        this.hitCounter();
      }
    },
  },
  methods: {
    async login() {
      const res = await AuthService.login({
        email: this.email,
        password: this.password,
      });

      if (res.code !== 200) {
        this.missPassCount += 1;
        Swal.alertError("Gagal Login", "Masukkan email / password yang benar");
        return;
      }
      await Cookies.set("token", res.data.access_token);
      Swal.alertSuccess(
        "Success Login",
        `Silahkan Masuk ${res?.data?.payload?.nama_lengkap}`
      );
      setTimeout(() => {
        return this.$router.push({
          name: "about",
        });
      }, 1000);
    },
    toRegister() {
      this.$router.push({
        name: "register",
      });
    },
    toForgotPassword() {
      this.$router.push({
        name: "forgot-password",
      });
    },
    hitCounter() {
      this.counter = 30;
      if (this.counter != 0) {
        this.intervalCounter = setInterval(() => {
          this.counter -= 1;
        }, 1000);
      }
    },
    verifyMethod() {
      this.isRobot = false
    },
    expiredMethod() {
      this.isRobot = true
    },
    renderMethod() {
      this.isRobot = true
    },
    errorMethod() {
      this.isRobot = true
    },
  },
};
</script>

<style></style>
