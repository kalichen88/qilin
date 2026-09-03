import { useEffect, useState } from 'react';
import { Table } from 'antd';
import { api } from '../api.js';
export default function AgentList() {
  const [rows, setRows] = useState([]);
  useEffect(() => { api.agents().then(r => r.code === 0 && setRows(r.data?.list || [])); }, []);
  const cols = [{ title: 'ID', dataIndex: 'id' }, { title: '账号', dataIndex: 'user' }, { title: '名称', dataIndex: 'name' }, { title: '余额', dataIndex: 'money' }];
  return <Table rowKey="id" dataSource={rows} columns={cols} />;
}
