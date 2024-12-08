<template>
    <form @submit.prevent="submit">
        <div class="w-full grid grid-cols-12 px-2 py-1">
            <div class="col-span-5 max-lg:col-span-12 border px-1">
                <div class="" v-if="!canEdit">{{ task.title }}</div>
                <div class="" v-if="canEdit"><TextInput id="title" v-model="taskEdit.title" type="text" class="mt-1 block w-full" required /></div>
            </div>
            <div class="col-span-3 max-lg:col-span-4 border px-1 text-center">
                <div class="" v-if="!canEdit">{{ start }}</div>
                <div class="" v-if="canEdit"><TextInput id="title" v-model="taskEdit.start" type="text" class="mt-1 block w-full" required /></div>
            </div>
            <div class="col-span-3 max-lg:col-span-4 border px-1 text-center">
                <div class="" v-if="!canEdit">{{ end }}</div>
                <div class="" v-if="canEdit"><TextInput id="title" v-model="taskEdit.end" type="text" class="mt-1 block w-full" required /></div>
            </div>
            <div class="col-span-1 max-lg:col-span-4 border px-1 text-center grid " :class="canEdit ? 'grid-cols-3' : 'grid-cols-2'">
                <div @click="show = !show" class="w-full h-full text-center flex items-center justify-center">
                    <div
                        class=" rounded-lg h-6 w-6 px-1 py-0.5 bg-amber-100 hover:bg-amber-700 text-gray-800 hover:text-gray-100 transition-colors duration-300">
                        <i class="my-auto i-mdi-eye-circle-outline"></i>
                    </div>
                </div>
                <div v-if="status == 'free'" class="w-full h-full text-center flex items-center justify-center">
                    <div @click="getTask(task.id)"
                        class=" rounded-lg h-6 w-6 px-1 py-0.5 bg-green-100 hover:bg-green-700 text-gray-800 hover:text-gray-100 transition-colors duration-300">
                        <i class="my-auto i-mdi-checkbox-marked-circle-outline"></i>
                    </div>
                </div>
                <div v-if="status == 'my' && task.status != 'completed'" class="w-full h-full text-center flex items-center justify-center gap-1">
                    <div @click="cancelTask(task.id)"
                        class=" rounded-lg h-6 w-6 px-1 py-0.5 bg-red-100 hover:bg-red-700 text-gray-800 hover:text-gray-100 transition-colors duration-300">
                        <i class="my-auto  i-mdi-do-not-disturb-alt"></i>
                    </div>
                    <div @click="compleateTask(task.id)"
                        class=" rounded-lg h-6 w-6 px-1 py-0.5 bg-green-100 hover:bg-green-700 text-gray-800 hover:text-gray-100 transition-colors duration-300">
                        <i class="my-auto  i-mdi-checkbox-marked-circle-outline"></i>
                    </div>
                </div>
                <div v-if="status == 'my' && task.status == 'completed'" class="w-full h-full text-center flex items-center justify-center">
                    <div
                        class=" flex justify-center items-center rounded-lg h-6 px-1 py-0.5 bg-green-100  text-gray-800  transition-colors duration-300">
                        <i class="my-auto i-mdi-checkbox-multiple-marked-circle-outline"></i><span> completed</span>
                    </div>
                </div>
                <div v-if="status == 'created' && !task.taked_user_id"
                    class="w-full h-full text-center flex items-center justify-center">
                    <div @click="deleteTask(task.id)"
                        class=" rounded-lg h-6 w-6 px-1 py-0.5 bg-red-100 hover:bg-red-700 text-gray-800 hover:text-gray-100 transition-colors duration-300">
                        <i class="my-auto i-mdi-do-not-disturb-alt"></i>
                    </div>
                </div>
                <div v-if="status == 'created' && task.taked_user_id"
                    class="w-full h-full text-center flex items-center justify-center">
                    <div
                        class=" rounded-lg h-6 w-6 px-1 py-0.5 bg-green-100  text-gray-800  transition-colors duration-300">
                        <i class="my-auto i-mdi-account-star-outline">{{ task.taked_user_id }}</i>
                    </div>
                </div>
                <div v-if="status == 'created' && canEdit" class="w-full h-full text-center flex items-center justify-center">
                    <div @click="submit"
                        class=" rounded-lg h-6 w-6 px-1 py-0.5 bg-green-100 hover:bg-green-700 text-gray-800 hover:text-gray-100 transition-colors duration-300">
                        <i class="my-auto i-mdi-checkbox-marked-circle-outline"></i>
                    </div>
                </div>
            </div>
            <div class="col-span-12 border px-1" v-show="show">
                <div class="" v-if="!canEdit">{{ task.description }}</div>
                <div class="" v-if="canEdit"><Textarea id="description" v-model="taskEdit.description" type="text" class="mt-1 block w-full" ></Textarea></div>
            </div>
        </div>
    </form>
</template>

<script setup>
import moment from 'moment';
import { inject } from 'vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';

const show = ref(false);

const props = defineProps({
    task: Object,
    status: {
        type: String,
        required: true,
    },
});

const user = inject('user')

const start = moment(props.task.start).format('DD.MM.YYYY HH:mm');
const end = moment(props.task.end).format('DD.MM.YYYY HH:mm');

const canEdit = props.status == 'created' && !props.task.taked_user_id;

const taskEdit = useForm(props.task);
const data = useForm({});

const submit = () => {
    taskEdit.transform(data => ({
        ...data,
    })).post(route('update-task'));
};
function deleteTask (id) {
    data.delete(route('delete-task', {id:id}));
};



const getTask = (id) => {
    data.post(route('take-task', {id:id}))
};
const cancelTask = (id) => {
    data.post(route('cancel-task', {id:id}))
};
const compleateTask = (id) => {
    data.post(route('compleate-task', {id:id}))
};

</script>
