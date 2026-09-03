<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { api } from '../api.js';
const rows = ref([]);
const router = useRouter();
onMounted(async () => { const r = await api.getMy(); rows.value = r.data || []; });
</script>
<template>
  <h3>已购视频</h3>
  <div v-for="h in rows" :key="h.id" class="item" @click="router.push('/video/' + h.video)">
    <div>视频 #{{ h.video }} · 类型 {{ h.type }} · 到期 {{ new Date(h.expireTime * 1000).toLocaleDateString() }}</div>
  </div>
</template>
