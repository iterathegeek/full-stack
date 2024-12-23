import React from 'react';
import ProductList from '../components/ProductList';

const Home = () => {
  return (
    <div>
      <h1 style={headingStyle}>Welcome to Modern Store</h1>
      <ProductList />
    </div>
  );
};

const headingStyle = {
  textAlign: 'center',
  margin: '2rem 0',
  color: '#333',
};

export default Home;
