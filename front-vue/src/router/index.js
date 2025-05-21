
import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from '@/stores/user'


import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import SignUpView from '@/views/SignUpView.vue'
import AccountLayout from '@/views/account/AccountLayout.vue'
import OrdersView from '@/views/account/OrdersView.vue'
import AddressView from '@/views/account/AddressView.vue'
import PasswordView from '@/views/account/PasswordView.vue'
import AccountDetailView from '@/views/account/AccountDetailView.vue'
import ProductDetailView from '@/views/ProductDetailView.vue'
import SearchView from '@/views/SearchView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path:'/account/login',
    name: 'login',
    component: LoginView
  },
  {
    path:'/account/create',
    name: 'signup',
    component: SignUpView
  },
  {
    path: '/account',
    component: AccountLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: 'orders',
        name: 'orders',
        component: OrdersView
      },
      {
        path: 'address',
        name: 'address',
        component: AddressView
      },
      {
        path: 'password',
        name: 'password',
        component: PasswordView
      },
      {
        path: 'details',
        name: 'accountDetails',
        component: AccountDetailView
      }
    ]
  },
  {
    path: '/faq',
    name: 'faq',
    component: () => import('@/views/FaqView.vue') // Ruta FAQ al mismo nivel que search
  },
  {
    path: '/search',
    name: 'search',
    component: SearchView
  } ,
  
  {
    path: '/product/:id',
    name: 'product-detail',
    component: ProductDetailView
  }

  //MAS RUTAS
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

//Middleware para proteger las rutas 
router.beforeEach((to, from, next) => {
  const store = useUserStore()
  const token = localStorage.getItem('auth_token')

  // No hay token ni usuario
  if (to.meta.requiresAuth && (!token || !store.user)) {
    return next('/account/login')
  }

  // Si el usuario es ADMIN y quiere entrar a /account, lo redirige al admin panel
  if (to.path === '/account/login' && store.user?.role === 'admin') {
    return window.location.href = 'http://localhost:8000/admin/products'
  }


  // Si es CLIENTE y trata de entrar a una ruta solo para admins
  if (to.meta.adminOnly && store.user?.role !== 'admin') {
    return next('/account/orders')
  }

  next()
})



export default router
