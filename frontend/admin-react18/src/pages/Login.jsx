import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { Input, Button, message } from 'antd';
import { api } from '../api.js';
export default function Login() {
  const [user, setUser] = useState('admin'); const [pwd, setPwd] = useState('admin');
  const nav = useNavigate();
  async function go() { const r = await api.login(user, pwd); if (r.code === 0) { localStorage.setItem('token', r.data.token); nav('/'); } else message.error(r.msg); }
  return <div style={{ maxWidth: 320, margin: '20vh auto' }}>
    <Input placeholder="账号" value={user} onChange={e => setUser(e.target.value)} />
    <Input.Password placeholder="密码" value={pwd} onChange={e => setPwd(e.target.value)} />
    <Button type="primary" block onClick={go} style={{ marginTop: 12 }}>登录</Button>
  </div>;
}
