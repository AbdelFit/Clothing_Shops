   import axios from "axios"
   import Echo from 'laravel-echo'
   const getLocalUser = () => {
       const userStr = localStorage.getItem('user')
       if (!userStr) {
           return null
       }
       return JSON.parse(userStr)
   }
   const response = (router, store) => {
       axios.interceptors.response.use(null, (error) => {
           if (error.response.status === 401) {
               store.commit('logout')
               router.push('/login')
           }
           return Promise.reject(error)
       })
   }

   const request = store => {
       axios.interceptors.request.use(
           config => {
               const currentUser = store.getters.currentUser
               if (currentUser) {
                   config.headers['Authorization'] = `Bearer ${currentUser.token}`;
               }
               return config;
           },
           error => {
               return Promise.reject(error);
           }
       );
       if (store.getters.currentUser) {
           window.Pusher = require('pusher-js');
           window.Echo = new Echo({
               broadcaster: 'pusher',
               key: '4f30b0e6d9f5bc39e5d4',
               cluster: 'eu',
               encrypted: true,
               auth: {
                   headers: {
                       Authorization: 'Bearer ' + store.getters.currentUser.token
                   }
               },
           });
       }
   }

   export {
       getLocalUser,
       response,
       request
   }
