<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    post: Object,
    // users: Array
});

const form = useForm({
    _method: 'put',
    title: props.post.title,
    body: props.post.body,
    // user_id: props.post.user_id,
    image: null,
});

const submit = () => {
    form.post(route('posts.update', props.post.id));
};
</script>

<template>
    <Head title="Edit Post" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Post</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit" class="space-y-6">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" v-model="form.title" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" />
                            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Image</label>
                            <img v-if="post.image_path" :src="'/storage/' + post.image_path" class="w-32 rounded mb-2 mt-1" />
                            <input type="file" @input="form.image = $event.target.files[0]" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400" />
                            <div v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</div>
                        </div>

                        <!-- <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Author</label>
                            <select v-model="form.user_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                            </select>
                            <div v-if="form.errors.user_id" class="text-red-500 text-sm mt-1">{{ form.errors.user_id }}</div>
                        </div> -->

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Body</label>
                            <textarea v-model="form.body" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"></textarea>
                            <div v-if="form.errors.body" class="text-red-500 text-sm mt-1">{{ form.errors.body }}</div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">Update Post</button>
                            <Link :href="route('posts.index')" class="px-4 py-2 text-gray-600 dark:text-gray-400">Cancel</Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
