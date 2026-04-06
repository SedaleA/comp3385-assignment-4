import { createRouter, createWebHistory } from "vue-router";
import AboutView from "../Pages/AboutView.vue";
import HomeView from "../Pages/HomeView.vue";
import AddMovieView from "../Pages/AddMovieView.vue";
import MoviesView from "../Pages/MoviesView.vue";
import LoginView from "../Pages/LoginView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            component: HomeView,
        },
        {
            path: "/about",
            component: AboutView,
        },
        {
            path: "/movies/create",
            component: AddMovieView,
            meta: { requiresAuth: true },
        },
        {
            path: "/movies",
            component: MoviesView,
            meta: { requiresAuth: true },
        },
        {
            path: "/login",
            component: LoginView,
        },
    ],
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !localStorage.getItem("token")) {
        next("/login");
    } else {
        next();
    }
});

export default router;
