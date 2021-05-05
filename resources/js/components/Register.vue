<template>
    <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">

            <card v-if="mustVerifyEmail" :title="$t('register')">
                <div class="alert alert-success" role="alert">
                {{ $t('verify_email_address') }}
                </div>
            </card>

            <v-col
                cols="12"
                sm="8"
                md="4"
                v-if="!mustVerifyEmail"
            >
                <v-card class="elevation-12">
                    <v-toolbar
                        dark
                        flat
                    >
                        <v-toolbar-title>Sign up</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-progress-circular
                            :indeterminate="true"
                            :size="36"
                            :width="4"
                            v-if="loading"
                        ></v-progress-circular>
                    </v-toolbar>

                    <v-card-text>
                        <v-form
                            ref="form"
                            v-model="valid"
                            lazy-validation
                        >
                            <v-text-field
                                label="Name"
                                name="name"
                                v-model="payload.name"
                                :rules="rules.name"
                                prepend-icon="mdi-account"
                                type="text"
                                required
                            ></v-text-field>

                            <v-text-field
                                label="Email"
                                name="email"
                                v-model="payload.email"
                                :rules="rules.email"
                                prepend-icon="mdi-at"
                                type="text"
                                required
                            ></v-text-field>

                            <v-text-field
                                id="password"
                                label="Password"
                                name="password"
                                :rules="rules.password"
                                v-model="payload.password"
                                prepend-icon="mdi-lock"
                                type="password"
                                required
                            ></v-text-field>

                            <v-text-field
                                label="Password Confirmation"
                                name="password"
                                :rules="rules.passwordConfirmation"
                                v-model="payload.password_confirmation"
                                prepend-icon="mdi-lock"
                                type="password"
                                required
                            ></v-text-field>
                        </v-form>
                    </v-card-text>

                    <v-card-actions>
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
                        <v-spacer></v-spacer>
                        <v-btn @click="validate"
                            :disabled="loading"
                            color="success"
                        >Register</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import { mapState, mapActions } from 'vuex'

    export default {
        data() {
            return {
                mustVerifyEmail: false,
                valid: true,
                payload: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                rules: {
                    name: [
                        v => !!v || 'Name is required',
                    ],
                    email: [
                        v => !!v || 'E-mail is required',
                        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                    ],
                    password: [
                         v => !!v || 'Password is required',
                    ],
                    passwordConfirmation: [
                         v => !!v || 'Password Confirmation is required',
                         v => v === this.payload.password || 'Password Confirmation does not match!',
                    ]
                }
            }
        },
        computed: {
            ...mapState('registerService', ['registered', 'loading'])
        },
        methods: {
            ...mapActions('registerService', ['register']),

            validate () {
                if(this.$refs.form.validate()){
                    this.register(this.payload).then(() => {
                        this.mustVerifyEmail = true;
                    });
                }
            },
            reset () {
                this.$refs.form.reset()
            },
            resetValidation () {
                this.$refs.form.resetValidation()
            },
        },
        created () {
            // reset login status
            localStorage.clear();
        },
    };
</script>
