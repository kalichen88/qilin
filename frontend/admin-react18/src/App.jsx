import { useState, useEffect } from 'react';
import { Routes, Route, Navigate, useNavigate, Link } from 'react-router-dom';
import { Layout, Menu, Button, Spin } from 'antd';
import Login from './pages/Login.jsx';
import Dashboard from './pages/Dashboard.jsx';
import VideoList from './pages/VideoList.jsx';
import AgentList from './pages/AgentList.jsx';
import CrudPage from './pages/CrudPage.jsx';
import SystemPage from './pages/SystemPage.jsx';
import TxReview from './pages/TxReview.jsx';
import AgentConsole from './pages/AgentConsole.jsx';
import { modules } from './modules.js';
import { api } from './api.js';

function Shell({ children, onLogout }) {
  const nav = useNavigate();
  return (
    <Layout style={{ minHeight: '100vh' }}>
      <Layout.Sider theme="light">
        <Menu items={[
          { key: '/', label: <Link to="/">看板</Link> },
          { key: '/videos', label: <Link to="/videos">视频</Link> },
          { key: '/agents', label: <Link to="/agents">代理</Link> },
          { key: '/agent', label: <Link to="/agent">代理中心</Link> },
          { key: '/system', label: <Link to="/system">系统</Link> },
          { key: '/txReview', label: <Link to="/txReview">提现审核</Link> }
        ]} />
      </Layout.Sider>
      <Layout>
        <Layout.Header style={{ background:'#fff', display:'flex', justifyContent:'flex-end', alignItems:'center', padding:'0 24px' }}>
          <Button onClick={() => { onLogout(); nav('/login', { replace: true }); }}>退出登录</Button>
        </Layout.Header>
        <Layout.Content style={{ padding: 24 }}>{children}</Layout.Content>
      </Layout>
    </Layout>
  );
}

export default function App() {
  const [checking, setChecking] = useState(true);   // 是否正在校验 token
  const [authed, setAuthed] = useState(false);      // 是否为有效管理员会话

  const refresh = async () => {
    const token = sessionStorage.getItem('token');
    if (!token) { setAuthed(false); return false; }
    try {
      const r = await api.auth();
      const ok = !!r && r.code === 0;
      if (!ok) sessionStorage.removeItem('token');
      setAuthed(ok);
      return ok;
    } catch {
      sessionStorage.removeItem('token');
      setAuthed(false);
      return false;
    }
  };

  useEffect(() => {
    refresh().finally(() => setChecking(false));
  }, []);

  const logout = () => { sessionStorage.removeItem('token'); setAuthed(false); };

  if (checking) {
    return <div style={{ height: '100vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}><Spin size="large" /></div>;
  }

  return (
    <Routes>
      <Route path="/login" element={<Login onLogin={refresh} />} />
      {authed ? (
        <Route element={<Shell onLogout={logout} />}>
          <Route path="/" element={<Dashboard />} />
          <Route path="/videos" element={<VideoList />} />
          <Route path="/agents" element={<AgentList />} />
          <Route path="/system" element={<SystemPage />} />
          <Route path="/txReview" element={<TxReview />} />
          <Route path="/agent" element={<AgentConsole />} />
          {modules.map(m => <Route key={m.key} path={m.key} element={<CrudPage config={m} />} />)}
        </Route>
      ) : <Route path="*" element={<Navigate to="/login" replace />} />}
    </Routes>
  );
}
