import axios from 'axios';
import { apiBaseUrl } from '@/apiService';

const fetchCategories = async (page = 1, perPage = 10) => {
  try {
    const response = await axios.get(`${apiBaseUrl}categories`, {
      params: { page, per_page: perPage }
    });
    return response.data.data;
  } catch (error) {
    console.error(`Error fetching categories:`, error);
    throw error;
  }
};

const addCategory = async (data) => {
  try {
    const response = await axios.post(`${apiBaseUrl}categories`, data);
    return response.data.data;
  } catch (error) {
    console.error('Error adding category:', error);
    throw error;
  }
};

const deleteCategory = async (categoryId) => {
  try {
    await axios.delete(`${apiBaseUrl}categories/${categoryId}`);
  } catch (error) {
    console.error('Error deleting category:', error);
    throw error;
  }
};

const editCategory = async (categoryId) => {
  try {
    const response = await axios.get(`${apiBaseUrl}categories/${categoryId}`);
    return response.data.data;
  } catch (error) {
    console.error('Error deleting category:', error);
    throw error;
  }
};

const updateCategory = async (data) => {
  try {
    const response = await axios.put(`${apiBaseUrl}categories/${data.id}`, data);
    return response.data.data;
  } catch (error) {
    console.error('Error adding category:', error);
    throw error;
  }
};

export default {
  fetchCategories,
  addCategory,
  deleteCategory,
  editCategory,
  updateCategory
};
