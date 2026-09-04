import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { Input, Button, message } from 'antd';
import { api } from '../api.js';
export default function Login({ onLogin }) {
  const [user, setUser] = useState('admin'); const [pwd, setPwd] = useState('admin');
  const [loading, setLoading] = useState(false);
  const nav = useNavigate();
  async function go() {
    setLoading(true);
    try {
      const r = await api.login(user, pwd);
      if (r.code === 0) {
        sessionStorage.setItem('token', r.data.token);
        const ok = await onLogin();   // 用刚拿到的 token 校验会话
        if (ok) nav('/', { replace: true });
        else message.error('登录状态校验失败，请重试');
      } else message.error(r.msg);
    } catch { message.error('网络错误，请重试'); }
    setLoading(false);
  }
  return <div style={{ maxWidth: 320, margin: '20vh auto' }}>
    <Input placeholder="账号" value={user} onChange={e => setUser(e.target.value)} style={{ marginBottom: 12 }} />
    <Input.Password placeholder="密码" value={pwd} onChange={e => setPwd(e.target.value)} style={{ marginBottom: 12 }} />
    <Button type="primary" block loading={loading} onClick={go}>登录</Button>
  </div>;
}
