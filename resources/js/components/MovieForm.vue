<template>
    <div class="container mt-4">
        <h2 class="mb-4">Add a Movie</h2>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>

        <div v-if="Object.keys(errors).length" class="alert alert-danger">
            <ul class="mb-0">
                <li v-for="(messages, field) in errors" :key="field">
                    <span v-for="message in messages" :key="message">
                        {{ message }}
                    </span>
                </li>
            </ul>
        </div>

        <form @submit.prevent="saveMovie">
            <div class="mb-3">
                <label for="title" class="form-label">Movie Title</label>
                <input
                    type="text"
                    id="title"
                    class="form-control"
                    v-model="form.title"
                />
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea
                    id="description"
                    class="form-control"
                    rows="4"
                    v-model="form.description"
                ></textarea>
            </div>

            <div class="mb-3">
                <label for="poster" class="form-label">Poster</label>
                <input
                    type="file"
                    id="poster"
                    class="form-control"
                    @change="form.poster = $event.target.files[0]"
                />
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const form = ref({
    title: "",
    description: "",
    poster: null,
});

const successMessage = ref("");
const errors = ref({});

const saveMovie = () => {
    const form_data = new FormData();
    form_data.append("title", form.value.title);
    form_data.append("description", form.value.description);
    form_data.append("poster", form.value.poster);

    fetch("/api/v1/movies", {
        method: "POST",
        body: form_data,
        headers: {
            Accept: "application/json",
        },
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.errors) {
                errors.value = data.errors;
                successMessage.value = "";
            } else {
                successMessage.value = data.message;
                errors.value = {};

                router.push("/movies");

                form.value = {
                    title: "",
                    description: "",
                    poster: null,
                };
            }
        })
        .catch(function (error) {
            console.log(error);
        });
};
</script>
