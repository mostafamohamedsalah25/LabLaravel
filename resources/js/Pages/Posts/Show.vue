<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    post: Object,
    // users: Array
});

const commentForm = useForm({
    body: '',
    // user_id: '',
});

const submitComment = () => {
    commentForm.post(route('comments.store', props.post.id), {
        preserveScroll: true,
        onSuccess: () => commentForm.reset('body'),
    });
};
</script>

<template>
    <Head title="View Post" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">View Post</h2>
                <Link :href="route('posts.index')" class="text-indigo-500 hover:underline">Back to Posts</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-4xl font-bold mb-4">{{ post.title }}</h1>

                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        Created by: <strong>{{ post.user?.name || 'Unknown' }}</strong>
                    </div>

                    <img v-if="post.image_path" :src="'/storage/' + post.image_path" class="w-full max-h-96 object-cover rounded mb-6" />

                    <p class="whitespace-pre-wrap">{{ post.body }}</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900 shadow sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Comments</h3>

                    <div class="space-y-4 mb-8">
                        <div v-for="comment in post.comments" :key="comment.id" class="bg-white dark:bg-gray-800 p-4 rounded shadow-sm">
                            <div class="font-bold text-gray-800 dark:text-gray-200 text-sm mb-1">
                                {{ comment.user?.name || 'Unknown' }}
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">{{ comment.body }}</p>
                        </div>
                        <div v-if="!post.comments.length" class="text-gray-500 italic">No comments yet.</div>
                    </div>

                    <form @submit.prevent="submitComment" class="bg-white dark:bg-gray-800 p-4 rounded border dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-3">Add a Comment</h4>

                        <!-- <div class="mb-3">
                            <select v-model="commentForm.user_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 mb-2">
                                <option value="">Post as...</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                            </select>
                            <div v-if="commentForm.errors.user_id" class="text-red-500 text-sm">{{ commentForm.errors.user_id }}</div>
                        </div> -->

                        <div class="mb-3">
                            <textarea v-model="commentForm.body" rows="2" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" placeholder="Your comment..."></textarea>
                            <div v-if="commentForm.errors.body" class="text-red-500 text-sm">{{ commentForm.errors.body }}</div>
                        </div>

                        <button type="submit" :disabled="commentForm.processing" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">Post Comment</button>
                    </form>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
