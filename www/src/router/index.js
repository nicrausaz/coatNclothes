import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/views/home'
import Categories from '@/components/views/categories'
import WishList from '@/components/views/wishlist'
import Shopbag from '@/components/views/shopbag'
import Userprofile from '@/components/views/userprofile'
import Articles from '@/components/views/articles'
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
      name: 'Categories',
      component: Categories
    },
    {
      path: '/wishlist',
      name: 'Wishlist',
      component: WishList
    },
    {
      path: '/shopbag',
      name: 'Shopbag',
      component: Shopbag
    },
    {
      path: '/user',
      name: 'User',
      component: Userprofile
    },
    {
      path: '/articles',
      name: 'Articles',
      component: Articles
    },
    {
      path: '*',
      component: NotFound
    }
  ]
})
