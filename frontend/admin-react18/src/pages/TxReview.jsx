import { useEffect, useState } from 'react';
import { Table, Button, Space, Modal, Input, message, Radio } from 'antd';
import { api } from '../api.js';
export default function TxReview() {
  const [rows, setRows] = useState([]);
  const [status, setStatus] = useState(0);
  const [curr, setCurr] = useState(null);
  async function load() { const r = await api.tixian(status); setRows(r.data?.data || []); }
  useEffect(() => { load(); }, [status]);
  async function pass(id) { await api.tixianPass(id); message.success('已通过'); load(); }
  function reject(row) { Modal.confirm({ title: '驳回原因', content: <Input.TextArea id="rj" />, onOk: () => api.tixianReject(row.id, document.getElementById('rj').value).then(() => { message.success('已驳回'); load(); }) }); }
  const cols = [{ dataIndex: 'id' }, { dataIndex: 'agent', title: '代理' }, { dataIndex: 'price', title: '金额' }, { dataIndex: 'account', title: '账号' },
    { title: '操作', render: (_, row) => <Space><Button size="small" onClick={() => pass(row.id)}>通过</Button><Button size="small" danger onClick={() => reject(row)}>驳回</Button></Space> }];
  return <div><Space style={{ marginBottom: 12 }}><Radio.Group value={status} onChange={e => setStatus(e.target.value)}>
    <Radio.Button value={0}>待审</Radio.Button><Radio.Button value={1}>已通过</Radio.Button><Radio.Button value={2}>已驳回</Radio.Button></Radio.Group></Space>
    <Table rowKey="id" dataSource={rows} columns={cols} /></div>;
}
