import Vue from 'vue';
import VueRouter from 'vue-router';


import NotFound from './components/NotFound';
import Register from './components/Register';
import Verification from './components/auth/Verification';
import Resend from './components/auth/Resend';
import Login from './components/Login';

import ListArticles from "./components/articles/ListArticles";
import CreateArticle from "./components/articles/CreateArticle";
import EditArticle from "./components/articles/EditArticle";
import ViewArticle from "./components/articles/ViewArticle";


Vue.use(VueRouter);

const routes = [
    {
        path: '*',
        component: NotFound
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/email/verify/:id/:hash',
        name: 'VerificationVerify',
        component: Verification,
        props: true
    },
    {
        path: '/email/resend',
        name: 'Resend',
        component: Resend
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/articles',
        name: 'ListArticles',
        component: ListArticles,
        meta: {
            auth: true
        }
    },
    {
        path: '/articles/create',
        name: 'CreateArticle',
        component: CreateArticle,
        meta: {
            auth: true
        }
    },
    {
        path: '/articles/edit/:id',
        name: 'EditArticle',
        component: EditArticle,
        props: true,
        meta: {
            auth: true
        }
    },
    {
        path: '/articles/view/:id',
        name: 'ViewArticle',
        component: ViewArticle,
        props: true,
        meta: {
            auth: true
        }
    }
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('user')

    if (to.matched.some(record => record.meta.auth) && !loggedIn) {
        next('/login')
        return
    }
    next()
});

export default router
