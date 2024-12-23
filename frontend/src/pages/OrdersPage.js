import React from 'react';
import Orders from '../components/Orders';

const OrdersPage = () => {
  return (
    <div>
      <h1 style={headingStyle}>Your Orders</h1>
      <Orders />
    </div>
  );
};

const headingStyle = {
  textAlign: 'center',
  margin: '2rem 0',
  color: '#333',
};

export default OrdersPage;
