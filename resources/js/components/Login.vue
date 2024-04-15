<template>
    <div>
        <!-- Dialog for the login form -->
        <v-dialog v-model="dialog" max-width="500px" class="frosted" persistent>
            <v-card>
                <v-card-title>Login</v-card-title>

                <!-- Login Form -->
                <v-card-text>
                    <v-form @submit.prevent="login">
                        <!-- Login Field -->
                        <v-text-field
                            label="Login"
                            v-model="loginForm.login"
                            required
                        ></v-text-field>

                        <!-- Password Field -->
                        <v-text-field
                            label="Password"
                            v-model="loginForm.password"
                            type="password"
                            required
                        ></v-text-field>

                        <!-- Submit Button -->
                        <v-btn type="submit" color="primary">Login</v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import {VBtn, VCard, VCardText, VCardTitle, VDialog, VForm, VTextField} from "vuetify/components";

export default {
    name: "Login",
    components: {
        VBtn,
        VDialog,
        VCard,
        VCardTitle,
        VCardText,
        VForm,
        VTextField
    },
    data() {
        return {
            dialog: true, // Open by default
            loginForm: {
                login: 'c0886610@mylambton.ca',
                password: 'password',
            },
        };
    },
    methods: {
        login() {
            // Here you can handle the login logic
            console.log('Logging in with:', this.loginForm);

            // Close the dialog after login attempt
            this.dialog = false;
        },
    },
};
</script>

<style scoped>
.frosted {
    backdrop-filter: blur(5px); /* Frosted background */
}
</style>
