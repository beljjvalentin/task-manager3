<template>
    <div id="app">
        <div class="flex justify-center">

            <div class="min-h-screen flex overflow-x-scroll py-12">
                <div
                    v-for="column in columns"
                    :key="column.name"
                    class="bg-gray-100 rounded-lg px-3 py-3 column-width rounded mr-4"
                >
                    <p class="text-gray-700 font-bold font-sans tracking-wide text-base leading-loose">
                        {{column.name}}
                        <v-btn variant="elevated" class="float-right h-1" @click="addTask">Add task</v-btn>
                    </p>
                    <VueDraggableNext :list="column.tasks" :animation="200" ghost-class="ghost-card" group="tasks" @end="onEnd">
                        <!-- Each element from here will be draggable and animated. Note :key is very important here to be unique both for draggable and animations to be smooth & consistent. -->
                        <task-card
                            v-for="(task) in column.tasks"
                            :key="task.id"
                            :task="task"
                            class="mt-3 cursor-move"
                        ></task-card>
                        <!-- </transition-group> -->
                    </VueDraggableNext>
                </div>
            </div>
        </div>
        <Dialog></Dialog>
    </div>
</template>

<script>
import { VueDraggableNext } from "vue-draggable-next";
import TaskCard from "./components/TaskCard.vue";
import apiClient from 'axios';
import Dialog from "./components/Dialog.vue";
import {VBtn} from "vuetify/components";
export default {
    name: "App",
    components: {
        VBtn,
        Dialog,
        TaskCard,
        VueDraggableNext
    },
    methods:{
        onEnd: function (evt){
            this.columns.forEach(col => {
                col.tasks.forEach(task => {
                    if(task.id === evt.target.__draggable_component__.context.element.id){
                        console.log(task)
                    }
                })
            })
            console.log()
        },
        addTask: function(){
            console.log(this.columns)
        },
        saveData: function(){

        }
    },
    data() {
        return {
            columns: [

            ]
        };
    },
    mounted() {
        apiClient
            .get('/api/tasks')
            .then(response => {
                this.columns = response.data;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }
};
</script>

<style scoped>

.column-width {
    min-width: 320px;
    width: 320px;
}
/* Unfortunately @apply cannot be setup in codesandbox,
but you'd use "@apply border opacity-50 border-blue-500 bg-gray-200" here */
/*.ghost-card {
    opacity: 0.5;
    background: #F7FAFC;
    border: 1px solid #4299e1;
}*/

</style>
