<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex gap-1">
                <button v-for="page in taskPages" @click="taskList = page.path"
                    class="font-semibold text-sm text-gray-800 leading-tight cursor-pointer px-2 py-1 rounded-lg "
                    :class="page.path == taskList ? 'bg-sky-200' : 'bg-gray-100 hover:bg-gray-300'">{{
                        page.title }}</button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="taskList == 'tasks-all'" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <TaskAll :tasks="tasksFree()" status="free"/>
                </div>
                <div v-if="taskList == 'tasks-my'" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <TaskAll :tasks="myTasks()" status="my"/>
                </div>
                <div v-if="taskList == 'created-tasks'" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <TaskAll :tasks="createdTasks()" status="created"/>
                </div>
                <div v-if="taskList == 'new-task'" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-12 p-1">
                            <div class="col-span-12">
                                <InputLabel for="title" value="Название" />
                                <TextInput id="title" v-model="newTask.title" type="text" class="mt-1 block w-full" required />
                                <InputError class="mt-2" :message="newTask.errors.title" />
                            </div>
                            <div class="col-span-12">
                                <InputLabel for="description" value="Описание" />
                                <Textarea id="description" v-model="newTask.description" type="text" class="mt-1 block w-full" ></Textarea>
                            </div>
                            <div class="col-span-6">
                                <InputLabel for="start" value="Срок выполнения" />
                                <input id="start" type="datetime-local" v-model="newTask.start" class="mt-1 block w-full" required />
                                <InputError class="mt-2" :message="newTask.errors.start" />
                            </div>
                            <div class="col-span-6">
                                <InputLabel for="end" value="Срок выполнения" />
                                <input id="end" type="datetime-local" v-model="newTask.end" class="mt-1 block w-full" required />
                                <InputError class="mt-2" :message="newTask.errors.end" />
                            </div>
                            <div class="col-span-12 py-1">
                                <div class="flex justify-between gap-2">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-lg">
                                        Создать
                                    </button>
                                    <button @click="formreset" type="reset" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded-lg">
                                        Очистить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { provide } from 'vue'
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import TaskAll from '@/Components/TaskTabs/TaskAll.vue';
import moment from 'moment';

defineOptions({
    name: 'Tasks'
})

const props = defineProps({
    tasks: {
        type: Array,
        required: true,
    },
    user: {
        type: Number,
        required: true,
    }
});

provide('user', props.user)
const myTasks = () => {return props.tasks.filter(e => e.task_users.find(u => u.user_id == props.user))};
const tasksFree = () => {return props.tasks};//.filter(e => e.taked_user_id == null)};
const createdTasks = () => {return props.tasks.filter(e => e.user_id == props.user)};

/* форма */
const newTask = useForm({
    title: '',
    description: '',
    start: moment().add(1, 'days').format('YYYY-MM-DD HH:mm'),
    end: moment().add(2, 'days').format('YYYY-MM-DD HH:mm'),
});
const formreset = () => {
    newTask.title= ''
    newTask.description= ''
    newTask.start= moment().add(1, 'days').format('YYYY-MM-DD HH:mm')
    newTask.end= moment().add(2, 'days').format('YYYY-MM-DD HH:mm')
};
const submit = async () => {
    newTask.transform(data => ({
        ...data,
    })).post(route('create-task'), {
        onFinish: () => {
            formreset()
        },
    });
};

/* вкладки */
const taskList = ref('tasks-my');

const taskPages = [
    {
        title: 'Все задания',
        path: 'tasks-all',
    }, {
        title: 'Задания в работе',
        path: 'tasks-my',
    },{
        title: 'Мои задания',
        path: 'created-tasks',
    },
    {
        title: 'Новое задание',
        path: 'new-task',
    }];

</script>
