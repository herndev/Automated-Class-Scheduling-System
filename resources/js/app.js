// import './bootstrap';

import Alpine from 'alpinejs';
import axios from 'axios';
// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// import { getAnalytics } from "firebase/analytics";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

window.Echo.channel('notify-channel')
    .listen('NewPostAdded', (e) => {
        console.log('test');
        const audio = new Audio('assets/alarm.mp3');
        // console.log(e);
        // audio.play();
        // const audio = document.getElementById('alertAudio');
        audio.play();
    });
window.Echo.channel('silent-notification')
    .listen('NewPost', (e) => {
        console.log('test');
    });


// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyCYxHTd4H5yAuZ3K6_MT1DuJ9XvDVhNTQs",
    authDomain: "firease-82ab9.firebaseapp.com",
    projectId: "firease-82ab9",
    storageBucket: "firease-82ab9.appspot.com",
    messagingSenderId: "296543121796",
    appId: "1:296543121796:web:c1eacf75bf4f3cb601edd1",
    measurementId: "G-VW5M7ZD2TQ"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);
getToken(messaging, { vapidKey: 'BE5g0DI1w4XPvn-Iwx8M860KZshjO3FN5j4JmJXzIXUv8Sw8V713MpnUDTYr2BLTvFH9YbzD3duX_yz-hGaxJx4' }).then((currentToken) => {
    if (currentToken) {
        // Send the token to your server and update the UI if necessary
        // ...
        // console.log(currentToken);
        axios.post('/token/' + currentToken).then((e) => {
            console.info(e.data.message);
        });
    } else {
        // Show permission request UI
        console.log('No registration token available. Request permission to generate one.');
        // ...
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // ...
});

onMessage(messaging, (payload) => {
    console.log('Message received. ', payload.notification.body);
    // ...
    // var audio = document.createElement("AUDIO")
    // document.body.appendChild(audio);
    // audio.src = "assets/alarm.mp3"
    // payload.notification.body == 'Post' ? alertAudio.play() : payload.notification.body == 'Update' ? alertFire.play() : '';
    if(payload.notification.body == 'Post'){
        alertAudio.play();
        alert(payload.notification.title);
    }else if(payload.notification.body == 'Update'){
        alertFire.play();
        alert(payload.notification.title);
    }else{
        alert(payload.notification.title);
    }
});

window.Alpine = Alpine;

Alpine.start();
