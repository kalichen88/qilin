import { useEffect, useState } from 'react';
import { Table, Button, Input, Space } from 'antd';
import { api } from '../api.js';
export default function VideoList() {
  const [rows, setRows] = useState([]); const [title, setTitle] = useState(''); const [url, setUrl] = useState('');
  async function refresh() { const r = await api.videos(); setRows(r.data?.list || []); }
  async function add() { await api.addVideo({ title, videoUrl: url, thumb: '' }); setTitle(''); setUrl(''); refresh(); }
  useEffect(() => { refresh(); }, []);
  const cols = [{ title: 'ID', dataIndex: 'id' }, { title: '标题', dataIndex: 'title' }, { title: '地址', dataIndex: 'videoUrl' }];
  return <Space direction="vertical" style={{ width: '100%' }}>
    <Space><Input placeholder="标题" value={title} onChange={e => setTitle(e.target.value)} /><Input placeholder="视频地址" value={url} onChange={e => setUrl(e.target.value)} /><Button onClick={add}>新增</Button></Space>
    <Table rowKey="id" dataSource={rows} columns={cols} />
  </Space>;
}
