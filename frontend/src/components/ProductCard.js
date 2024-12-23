import React from 'react';
import { addToCart } from '../utils/api';

const ProductCard = ({ product }) => {
  const handleAddToCart = () => {
    addToCart({ product_id: product.id, quantity: 1 })
      .then(() => alert(`${product.name} added to cart!`))
      .catch((err) => console.error(err));
  };

  return (
    <div style={cardStyles}>
      <h3>{product.name}</h3>
      <p>{product.description}</p>
      <p style={{ fontWeight: 'bold' }}>${product.price}</p>
      <button style={btnStyles} onClick={handleAddToCart}>
        Add to Cart
      </button>
    </div>
  );
};

const cardStyles = {
  border: '1px solid #ccc',
  borderRadius: '8px',
  padding: '1rem',
  width: '250px',
  boxShadow: '0 4px 8px rgba(0, 0, 0, 0.1)',
  textAlign: 'center',
};

const btnStyles = {
  padding: '0.5rem 1rem',
  background: '#4CAF50',
  border: 'none',
  color: 'white',
  cursor: 'pointer',
};

export default ProductCard;
