import { createWebHistory, createRouter } from "vue-router"

import { useStorage } from "vue3-storage"
const storage = useStorage();

import Store from "../pages/Store.vue"
import Transection from "../pages/Transection.vue"
import Pos from "../pages/Pos.vue"
import Report from "../pages/Report.vue"
import Login from "../pages/Login.vue"
import Register from "../pages/Register.vue"

export const routes =[
    {
        name: "StorePage",
        path: "/store",
        component: Store
    },
    {
        name: "home",
        path: "/",
        component: Store
    },
    {
        name: "TransectionPage",
        path: "/transection",
        component: Transection
    },
    {
        name: "PosPage",
        path: "/pos",
        component: Pos
    },
    {
        name: "ReportPage",
        path: "/report",
        component: Report
    },
    {
        name: "LoginPage",
        path: "/login",
        component: Login
    },
    {
        name: "RegisterPage",
        path: "/register",
        component: Register
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(){
        window.scrollTo(0,0)
    }
});

// ກວດຊອບການ Login ໃນສ່ວນຂອງ Vue

router.beforeEach((to, from, next) => {
        if(to.path=='/register'){
            next();
        } else {
            if(to.path!='/login' && !storage.getStorageSync("isLoggin") && !window.Laravel.isLoggin){

                next({
                    path:'/login',
                    replace: true
                });

            } else {
                if(to.path=='/login' && storage.getStorageSync("isLoggin") && window.Laravel.isLoggin){
                    next({
                        path:'/store',
                        replace: true
                    });
                } else {
                    next();
                }
            }
        }
});

export default router;