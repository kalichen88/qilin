import axios from 'axios';
const http = axios.create({ baseURL: '/' });
http.interceptors.response.use(r => r.data, e => Promise.reject(e));
/** C 端统一带上下文 */
const ctx = { fingerprint: localStorage.getItem('fingerprint') || '' , xvzf: localStorage.getItem('xvzf') || '', t: localStorage.getItem('t') || '' };
export const api = {
  banner: (extra = {}) => http.post('/view/video/banner', { ...ctx, ...extra }),
  getInfo: (id) => http.post('/view/video/getInfo', { id, ...ctx }),
  search: (keyword) => http.post('/view/video/search', { keyword, ...ctx }),
  getUrl: (id) => http.post('/view/video/getUrl', { id, ...ctx }),
  getMy: () => http.post('/view/video/getMyVideo', { ...ctx }),
  categories: () => http.post('/view/category/get', { ...ctx }),
  categoryVideos: (id) => http.post('/view/category/getAll', { id, page: 1, ...ctx }),
  checkout: (p) => http.post('/view/pay/checkout', p),
  checkOrder: (orderId) => http.get('/view/pay/checkOrder', { params: { orderId } }),
  notify: (orderId) => http.post('/view/pay/notify', { orderId }),
  weixinCode: (code) => http.get('/weixinCodeHandler', { params: { code } }),
  payList: () => http.post('/view/pay/getList', { ...ctx }),
  tousu: (p) => http.post('/view/tousu/add', { ...ctx, ...p })
};
