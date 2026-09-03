import { useEffect, useState } from 'react';
import { Tabs, Table, Button, Select, Input, Space, Row, Col, Card, message } from 'antd';
import { api } from '../api.js';
const k = (c, o) => c.dataIndex;
function TableCard({ title, get, cols }) {
  const [rows, setRows] = useState([]);
  useEffect(() => { get().then(r => r.code === 0 && setRows(r.data?.data || r.data || [])); }, []);
  return <Card title={title}><Table rowKey="id" dataSource={rows} columns={cols} /></Card>;
}
export default function AgentConsole() {
  const [t, setT] = useState('start'); const [tem, setTem] = useState('muban1'); const [dom, setDom] = useState(0); const [url, setUrl] = useState('');
  const [tpl, setTpl] = useState([]); const [stat, setStat] = useState({});
  async function loadTpl() { const r = await api.agentStartTemplate(); setTpl(r.data || []); }
  async function create() { const r = await api.agentStartAdd({ useTemplate: tem, usePayTemplate: 'pay1', domain: dom, remark: '' }); if (r.code === 0) { setUrl(r.data?.url || ''); message.success('已生成推广链接'); } }
  useEffect(() => { loadTpl(); api.agentChart().then(r => r.code === 0 && setStat(r.data)); }, []);
  const cols = [{ dataIndex: 'id' }, { dataIndex: 'orderId', title: '订单号' }, { dataIndex: 'video', title: '视频' }, { dataIndex: 'price', title: '金额' }, { dataIndex: 'status', title: '状态' }];
  return <div>
    <Card>今日看板：访问 {stat.visits} · 订单 {stat.orders} · 金额 {stat.amount}</Card>
    <Tabs activeKey={t} onChange={setT} items={[
      { key: 'start', label: '推广', children: <Space direction="vertical">
        <Select value={tem} onChange={setTem} options={tpl.map(x => ({ label: x.title, value: x.model }))} style={{ width: 240 }} />
        <Button onClick={create}>生成推广链接</Button>
        {url && <Input value={url} readOnly />}
      </Space> },
      { key: 'order', label: '订单', children: <TableCard title="订单" get={api.agentOrder} cols={cols} /> },
      { key: 'tx', label: '提现', children: <Space direction="vertical">
        <Input placeholder="收款账号" id="txAccount" />
        <Input type="number" placeholder="金额" id="txPrice" />
        <Button onClick={async () => { const r = await api.agentTxAdd({ price: Number(document.getElementById('txPrice').value), account: document.getElementById('txAccount').value, payImage: '', type: 0 }); r.code === 0 ? message.success('已提交') : message.error(r.msg); }}>申请提现</Button>
        <TableCard title="提现记录" get={api.agentTxGet} cols={[{ dataIndex: 'id' }, { dataIndex: 'price', title: '金额' }, { dataIndex: 'status', title: '状态' }, { dataIndex: 'account', title: '账号' }]} />
      </Space> },
      { key: 'code', label: '卡密', children: <TableCard title="卡密" get={api.agentCode} cols={[{ dataIndex: 'id' }, { dataIndex: 'content', title: '卡密' }, { dataIndex: 'status', title: '状态' }]} /> },
      { key: 'paylog', label: '流水', children: <TableCard title="流水" get={api.agentPayLog} cols={[{ dataIndex: 'id' }, { dataIndex: 'total', title: '金额' }, { dataIndex: 'orderId', title: '订单号' }]} /> }
    ]} />
  </div>;
}
