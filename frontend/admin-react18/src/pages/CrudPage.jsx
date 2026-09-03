import { useEffect, useState } from 'react';
import { Table, Button, Space, Modal, Form, Input, InputNumber, message, Popconfirm } from 'antd';
import { api } from '../api.js';

/**
 * 通用 CRUD 页：一份代码覆盖所有管理模块。
 * config: { base, title, columns:[{dataIndex,title,render?}], fields:[{name,label,type?}] }
 */
export default function CrudPage({ config }) {
  const [rows, setRows] = useState([]);
  const [open, setOpen] = useState(false);
  const [edit, setEdit] = useState(null);
  const [form, setForm] = useState({});
  async function load() { const r = await api.list(config.base); setRows(r.data?.list || []); }
  useEffect(() => { load(); }, [config.base]);
  function openAdd() { setEdit(null); setForm({}); setOpen(true); }
  function openEdit(row) { setEdit(row); setForm(row); setOpen(true); }
  async function submit() {
    const r = edit ? await api.save(config.base, { id: edit.id, ...form }) : await api.add(config.base, form);
    if (r.code === 0) { message.success('已保存'); setOpen(false); load(); } else message.error(r.msg);
  }
  async function remove(id) { const r = await api.del(config.base, id); r.code === 0 && load(); }
  const cols = [...config.columns, { title: '操作', render: (_, row) => (
    <Space><a onClick={() => openEdit(row)}>编辑</a><Popconfirm onConfirm={() => remove(row.id)} title="确认删除?"><a>删除</a></Popconfirm></Space> ) }];
  return <div>
    <Space style={{ marginBottom: 12 }}><Button type="primary" onClick={openAdd}>新增</Button></Space>
    <Table rowKey="id" dataSource={rows} columns={cols} />
    <Modal open={open} title={edit ? '编辑' : '新增'} onOk={submit} onCancel={() => setOpen(false)}>
      <Form layout="vertical">
        {config.fields.map(f => (
          <Form.Item label={f.label} key={f.name}>
            {f.type === 'number'
              ? <InputNumber style={{ width: '100%' }} value={form[f.name]} onChange={v => setForm({ ...form, [f.name]: v })} />
              : f.textarea
                ? <Input.TextArea rows={3} value={form[f.name]} onChange={e => setForm({ ...form, [f.name]: e.target.value })} />
                : <Input value={form[f.name]} onChange={e => setForm({ ...form, [f.name]: e.target.value })} />}
          </Form.Item>
        ))}
      </Form>
    </Modal>
  </div>;
}
