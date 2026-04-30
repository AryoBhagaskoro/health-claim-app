import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Login from './views/Login.vue'
import '../css/app.css'
createApp(Login).mount('#app')
createApp(App)
  .use(router)
  .mount('#app')