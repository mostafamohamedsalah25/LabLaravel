<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    posts: Object
});

const form = useForm({});

const deletePost = (id) => {
    if (confirm('Are you sure you want to delete this post?')) {
        form.delete(route('posts.destroy', id));
    }
};

const restorePost = (id) => {
    form.patch(route('posts.restore', id));
};
</script>

<template>
    <Head title="All Posts" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">All Posts</h2>
                <Link :href="route('posts.create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Create New</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <table class="w-full text-left border-collapse text-gray-900 dark:text-gray-100">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 border-b dark:border-gray-600">
                                <th class="p-4 font-semibold">ID</th>
                                <th class="p-4 font-semibold">Title</th>
                                <th class="p-4 font-semibold text-center">Author</th>
                                <th class="p-4 font-semibold text-center">Created At</th>
                                <th class="p-4 font-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in posts.data" :key="post.id" :class="{'bg-red-50 dark:bg-red-900/20': post.deleted_at}" class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="p-4">{{ post.id }}</td>
                                <td class="p-4 font-bold">
                                    <div class="flex items-center gap-3">
                                        <img v-if="post.image_path" :src="'/storage/' + post.image_path" class="w-10 h-10 object-cover rounded" />
                                        {{ post.title }}
                                    </div>
                                </td>
                                <td class="p-4 text-center">{{ post.user?.name || 'Unknown' }}</td>
                                <td class="p-4 text-center">{{ new Date(post.created_at).toLocaleDateString() }}</td>

                                <!-- <td class="p-4 flex gap-4 justify-center items-center">
                                    <template v-if="post.deleted_at">
                                        <button @click="restorePost(post.id)" class="text-green-600 hover:text-green-800 font-bold underline">Restore</button>
                                    </template>
                                    <template v-else>
                                        <Link :href="route('posts.show', post.id)" class="text-blue-500 hover:underline">Show</Link>
                                        <Link :href="route('posts.edit', post.id)" class="text-yellow-500 hover:underline">Edit</Link>
                                        <button @click="deletePost(post.id)" class="text-red-500 hover:underline">Delete</button>
                                    </template>
                                </td> -->
                                <td class="p-4 flex gap-4 justify-center items-center">
                                    <Link :href="route('posts.show', post.id)" class="text-blue-500 hover:underline">Show</Link>

                                    <template v-if="post.user_id === $page.props.auth.user.id">
                                        <template v-if="post.deleted_at">
                                            <button @click="restorePost(post.id)" class="text-green-600 hover:text-green-800 font-bold underline">Restore</button>
                                        </template>
                                        <template v-else>
                                            <Link :href="route('posts.edit', post.id)" class="text-yellow-500 hover:underline">Edit</Link>
                                            <button @click="deletePost(post.id)" class="text-red-500 hover:underline">Delete</button>
                                        </template>
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-6 flex gap-2">
                        <Link v-for="(link, index) in posts.links" :key="index" :href="link.url || '#'" v-html="link.label"
                              class="px-3 py-1 border rounded dark:border-gray-600"
                              :class="{'bg-blue-600 text-white': link.active, 'text-gray-500 opacity-50': !link.url}" />
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
