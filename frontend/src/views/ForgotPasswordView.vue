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
        class="d-flex justify-center align-stretch mb-15 text-h4 font-weight-medium"
      >
        FORGOT PASSWORD
      </div>
      <base-input
        label="Email"
        :loading="false"
        placeholder=""
        v-model="email"
        class="px-10"
        @onEnter="login"
      />
      <app-password
        label="New Password"
        :loading="false"
        placeholder=""
        v-model="password"
        class="px-10"
        :show="true"
        @onEnter="login"
      />
      <base-button :color="'teal'" @onClick="login" class="mx-15">
        <div class="white--text">LOGIN</div>
      </base-button>
      <div
        class="d-flex justify-center align-stretch pt-15 primary--text"
        style="cursor: pointer"
      >
        <span class="mx-3" @click="toLogin">LOGIN</span>
      </div>
    </v-card>
  </div>
</template>

<script>
import Cookies from "js-cookie";
import Swal from "@/utils/Swal";
import AuthService from '@/usecase/AuthService';

export default {
  components: {
    AppPassword: () => import("@/components/AppPassword.vue"),
    BaseInput: () => import("@/components/Base/BaseInput.vue"),
    BaseButton: () => import("@/components/Base/BaseButton.vue"),
  },
  data() {
    return {
      email: "faisallionel@gmail.com",
      password: "Password.1",
    };
  },
  methods: {
    async login() {
      if (this.password.length < 10) {
        Swal.alertError("Gagal Register", "Password minimal 10 angka");
        return;
      }

      let regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/gm;
      if (!regex.test(this.password)) {
        Swal.alertError(
          "Gagal Register",
          "Password harus mempunyai kombinasi huruf kecil, huruf besar, angka, dan symbol."
        );
        return;
      }
      
      const res = await AuthService.forgotPassword({
        email: this.email,
        password_new: this.password,
      });
      if (res.code !== 200) {
        Swal.alertError("Gagal Forgot Password", "Masukkan email / password yang benar");
        return;
      }
      await Cookies.set("token", res.data.access_token);
      Swal.alertSuccess(
        "Success Ganti Password",
        `Berhasil Diganti Password`
      );
      setTimeout(() => {
        return this.$router.push({
          name: "login",
        });
      }, 1000);
    },
    toLogin() {
      this.$router.push({
        name: "login",
      });
    },
  },
};
</script>

<style></style>
