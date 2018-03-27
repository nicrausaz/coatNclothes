import Vue from 'vue'
import Router from 'vue-router'

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
import adminUsers from '@/components/shared/admin/users/users'
import adminOrders from '@/components/shared/admin/orders/orders'

import NotFound from '@/components/views/404'

Vue.use(Router)

export default new Router({
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
      path: '/orderconfirm',
      name: 'orderconfirm',
      component: orderconfirm
    },
    {
      path: '/order/:id',
      name: 'order',
      component: orders
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
})
