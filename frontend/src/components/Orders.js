import React, { useState, useEffect } from 'react';
import { fetchOrders } from '../utils/api';

const Orders = () => {
  const [orders, setOrders] = useState([]);

  const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('en-US', options);
  };

  useEffect(() => {
    fetchOrders()
      .then((res) => setOrders(res.data))
      .catch((err) => console.error(err));
  }, []);

  return (
    <div style={containerStyle}>
      <h2 style={titleStyle}>Your Orders</h2>
      {orders.length === 0 ? (
        <p style={emptyMessageStyle}>No orders yet. Start shopping to see your orders here!</p>
      ) : (
        <div style={gridStyle}>
          {orders.map((order) => (
            <div key={order.id} style={orderCardStyle}>
              <h3 style={orderTitleStyle}>Order #{order.id}</h3>
              <p style={detailStyle}>
                <strong>Status:</strong> {order.status}
              </p>
              <p style={detailStyle}>
                <strong>Items:</strong> {order.items?.length || 0}
              </p>
              <p style={detailStyle}>
                <strong>Total:</strong> ${Number(order.total_price).toFixed(2)}
              </p>
              <p style={detailStyle}>
                <strong>Date:</strong> {formatDate(order.created_at)}
              </p>
              <p style={detailStyle}>
                <strong>User ID:</strong> {order.user_id}
              </p>
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

const containerStyle = {
  padding: '2rem',
  maxWidth: '800px',
  margin: '0 auto',
  fontFamily: 'Arial, sans-serif',
};

const titleStyle = {
  textAlign: 'center',
  marginBottom: '1rem',
  color: '#333',
};

const emptyMessageStyle = {
  textAlign: 'center',
  fontSize: '1.1rem',
  color: '#666',
};

const gridStyle = {
  display: 'grid',
  gap: '1rem',
  gridTemplateColumns: 'repeat(auto-fit, minmax(250px, 1fr))',
};

const orderCardStyle = {
  border: '1px solid #ddd',
  borderRadius: '8px',
  padding: '1rem',
  boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
  backgroundColor: '#f9f9f9',
};

const orderTitleStyle = {
  marginBottom: '0.5rem',
  color: '#007bff',
};

const detailStyle = {
  margin: '0.25rem 0',
  color: '#555',
};

export default Orders;
