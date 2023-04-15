// import { createApp } from 'vue'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueCookie from 'vue3-cookies'
axios.defaults.withCredentials = true;
axios.defaults.baseURL = process.env.VUE_APP_API_ENDPOINT


// import store from "vue3-storage";
// import { register } from 'register-service-worker'

// axios.interceptors.response.use(
//   response => response,
//   error => {
//     console.log("pesan dari interceptor");
//     console.log(error.message);
//     if (error.message === 'Network Error') {
//       error.response = error.response ?? {};
//       error.response.data = error.response.data ?? {};
//       error.response.data.message = "Tidak dapat terhubung ke server, periksa jaringan internet anda";
//       return Promise.reject(error);
//     }

//     if (error.response.status === 401) {
//       error.response = error.response ?? {};
//       error.response.data = error.response.data ?? {};
//       error.response.data.message = "Sesi habis, silahkan login kembali";
//       // tambahkan kode untuk menangani status 401 Unauthorized di sini
//       VueCookie.delete("token");
//       router.replace({ path: "/", query: {} });
//     }

//     if (error.response.status === 500) {
//       error.response = error.response ?? {};
//       error.response.data = error.response.data ?? {};
//       error.response.data.message = error.response.data.message ?? "Opps. terjadi kesalahan, hubungi admin!";
//     }
//     return Promise.reject(error);
//   }
// );

// register('/service-worker.js', {
//   registrationOptions: { scope: './' },
//   ready (registration) {
//     console.log('Service worker is active.')
//   },
//   registered (registration) {
//     console.log('Service worker has been registered.')
//   },
//   cached (registration) {
//     console.log('Content has been cached for offline use.')
//   },
//   updatefound (registration) {
//     console.log('New content is downloading.')
//   },
//   updated (registration) {
//     console.log('New content is available; please refresh.')
//   },
//   offline () {
//     console.log('No internet connection found. App is running in offline mode.')
//   },
//   error (error) {
//     console.error('Error during service worker registration:', error)
//   }
// })

loadFonts()

createApp(App)
  .use(VueAxios, axios)
  .use(router)
  .use(VueCookie)
//   .use(VueCookies, {
//     expireTimes: "30d",
//     path: "/",
//     domain: "",
//     secure: true,
//     sameSite: "None"
// })
  // .use(Vue3Storage, { namespace: "pro_", storage: StorageType.Local })
  .use(vuetify)
  .mount('#app')
