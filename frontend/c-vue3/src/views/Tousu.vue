<script setup>
import { ref } from 'vue';
import { api } from '../api.js';
const content = ref('');
const msg = ref('');
async function submit() { const r = await api.tousu({ type: 1, content: content.value }); msg.value = r.msg; }
</script>
<template>
  <h3>投诉</h3>
  <textarea v-model="content"></textarea>
  <button @click="submit">提交</button>
  <p>{{ msg }}</p>
</template>
