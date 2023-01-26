<template>
  <div class="about">
    <h1>This is an about page</h1>
    <button @click="logout">LOGOUT</button>
  </div>
</template>

<script>
import jsCookie from 'js-cookie'
export default {
  methods: {
    logout() {
      jsCookie.remove('token')
    }
  }
}
</script>
