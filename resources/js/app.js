import {createApp} from 'vue'

import App from './App.vue'

import '/resources/css/app.css'

import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'https://api.example.com', // Replace with your API base URL
    headers: {
        'Content-Type': 'application/json',
        // Add any other default headers here
    },
});

createApp(App).mount("#app")
