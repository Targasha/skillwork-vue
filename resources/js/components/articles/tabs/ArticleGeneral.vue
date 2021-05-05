<template>
  <div>
    <!-- <section class="mb-6">
      <div class="text-h6">{{ $t("articles.edit-page.title") }}</div>
    </section> -->

    <v-sheet>
      <v-progress-linear
        indeterminate
        color="primary"
        v-if="loading"
      ></v-progress-linear>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-container>
          <v-row>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="article.title"
                :rules="rules.title"
                :counter="255"
                :label="$t('articles.fields.title')"
              ></v-text-field>
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="4">
              <v-textarea
                v-model="article.content"
                :label="$t('articles.fields.content')"
              ></v-textarea>
            </v-col>
          </v-row>

          <v-btn color="warning" @click="submit">{{ $t("btn.update") }}</v-btn>
          <v-btn to="/articles">{{ $t("btn.cancel") }}</v-btn>
        </v-container>
      </v-form>
    </v-sheet>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
  props: ["lang"],
  data() {
    return {
      loading: false,
      valid: false,
      rules: {
        title: [
          v => !!v || this.$t("rules.required"),
          v => (!!v && v.length <= 255) || this.$t("rules.max", { max: 255 }),
        ]
      }
    }
  },

  computed: {
    ...mapState({
      article: state => state.articleService.item
    })
  },

  watch: {
    lang(a, b) {
      this.resetValidation();
    },
  },

  created() {
    //
    console.log(this.article);
  },

  methods: {
    ...mapActions("alert", ["success", "error", "clear"]),
    ...mapActions("articleService", ["updateArticle"]),

    submit() {
      if (this.validate()) {
        this.updateArticle(this.article);
      } else {
        this.error("Form is not valid!");
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

