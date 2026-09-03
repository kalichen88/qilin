<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useRoute } from 'vue-router';
import { api } from '../api.js';
const props = defineProps({ mode: { type: String, default: 'h5' } });
const route = useRoute();
const orderId = ref(route.query.orderId || '');
const status = ref('等待支付');
const paid = ref(false);
let timer;
async function poll() {
  try { const r = await api.checkOrder(orderId.value); if (r.data?.paid) { paid.value = true; status.value = '支付成功'; clearInterval(timer); } }
  catch (e) { /* ignore */ }
}
onMounted(() => { timer = setInterval(poll, 2000); poll(); });
onUnmounted(() => clearInterval(timer));
</script>
<template>
  <div class="pay">
    <h3>{{ mode === 'qrcode' ? '扫码支付' : 'H5 支付' }}</h3>
    <p>订单号：{{ orderId }}</p>
    <div v-if="mode === 'qrcode'" class="qr">二维码区（真实通道接入后展示收款码）</div>
    <button v-else @click="api.notify(orderId)">我已支付</button>
    <p :class="{ ok: paid }">{{ status }}</p>
    <router-link v-if="paid" to="/">返回首页</router-link>
  </div>
</template>
<style scoped>
.pay { max-width: 360px; margin: 40px auto; text-align: center; }
.qr { width: 180px; height: 180px; border: 1px dashed #999; margin: 16px auto; line-height: 180px; color: #999; }
.ok { color: #09bb07; }
</style>
