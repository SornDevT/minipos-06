import { createWebHistory, createRouter } from "vue-router"

import Store from "../pages/Store.vue"
import Transection from "../pages/Transection.vue"
import Pos from "../pages/Pos.vue"
import Report from "../pages/Report.vue"

export const routes =[
    {
        name: "StorePage",
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
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(){
        window.scrollTo(0,0)
    }
});

export default router;