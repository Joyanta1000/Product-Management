import { createRouter, createWebHistory } from 'vue-router'
import CategoryComponent from './components/Category/CategoryComponent.vue'
import ProductComponent from './components/Product/ProductComponent.vue'
import CategoryEdit from './components/Category/CategoryEdit.vue'
import ProductEdit from './components/Product/ProductEdit.vue'

const routes = [
  { path: '/', name: 'CategoryInfo', component: CategoryComponent },
  { path: '/products', name: 'ProductInfo', component: ProductComponent },
  {
    path: '/categories/edit/:categoryId',
    name: 'CategoryEdit',
    component: CategoryEdit,
    props: route => ({ categoryId: Number(route.params.categoryId) }), 
  },
  {
    path: '/products/edit/:productId',
    name: 'ProductEdit',
    component: ProductEdit,
    props: route => ({ productId: Number(route.params.productId) }), 
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  // routes: [
  //   // your routes go here
  // ]
  routes
})

export default router