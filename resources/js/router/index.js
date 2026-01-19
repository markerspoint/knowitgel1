import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import AdminDashboard from '../components/AdminDashboard.vue';
import UserDashboard from '../components/UserDashboard.vue';
import Profile from '../components/Profile.vue';
import Settings from '../components/Settings.vue';
import Users from '../components/Users.vue';
import UserProfile from '../components/UserProfile.vue';
import UserSettings from '../components/UserSettings.vue';
import UserHistory from '../components/UserHistory.vue';
import Assessment from '../components/Assessment.vue';
import Leaderboard from '../components/Leaderboard.vue';
import AdminAssessment from '../components/AdminAssessment.vue';
import QAFPSGame from '../components/QAFPSGame.vue';
import TyperGel1 from '../components/TyperGel1.vue';
import Studies from '../components/Studies.vue';

const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/register',
    name: 'register',
    component: Register
  },
  {
    path: '/admin/dashboard',
    name: 'admin.dashboard',
    component: AdminDashboard,
    meta: { requiresAuth: true, role: 'admin' }
  },
  {
    path: '/admin/profile',
    name: 'admin.profile',
    component: Profile,
    meta: { requiresAuth: true, role: 'admin' }
  },
  {
    path: '/admin/settings',
    name: 'admin.settings',
    component: Settings,
    meta: { requiresAuth: true, role: 'admin' }
  },
  {
    path: '/admin/users',
    name: 'admin.users',
    component: Users,
    meta: { requiresAuth: true, role: 'admin' }
  },
  {
    path: '/admin/assessment',
    name: 'admin.assessment',
    component: AdminAssessment,
    meta: { requiresAuth: true, role: 'admin' }
  },
  {
    path: '/assessment',
    name: 'assessment',
    component: Assessment,
    meta: { requiresAuth: true, role: 'user' }
  },
  {
    path: '/user/dashboard',
    name: 'user.dashboard',
    component: UserDashboard,
    meta: { requiresAuth: true, role: 'user' }
  },
  {
    path: '/qa-fps',
    name: 'user.qa-fps',
    component: QAFPSGame,
    meta: { requiresAuth: true, role: 'user' }
  },
  {
    path: '/typergel1',
    name: 'user.typergel1',
    component: TyperGel1,
    meta: { requiresAuth: true, role: 'user' }
  },
  {
    path: '/user/profile',
    name: 'user.profile',
    component: UserProfile,
    meta: { requiresAuth: true, role: 'user' }
  },
  {
    path: '/user/settings',
    name: 'user.settings',
    component: UserSettings,
    meta: { requiresAuth: true, role: 'user' }
  },
  {
    path: '/user/history',
    name: 'user.history',
    component: UserHistory,
    meta: { requiresAuth: true, role: 'user' }
  },
  {
    path: '/leaderboard',
    name: 'leaderboard',
    component: Leaderboard,
    meta: { requiresAuth: true, role: 'user' }
  },
  {
    path: '/lessons',
    name: 'studies',
    component: Studies,
    meta: { requiresAuth: true, role: 'user' }
  },
  {
    path: '/',
    redirect: '/login'
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach(async (to, from, next) => {
  if (to.meta.requiresAuth) {
    try {
      const response = await axios.get('/api/user');
      const user = response.data.user;
      
      if (!user) {
        next('/login');
        return;
      }
      
      if (user.is_disabled) {
        try {
          await axios.post('/api/logout');
        } catch (logoutError) {
          console.error('Logout error:', logoutError);
        }
        next({
          path: '/login',
          query: { disabled: 'true' }
        });
        return;
      }
      
      if (to.meta.role && user.role !== to.meta.role) {
        if (user.role === 'admin') {
          next('/admin/dashboard');
        } else {
          if (!user.has_completed_assessment) {
            next('/assessment');
          } else {
            next('/user/dashboard');
          }
        }
        return;
      }
      
      if (user.role === 'user' && !user.has_completed_assessment && to.name !== 'assessment') {
        next('/assessment');
        return;
      }
      
      if (user.role === 'user' && user.has_completed_assessment && to.name === 'assessment') {
        next('/user/dashboard');
        return;
      }
      
      next();
    } catch (error) {
      if (error.response && error.response.status === 401) {
        next('/login');
      } else {
        next('/login');
      }
    }
  } else {
    if (to.path === '/login' || to.path === '/register') {
      try {
        const response = await axios.get('/api/user');
        const user = response.data.user;
        if (user) {
          if (user.role === 'admin') {
            next('/admin/dashboard');
          } else {
            if (!user.has_completed_assessment) {
              next('/assessment');
            } else {
              next('/user/dashboard');
            }
          }
          return;
        }
      } catch (error) {
      }
    }
    next();
  }
});

export default router;

