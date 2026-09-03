<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { api } from '../api.js';
const route = useRoute();
const info = ref({});
const playUrl = ref('');
const payStatus = ref('');
const payModels = ref([]);
const payModel = ref('');
async function load() { info.value = (await api.getInfo(route.params.id)).data; const p = await api.payList(); payModels.value = p.data || []; if (payModels.value.length) payModel.value = payModels.value[0].model; }
async function buy(type) {
  const r = await api.checkout({ videoId: Number(route.params.id), type, price: 1, payModel: payModel.value, fingerprint: localStorage.getItem('fingerprint') || 'demo', xvzf: localStorage.getItem('xvzf') || '', t: localStorage.getItem('t') || '' });
  const oid = r.data?.orderId;
  // 进入支付落地页( /qrcode 或 /h5 )，由 Pay.vue 负责轮询
  if (r.data?.type === 'form') { const url = `/qrcode?orderId=${oid}`; window.location.href = url; }
}
async function play() { playUrl.value = (await api.getUrl(route.params.id)).data?.url || ''; }
onMounted(load);
</script>
<template>
  <h3>{{ info.video?.title }}</h3>
  <img :src="info.video?.thumb" style="width:200px" />
  <p>已购：{{ info.purchased ? '是' : '否' }}</p>
  <button @click="buy(1)">单片购买</button>
  <button @click="buy(2)">包天</button>
  <button @click="buy(3)">包周</button>
  <button @click="buy(4)">包月</button>
  <button @click="play">播放</button>
  <select v-model="payModel"><option v-for="m in payModels" :value="m.model" :key="m.model">{{ m.name }}({{ m.viewName }})</option></select>
  <video v-if="playUrl" :src="playUrl" controls style="width:100%"></video>
</template>
