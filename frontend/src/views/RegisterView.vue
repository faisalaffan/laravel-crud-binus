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
        class="d-flex justify-center align-stretch mb-4 mt-10 text-h3 font-weight-medium"
      >
        REGISTER
      </div>
      <base-input
        label="Nama Lengkap"
        :loading="false"
        placeholder=""
        v-model="nama_lengkap"
        class="px-10"
      />
      <base-input
        label="Email"
        :loading="false"
        placeholder=""
        v-model="email"
        class="px-10"
      />
      <base-input
        label="RBAC"
        :loading="false"
        placeholder=""
        v-model="rbac"
        class="px-10"
      />
      <app-password
        label="Password"
        :loading="false"
        placeholder=""
        v-model="password"
        class="px-10"
        :show="true"
        @onEnter="register"
      />
      <base-button :color="'teal'" @onClick="register" class="mx-15">
        <div class="white--text">REGISTER</div>
      </base-button>
      <div
        class="d-flex justify-center align-stretch pt-10 pb-10 primary--text"
        style="cursor: pointer"
      >
        <span class="mx-3" @click="toLogin">LOGIN</span>
        <span class="mx-3" @click="toForgotPassword">FORGOT PASSWORD</span>
      </div>
    </v-card>
  </div>
</template>

<script>
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
      nama_lengkap: "",
      email: "",
      password: "",
      rbac: "",
    };
  },
  methods: {
    async register() {
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

      const res = await AuthService.register({
        nama_lengkap: this.nama_lengkap,
        email: this.email,
        password: this.password,
        rbac: this.rbac,
      });
      if (res.code !== 200) {
        Swal.alertError(
          "Gagal Register",
          "Masukkan email / password yang benar"
        );
        return;
      }
      Swal.alertSuccess(
        "Success Register",
        `Berhasil Register`
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
    toForgotPassword() {
      this.$router.push({
        name: "forgot-password",
      });
    },
  },
};
</script>

<style></style>
