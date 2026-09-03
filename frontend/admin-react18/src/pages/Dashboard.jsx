import { useEffect, useState } from 'react';
import { Card, Row, Col } from 'antd';
import * as echarts from 'echarts';
import { api } from '../api.js';
export default function Dashboard() {
  const [d, setD] = useState({});
  const chartRef = useEffect; // placeholder
  useEffect(() => {
    api.chart().then(r => r.code === 0 && setD(r.data));
    api.salesDay().then(r => {
      const el = document.getElementById('salesChart');
      if (!el || r.code !== 0) return;
      const chart = echarts.init(el);
      chart.setOption({ xAxis: { type: 'value' }, yAxis: { type: 'value' }, series: [{ type: 'bar', data: [r.data?.amount || 0] }] });
    });
  }, []);
  const items = [['今日访问', d.visits], ['今日订单', d.orders], ['今日金额', d.amount], ['卡密', d.kl], ['提现', d.tx]];
  return <div>
    <Row gutter={16}>{items.map(([k, v]) => <Col span={4} key={k}><Card>{k}<div style={{ fontSize: 24 }}>{v}</div></Card></Col>)}</Row>
    <Card title="今日销售" style={{ marginTop: 16 }}><div id="salesChart" style={{ height: 300 }} /></Card>
  </div>;
}
