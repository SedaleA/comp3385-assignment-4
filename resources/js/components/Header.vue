<script setup>
import { useRouter } from "vue-router";
import { ref, onMounted } from "vue";

const router = useRouter();
const token = ref(null);

onMounted(() => {
    token.value = localStorage.getItem("token");
});

const logout = () => {
    fetch("/api/v1/logout", {
        method: "POST",
        headers: {
            Accept: "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    })
        .then((response) => response.json())
        .then(() => {
            localStorage.removeItem("token");
            token.value = null;
            router.push("/login");
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">COMP3385</a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <RouterLink
                            class="nav-link"
                            :class="{ active: $route.path === '/' }"
                            to="/"
                        >
                            Home
                        </RouterLink>
                    </li>

                    <li class="nav-item">
                        <RouterLink
                            class="nav-link"
                            :class="{ active: $route.path === '/about' }"
                            to="/about"
                        >
                            About
                        </RouterLink>
                    </li>

                    <li class="nav-item">
                        <RouterLink
                            class="nav-link"
                            :class="{ active: $route.path === '/movies' }"
                            to="/movies"
                        >
                            Movies
                        </RouterLink>
                    </li>

                    <li class="nav-item">
                        <RouterLink
                            class="nav-link"
                            :class="{
                                active: $route.path === '/movies/create',
                            }"
                            to="/movies/create"
                        >
                            Add Movie
                        </RouterLink>
                    </li>
                </ul>

                <div class="d-flex">
                    <RouterLink
                        v-if="!token"
                        class="btn btn-outline-light me-2"
                        to="/login"
                    >
                        Login
                    </RouterLink>

                    <button v-else class="btn btn-danger" @click="logout">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped></style>
