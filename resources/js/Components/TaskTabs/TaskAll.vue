<template>
    <div v-for="task in tasks" :key="task.id">
        <Task :task :status/>
    </div>
</template>

<script setup>
import  Task from '@/Components/TaskTabs/Task.vue';
import { onMounted, ref } from 'vue';

defineProps({
    tasks: Array,
    status: {
        type: String,
        required: true,
    },
});
</script>
