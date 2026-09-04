import axios from 'axios';
const http = axios.create({ baseURL: '/' });
http.interceptors.request.use(c => { const t = sessionStorage.getItem('token'); if (t) c.headers.Authorization = 'Bearer ' + t; return c; });
http.interceptors.response.use(r => r.data, e => Promise.reject(e));
export const api = {
  login: (user, password) => http.post('/common/login', { user, password }),
  auth: () => http.get('/common/auth'),
  chart: () => http.get('/api/adminChart/getNowData'),
  salesDay: () => http.get('/api/adminChart/getSalesDay'),
  list: (base, params = {}) => http.get(base + '/get', { params: { page: 1, limit: 20, ...params } }),
  rows: (base) => http.get(base + '/getall'),
  one: (base, id) => http.get(base + '/get/single', { params: { id } }),
  add: (base, v) => http.post(base + '/add', v),
  save: (base, v) => http.post(base + '/save', v),
  del: (base, id) => http.post(base + '/delete', { id }),
  dels: (base, ids) => http.post(base + '/deletes', { ids }),
  videos: (page = 1) => http.get('/api/video/get', { params: { page, limit: 10 } }),
  addVideo: (v) => http.post('/api/video/add', v),
  agents: (page = 1) => http.get('/api/agent/get', { params: { page, limit: 10 } })
  ,
  system: () => http.get('/api/system/get/single'),
  saveSystem: (v) => http.post('/api/system/save', v),
  tixian: (status) => http.get('/api/tixian/get', { params: { status } }),
  tixianPass: (id) => http.get('/api/tixian/pass', { params: { id } }),
  tixianReject: (id, content) => http.post('/api/tixian/reject', { id, rejectContent: content }),
  agentStart: () => http.get('/api/agentStart/get'),
  agentStartConfig: () => http.get('/api/agentStart/getConfig'),
  agentStartAdd: (p) => http.post('/api/agentStart/add', p),
  agentStartTemplate: () => http.get('/api/agentStart/getTemplate'),
  agentStartShort: () => http.get('/api/agentStart/getShort'),
  agentStartBox: () => http.get('/api/agentStart/getBox'),
  agentOrder: () => http.get('/api/agentOrder/get'),
  agentTxGet: () => http.get('/api/agentTx/get'),
  agentTxAdd: (p) => http.post('/api/agentTx/add', p),
  agentCode: () => http.get('/api/agentCode/get'),
  agentCodeAdd: (p) => http.post('/api/agentCode/add', p),
  agentChart: () => http.get('/api/agentChart/getNowData'),
  agentPayLog: () => http.get('/api/agentPayLog/get')
};
