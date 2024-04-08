import {createApp} from 'vue'

import App from './App.vue'

import 'vuetify/dist/vuetify.min.css';
import { createVuetify } from 'vuetify';

import '/resources/css/app.css'

import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'https://api.example.com', // Replace with your API base URL
    headers: {
        'Content-Type': 'application/json',
        // Add any other default headers here
    },
});

const vuetify = createVuetify({
    // Add your Vuetify configuration here
});

const app = createApp(App);
app.use(vuetify);
app.mount("#app")


