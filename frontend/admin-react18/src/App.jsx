import { Routes, Route, Navigate, useNavigate, Link } from 'react-router-dom';
import { Layout, Menu, Button } from 'antd';
import Login from './pages/Login.jsx';
import Dashboard from './pages/Dashboard.jsx';
import VideoList from './pages/VideoList.jsx';
import AgentList from './pages/AgentList.jsx';
import CrudPage from './pages/CrudPage.jsx';
import SystemPage from './pages/SystemPage.jsx';
import TxReview from './pages/TxReview.jsx';
import AgentConsole from './pages/AgentConsole.jsx';
import { modules } from './modules.js';
function Shell({ children }) {
  const nav = useNavigate();
  return (
    <Layout style={{ minHeight: '100vh' }}>
      <Layout.Sider theme="light">
        <Menu items={[
          { key: '/', label: <Link to="/">看板</Link> },
          { key: '/videos', label: <Link to="/videos">视频</Link> },
          { key: '/agents', label: <Link to="/agents">代理</Link> }
          ,{ key: '/agent', label: <Link to="/agent">代理中心</Link> }, { key: '/system', label: <Link to="/system">系统</Link> }, { key: '/txReview', label: <Link to="/txReview">提现审核</Link> }
        ]} />
      </Layout.Sider>
      <Layout.Content style={{ padding: 24 }}>{children}</Layout.Content>
    </Layout>
  );
}
export default function App() {
  const token = localStorage.getItem('token');
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      {token ? (
        <Route element={<Shell />}>
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
