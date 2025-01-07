import axios from 'axios';
import { apiBaseUrl } from '@/apiService';

const getCategories = async () => {
  try {
    const response = await axios.get(`${apiBaseUrl}categories_product_add`);
    return response.data.data;
  } catch (error) {
    console.error(`Error fetching categories:`, error);
    throw error;
  }
};

const getProducts = async (page = 1, perPage = 10) => {
  try {
    const response = await axios.get(`${apiBaseUrl}products`, {
      params: { page, per_page: perPage }
    });
    return response.data.data;
  } catch (error) {
    console.error(`Error fetching products:`, error);
    throw error;
  }
};

const addProduct = async (data) => {
  try {
    const response = await axios.post(`${apiBaseUrl}products`, data);
    return response.data.data;
  } catch (error) {
    console.error('Error adding product:', error);
    throw error;
  }
};

const deleteProduct = async (productId) => {
  try {
    await axios.delete(`${apiBaseUrl}products/${productId}`);
  } catch (error) {
    console.error('Error deleting product:', error);
    throw error;
  }
};

const editProduct = async (productId) => {
  try {
    const response = await axios.get(`${apiBaseUrl}products/${productId}`);
    return response.data.data;
  } catch (error) {
    console.error('Error deleting category:', error);
    throw error;
  }
};

const updateProduct = async (id, data) => {

  for (let [key, value] of data.entries()) {
    console.log(`${key}:`, value);
  }

  try {
    const response = await axios.post(`${apiBaseUrl}products/update/${id}`, data);
    return response.data.data;
  } catch (error) {
    console.error("Error updating product:", error);

    if (error.response) {
      console.error("Response Data:", error.response.data);
    }
    throw error;
  }
};



export default {
  getCategories,
  getProducts,
  addProduct,
  deleteProduct,
  editProduct,
  updateProduct
};
