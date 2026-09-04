import { createRouter, createWebHashHistory } from 'vue-router';
import Home from './views/Home.vue';
import Detail from './views/Detail.vue';
import Tousu from './views/Tousu.vue';
import MyVideos from './views/MyVideos.vue';
import Pay from './views/Pay.vue';
export default createRouter({
  history: createWebHashHistory(),
  routes: [
    { path: '/', component: Home },
    { path: '/video/:id', component: Detail },
    { path: '/my', component: MyVideos },
    { path: '/qrcode', component: Pay, props: { mode: 'qrcode' } },
    { path: '/h5', component: Pay, props: { mode: 'h5' } },
    { path: '/tousu', component: Tousu }
  ]
});
