<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('verify_email')">
        <template v-if="success">
          <v-alert type="success">
            {{ success }}
          </v-alert>

         <v-btn to="/login"
            color="primary"
        >
            <v-icon
                left
                dark

            >
                mdi-login
            </v-icon>
        Login</v-btn>
        </template>
        <template v-else>
          <v-alert type="error">
            {{ error || $t('failed_to_verify_email') }}
          </v-alert>

          <v-btn :to="{ name: 'Resend' }" class="float-right">
            {{ $t('resend_verification_link') }}
          </v-btn>
        </template>
      </card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

const qs = (params) => Object.keys(params).map(key => `${key}=${params[key]}`).join('&')

export default {
  async beforeRouteEnter (to, from, next) {
    try {
      const { data } = await axios.post(`/email/verify/${to.params.id}/${to.params.hash}?${qs(to.query)}`)

      next(vm => { vm.success = data.status })
    } catch (e) {
      next(vm => { vm.error = e.response.data.status })
    }
  },

  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('verify_email') }
  },

  data: () => ({
    error: '',
    success: ''
  })
}
</script>
