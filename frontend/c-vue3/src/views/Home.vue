<script setup>
import { ref, onMounted } from 'vue';
import { api } from '../api.js';
const videos = ref([]);
const kw = ref('');
const cats = ref([]);
const curCat = ref(0);
async function load() { const r = await api.banner(); videos.value = (r.data || []).slice(0, 12); }
async function search() { const r = await api.search(kw.value); videos.value = r.data?.data || []; }
async function pickCat(id) { curCat.value = id; const r = await api.categoryVideos(id); videos.value = r.data?.data || []; }
onMounted(async () => { await load(); const c = await api.categories(); cats.value = c.data || []; });
</script>
<template>
  <h2>万利云赏 · 在线影片</h2>
  <input v-model="kw" placeholder="输入搜索关键词" @keyup.enter="search" />
  <button @click="search">搜索</button>
  <div class="grid">
    <div v-for="v in videos" :key="v.id" class="card" @click="$router.push('/video/' + v.id)">
      <img :src="v.thumb" />
      <p>{{ v.title }}</p>
    </div>
  </div>
  <div class="cats"><button v-for="c in cats" :key="c.id" @click="pickCat(c.id)">{{ c.name }}</button></div>
</template>
<style scoped>
.grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(150px,1fr)); gap:12px; }
.card img { width:100%; height:90px; object-fit:cover; }
</style>
