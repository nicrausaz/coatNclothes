import Home from '@/components/views/home'
import Categories from '@/components/views/categories'
import WishLists from '@/components/views/wishlists'
import Shopbag from '@/components/views/shopbag'
import checkLogin from '@/components/views/checkLogin'
import product from '@/components/views/product'
import orders from '@/components/views/orders'
import orderconfirm from '@/components/views/orderconfirm'

import admin from '@/components/views/admin/admin'
import adminProducts from '@/components/shared/admin/products/productsTable'
import adminDashboard from '@/components/shared/admin/dashboard'
import adminUsers from '@/components/shared/admin/users/usersTable'
import adminOrders from '@/components/shared/admin/orders/ordersTable'
import adminCategories from '@/components/shared/admin/categories/categoriesView'

import NotFound from '@/components/views/404'

export default {
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/category/:id',
      name: 'Category',
      component: Categories
    },
    {
      path: '/wishlists',
      name: 'Wishlists',
      component: WishLists
    },
    {
      path: '/shopbag',
      name: 'Shopbag',
      component: Shopbag
    },
    {
      path: '/user',
      name: 'User',
      component: checkLogin
    },
    {
      path: '/product/:id',
      name: 'product',
      component: product
    },
    {
      path: '/orders',
      name: 'orders',
      component: orders
    },
    {
      path: '/order/:id',
      name: 'order',
      component: orders
    },
    {
      path: '/orderconfirm',
      name: 'orderconfirm',
      component: orderconfirm
    },
    {
      path: '/admin',
      name: 'admin',
      component: admin,
      children: [
        {
          path: 'dashboard',
          component: adminDashboard
        },
        {
          path: 'products',
          component: adminProducts
        },
        {
          path: 'orders',
          component: adminOrders
        },
        {
          path: 'users',
          component: adminUsers
        },
        {
          path: 'categories',
          component: adminCategories
        }
      ]
    },
    {
      path: '/error',
      component: NotFound
    },
    {
      path: '*',
      component: NotFound
    }
  ]
}
