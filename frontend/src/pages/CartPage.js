import React from 'react';
import Cart from '../components/Cart';

const CartPage = () => {
  return (
    <div>
      <h1 style={headingStyle}>Your Cart</h1>
      <Cart />
    </div>
  );
};

const headingStyle = {
  textAlign: 'center',
  margin: '2rem 0',
  color: '#333',
};

export default CartPage;
