import axios from 'axios';

const API = axios.create({
  baseURL: 'http://localhost:8000/api', // Update with your backend URL
});

export const fetchProducts = () => API.get('/products');
export const addToCart = (data) => API.post('/cart/add', data);
export const removeFromCart = (productId) => API.delete(`/cart/remove/${productId}`);
export const viewCart = () => API.get('/cart');
export const placeOrder = () => API.post('/orders/place');
export const fetchOrders = () => API.get('/orders');

export default API;
