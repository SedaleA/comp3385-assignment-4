<template>
    <div class="container mt-4">
        <h2 class="mb-4">Login</h2>

        <div v-if="errorMessage" class="alert alert-danger">
            {{ errorMessage }}
        </div>

        <form @submit.prevent="login">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="form.email"
                />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="form.password"
                />
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const form = ref({
    email: "",
    password: "",
});

const errorMessage = ref("");

const login = () => {
    fetch("/api/v1/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify(form.value),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.access_token) {
                localStorage.setItem("token", data.access_token);
                errorMessage.value = "";
                router.push("/movies");
            } else {
                errorMessage.value = data.error || "Login failed";
            }
        })
        .catch((error) => {
            console.log(error);
            errorMessage.value = "Something went wrong";
        });
};
</script>
