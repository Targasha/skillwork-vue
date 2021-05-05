<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card>
          <v-toolbar dark flat>
            <v-toolbar-title>{{ $t("verify_email") }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-progress-circular
              :indeterminate="true"
              :size="36"
              :width="4"
              v-if="loading"
            ></v-progress-circular>
          </v-toolbar>

          <v-form ref="form" v-model="valid" lazy-validation>
            <v-text-field
              label="Email"
              name="email"
              v-model="payload.email"
              :rules="rules.email"
              prepend-icon="mdi-at"
              type="text"
              required
            ></v-text-field>
          </v-form>
          <v-card-actions>
            <v-btn to="/login" color="primary">
              <v-icon left dark> mdi-login </v-icon>
              Login</v-btn
            >
            <v-spacer></v-spacer>
            <v-btn color="success" @click="send">
              {{ $t("btn.send") }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from "axios";
import { mapActions } from 'vuex';

export default {
  middleware: "guest",

  metaInfo() {
    return { title: this.$t("verify_email") };
  },

  data: () => ({
    valid: true,
    loading: false,
    status: "",
    payload: {
      email: "",
    },
    rules: {
      email: [
        v => !!v || "E-mail is required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
    },
  }),

  created() {
    if (this.$route.query.email) {
      this.payload.email = this.$route.query.email;
    }
  },

  methods: {
    ...mapActions('alert', ['success', 'error', 'clear']),
    send() {
      if (this.validate()) {
          this.loading = true;
        axios.post("/email/resend", this.payload)
          .then(({ data }) => {
            this.status = data.status;
          })
          .catch(error => {
            this.error(error);
          })
          .finally(() => {
            this.$refs.form.reset();
            this.loading = false
          });

      }
    },

    validate() {
      return this.$refs.form.validate();
    },

    reset() {
      this.$refs.form.reset();
    },

    resetValidation() {
      this.$refs.form.resetValidation();
    },
  },
};
</script>
