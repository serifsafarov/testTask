<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="8" md="6">
      <v-card>
        <v-card-title class="headline">
          Вход
        </v-card-title>
        <v-card-text>
          <form>
            <v-text-field
              v-model="email"
              label="E-mail"
              required
            ></v-text-field>
            <v-text-field
              v-model="password"
              label="Пароль"
              type="password"
              required
            ></v-text-field>
          </form>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="primary"
            nuxt
            @click.prevent="login"
          >
            Продолжить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  auth: 'guest',
  layout: 'auth',
  data(){
    return {
      email: 'test@test.com',
      password: '123123123'
    }
  },
  methods: {
    login(){
      this.$auth.loginWith('laravelSanctum', {
        data: {
          email: this.email,
          password: this.password
        }
      }).then(() => {
        this.$router.replace('/')
      }).catch(() => {
        this.$toast.error('Неверные логин и/или пароль')
      })
    }
  }
}
</script>
