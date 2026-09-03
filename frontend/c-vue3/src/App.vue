<template>
  <nav>
    <router-link to="/">首页</router-link> |
    <router-link to="/my">已购</router-link> |
    <router-link to="/tousu">投诉</router-link>
  </nav>
  <router-view />
</template>
<script setup>
import { onMounted } from 'vue';
import { api } from './api.js';
onMounted(async () => {
  const p = new URLSearchParams(location.search);
  const code = p.get('code');
  if (code) { const r = await api.weixinCode(code); if (r.data?.openid) localStorage.setItem('openid', r.data.openid); }
});
</script>
