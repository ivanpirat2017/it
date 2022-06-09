import { createRouter, createWebHistory } from 'vue-router'
import { authCheck ,authAdminCheck} from "../api-routes";
import Home from './routers/Home.vue'
import Service from './routers/Service.vue'
import CartPage from './routers/CartPage.vue'
import Login from './routers/Login.vue'
import Registration from './routers/Registration.vue'
import Profile from './routers/Profile.vue'
import Worker from './routers/Worker.vue'
import Comments from './routers/worker/Comments.vue'
import Orders from './routers/worker/Orders.vue'
import Role from './routers/worker/Role.vue'
import NotFound from './routers/NotFound.vue'
import Search from './routers/Search.vue'
import About from './routers/About.vue'
import Delivery from './routers/Delivery.vue'
import AddMainContent from './routers/worker/AddMainContent.vue'
import ServiceAdmin from './routers/ServiceAdmin.vue'

const routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: NotFound,
    },
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/delivery',
        name: 'Delivery',
        component: Delivery
    },

    {
        path: '/search',
        name: 'Search',
        component: Search
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/registration',
        name: 'Registration',
        component: Registration
    },
    {
        path: '/service/:id',
        name: 'Service',
        component: Service
    },
    {
        path: '/cart',
        name: 'Cart',
        component: CartPage
    },
    {
        path: '/about',
        name: 'About',
        component: About
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile
    }
    ,
    {
        path: '/worker',
        name: 'Worker',
        component: Worker,
        meta: {
            name: 'admin'
        },
        children: [
            {
                path: 'comment',
                name: 'Comments',
                component: Comments,
                meta: {
                    name: 'admin'
                }
            },
            {
                path: 'admin',
                name: 'Role',
                component: Role,
                meta: {
                    name: 'admin'
                }
            },
            {
                path: 'content',
                name: 'AddMainContent',
                component: AddMainContent,
                meta: {
                    name: 'admin'
                }
            },
            {
                path: 'service/:id',
                name: 'ServiceAdmin',
                component: ServiceAdmin
            },
            {
                path: 'orders',
                name: 'Orders',
                component: Orders,
                meta: {
                    name: 'admin'
                }
            }
        ]
    }
]
const router = createRouter({
    history: createWebHistory(),
    routes
})
router.beforeEach(async (to, from) => {

    if (to.meta.name == 'admin') {
        return await authAdminCheck().then(r => {
            if (r.status == 200) {
            } else {
                return '/'
            }
        })
    }
    if (to.fullPath == '/profile'||to.fullPath == '/delivery') {
        return await authCheck().then(r => {
            if (r.status == 200) {
            } else {
                return '/login'
            }
        })
    }
    if (to.fullPath == '/login' || to.fullPath == '/registration') {
        return await authCheck().then(r => {
            if (r.status == 200) {
                return '/profile'
            }
        })
    }

    window.scroll(0, 0);
})

export default router

