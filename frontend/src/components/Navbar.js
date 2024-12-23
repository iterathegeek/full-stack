import React from 'react';
import { Link } from 'react-router-dom';
import { FaShoppingCart, FaHome, FaClipboardList } from 'react-icons/fa';

const Navbar = () => (
  <nav style={navStyles}>
    <h2 style={{ color: '#4CAF50' }}>Modern Store</h2>
    <div>
      <Link to="/" style={linkStyles}><FaHome /> Home</Link>
      <Link to="/cart" style={linkStyles}><FaShoppingCart /> Cart</Link>
      <Link to="/orders" style={linkStyles}><FaClipboardList /> Orders</Link>
    </div>
  </nav>
);

const navStyles = {
  display: 'flex',
  justifyContent: 'space-between',
  padding: '1rem 2rem',
  background: '#282c34',
  color: 'white',
};

const linkStyles = {
  margin: '0 1rem',
  textDecoration: 'none',
  color: 'white',
};

export default Navbar;
