import React, { useState, useEffect } from 'react';
import { viewCart, removeFromCart, placeOrder } from '../utils/api';

const Cart = () => {
  const [cart, setCart] = useState([]);

  const loadCart = () => {
    viewCart()
      .then((res) => setCart(res.data))
      .catch((err) => console.error(err));
  };

  useEffect(() => {
    loadCart();
  }, []);

  const handleRemove = (id) => {
    removeFromCart(id)
      .then(() => loadCart())
      .catch((err) => console.error(err));
  };

  const handleOrder = () => {
    placeOrder()
      .then(() => {
        alert('Order placed successfully!');
        loadCart();
      })
      .catch((err) => console.error(err));
  };

  return (
    <div style={containerStyles}>
      {cart.length === 0 ? (
        <div style={emptyCartMessage}>Your cart is empty.</div>
      ) : (
        <div style={cartListStyles}>
          {cart.map((item) => (
            <div key={item.product_id} style={cartItemStyles}>
              <div style={itemInfoStyles}>
                <span>{item.name}</span>
                <span>${item.price} (x{item.quantity})</span>
              </div>
              <button
                onClick={() => handleRemove(item.product_id)}
                style={removeBtnStyles}
              >
                Remove
              </button>
            </div>
          ))}
        </div>
      )}
      {cart.length > 0 && (
        <div style={orderSectionStyles}>
          <button style={placeOrderBtnStyles} onClick={handleOrder}>
            Place Order
          </button>
        </div>
      )}
    </div>
  );
};

const containerStyles = {
  padding: '2rem',
  fontFamily: 'Arial, sans-serif',
  maxWidth: '900px',
  margin: '0 auto',
  background: '#f9f9f9',
  borderRadius: '8px',
  boxShadow: '0 4px 6px rgba(0,0,0,0.1)',
};

const emptyCartMessage = {
  textAlign: 'center',
  fontSize: '1.5rem',
  color: '#555',
};

const cartListStyles = {
  marginBottom: '1.5rem',
};

const cartItemStyles = {
  display: 'flex',
  justifyContent: 'space-between',
  alignItems: 'center',
  padding: '1rem',
  marginBottom: '1rem',
  background: '#fff',
  borderRadius: '8px',
  boxShadow: '0 2px 4px rgba(0,0,0,0.05)',
};

const itemInfoStyles = {
  display: 'flex',
  flexDirection: 'column',
  alignItems: 'flex-start',
};

const removeBtnStyles = {
  backgroundColor: '#ff4d4d',
  color: 'white',
  border: 'none',
  padding: '0.5rem 1rem',
  fontSize: '1rem',
  cursor: 'pointer',
  borderRadius: '4px',
  transition: 'background-color 0.3s',
};

const removeBtnHoverStyles = {
  backgroundColor: '#d43f3f',
};

const placeOrderBtnStyles = {
  backgroundColor: '#00cc99',
  color: 'white',
  border: 'none',
  padding: '0.75rem 2rem',
  fontSize: '1.2rem',
  fontWeight: 'bold',
  cursor: 'pointer',
  borderRadius: '8px',
  width: '100%',
  transition: 'background-color 0.3s',
};

const orderSectionStyles = {
  display: 'flex',
  justifyContent: 'center',
};

export default Cart;
