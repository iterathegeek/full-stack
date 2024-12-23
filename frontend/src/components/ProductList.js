import React, { useState, useEffect } from 'react';
import { fetchProducts } from '../utils/api';
import ProductCard from './ProductCard';

const ProductList = () => {
  const [products, setProducts] = useState([]);

  useEffect(() => {
    fetchProducts()
      .then((res) => setProducts(res.data))
      .catch((err) => console.error(err));
  }, []);

  return (
    <div style={listStyles}>
      {products.map((product) => (
        <ProductCard key={product.id} product={product} />
      ))}
    </div>
  );
};

const listStyles = {
  display: 'flex',
  flexWrap: 'wrap',
  gap: '2rem',
  justifyContent: 'center',
  padding: '2rem',
};

export default ProductList;
