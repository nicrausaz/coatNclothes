import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/views/home'
import Categories from '@/components/views/categories'
import WishLists from '@/components/views/wishlists'
import Shopbag from '@/components/views/shopbag'
import checkLogin from '@/components/views/checkLogin'
import Articles from '@/components/views/articles'
import Article from '@/components/views/article'
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
      path: '/categories/',
      name: 'Categories',
      component: Categories
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
      path: '/articles',
      name: 'Articles',
      component: Articles
    },
    {
      path: '/article/:id',
      name: 'Article',
      component: Article
    },
    {
      path: '*',
      component: NotFound
    }
  ]
})
