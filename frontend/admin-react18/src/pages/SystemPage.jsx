import { useEffect, useState } from 'react';
import { Form, Input, InputNumber, Button, Card, Row, Col, message } from 'antd';
import { api } from '../api.js';
const fields = [
  ['siteName', '站点名称', 'text'], ['siteTitle', '网站标题', 'text'], ['siteInfo', '网站描述', 'textarea'],
  ['siteLogo', '网站Logo', 'text'], ['siteBg', '登录背景', 'text'], ['bindDomain', '绑定域名', 'text'],
  ['min_price', '最低打赏', 'number'], ['max_price', '最高打赏', 'number'],
  ['global_txfl', '默认提现费率', 'number'], ['global_fyfl', '默认返佣费率', 'number'],
  ['codePrice', '邀请码价格', 'number'], ['domainPrice', '域名价格', 'number'],
  ['switch_pc', '禁止PC打开', 'number'], ['ffSwitch', '防封开关', 'number'], ['wechatUrl', '防封链接', 'text'],
  ['appid', '微信公众号appid', 'text'], ['secret', '微信公众号secret', 'text']
];
export default function SystemPage() {
  const [v, setV] = useState({});
  useEffect(() => { api.system().then(r => r.code === 0 && setV(r.data || {})); }, []);
  async function save() { const r = await api.saveSystem(v); r.code === 0 ? message.success('已保存') : message.error(r.msg); }
  return <Card title="系统配置">
    <Row gutter={16}>
      {fields.map(([k, label, t]) => (
        <Col span={8} key={k}><Form.Item label={label}>
          {t === 'number'
            ? <InputNumber style={{ width: '100%' }} value={v[k]} onChange={x => setV({ ...v, [k]: x })} />
            : <Input.TextArea rows={t === 'textarea' ? 2 : 1} value={v[k]} onChange={e => setV({ ...v, [k]: e.target.value })} />}
        </Form.Item></Col>
      ))}
    </Row>
    <Button type="primary" onClick={save}>保存</Button>
  </Card>;
}
