<template>
  <section class="login-box">
    <img src="/img/logo_2.png" alt="Logo" class="logo" />
    <h2 class="admin-title">Login</h2>

    <div v-if="userStore.isLoggedIn">
      <p><strong>Bienvenido:</strong> {{ userStore.user.first_name }}</p>
      <p><strong>Email:</strong> {{ userStore.user.email }}</p>
      <p><strong>Rol:</strong> {{ userStore.user.role }}</p>
      <button @click="logout" class="btn-secondary">Cerrar sesión</button>
    </div>

    <form v-else @submit.prevent="handleLogin">
      <label>Email</label>
      <input type="email" v-model="email" required />

      <label>Password</label>
      <input type="password" v-model="password" required />

      <button type="submit" class="btn-primary">Iniciar sesión</button>
    </form>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/user'
import axios from 'axios'

const email = ref('')
const password = ref('')
const router = useRouter()
const userStore = useUserStore()

axios.defaults.baseURL = 'http://localhost:8000'

const handleLogin = async () => {
  try {
    const response = await axios.post('http://localhost:8000/api/login', {
      email: email.value,
      password: password.value
    });

    localStorage.setItem('auth_token', response.data.token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
    userStore.setUser(response.data.user);

    if (response.data.user.role === 'admin') {
      window.location.href = 'http://localhost:8000/admin/products'
    } else {
      router.push('/account/orders');
    }
  } catch (error) {
    console.error(error);
    alert('Login fallido');
  }
};


const logout = () => {
  localStorage.removeItem('auth_token')
  delete axios.defaults.headers.common['Authorization']
  userStore.clearUser()
  router.push('/account/login')
}
</script>

<style scoped>
.login-box {
  flex: 1;
  padding: 60px 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.logo {
  height: 60px;
  margin-bottom: 10px;
}

.admin-title {
  color: #8b0000;
  margin-bottom: 20px;
  font-size: 2rem;
}

form {
  display: flex;
  flex-direction: column;
  width: 100%;
  max-width: 300px;
}

label {
  margin-top: 10px;
  font-weight: bold;
  font-size: 14px;
}

input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.btn-primary {
  margin-top: 20px;
  padding: 12px;
  background-color: #8b0000;
  color: white;
  border: none;
  border-radius: 25px;
  font-weight: bold;
  cursor: pointer;
}

.btn-secondary {
  margin-top: 20px;
  padding: 12px;
  background-color: #999;
  color: white;
  border: none;
  border-radius: 25px;
  font-weight: bold;
  cursor: pointer;
}
</style>
