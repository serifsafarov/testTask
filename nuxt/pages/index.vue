<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="8" md="6">
      <v-card class="logo py-4 d-flex justify-center">
        <v-img contain max-height="300" sizes="small" src="/prizebox.png"></v-img>
      </v-card>

      <v-card v-if="prize">
        <v-card-title class="headline">
          Поздравляем!
        </v-card-title>
        <v-card-text>
          <p>{{prize.message}}</p>
        </v-card-text>
        <v-card-actions>
          <v-spacer/>

          <v-btn
            v-if="prize.type === 'money' && prize.status === 'draft'"
            color="primary"
            nuxt
            @click.prevent="chengeToBonus"
          >
            Поменять на бонусы
          </v-btn>
          <v-btn
            v-if="prize.type === 'gift' && prize.status === 'draft'"
            color="primary"
            nuxt
            @click.prevent="rejectGift"
          >
            Отказаться
          </v-btn>

        </v-card-actions>
      </v-card>

      <v-card v-else>
        <v-card-title class="headline">
          Добро пожаловать
        </v-card-title>
        <v-card-text>
          <p>Нажмите на кнопку, чтобы получить случайный приз</p>
        </v-card-text>
        <v-card-actions>
          <v-spacer/>
          <v-btn
            color="primary"
            nuxt
            @click.prevent="getPrize"
          >
            Получить приз
          </v-btn>
        </v-card-actions>
      </v-card>

    </v-col>
  </v-row>
</template>

<script>
export default {
  data(){
    return {
      prize: null
    }
  },
  methods: {
    async getPrize() {
      this.$api('get', '/api/api/prize/win').then(res => {
        this.prize = res.data
      }).catch(err => {
        this.$toast.error(Object.values(err)[0])
      })
    },
    async chengeToBonus() {
      this.$api('post', '/api/api/prize/change_to_bonus', {
        id: this.prize.id
      }).then(res => {
        this.prize = res.data
      }).catch(err => {
        this.$toast.error(Object.values(err)[0])
      })
    },
    async rejectGift() {
      this.$api('delete', '/api/api/prize/reject_gift', {
        id: this.prize.id
      }).then(res => {
        this.prize = null
      }).catch(err => {
        this.$toast.error(Object.values(err)[0])
      })
    }
  }
}
</script>
