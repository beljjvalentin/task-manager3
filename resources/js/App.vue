<template>
    <div id="app">
        <div class="flex justify-center">

            <div class="min-h-screen flex overflow-x-scroll py-12">
                <div
                    v-for="column in columns"
                    :key="column.title"
                    class="bg-gray-100 rounded-lg px-3 py-3 column-width rounded mr-4"
                >
                    <p class="text-gray-700 font-semibold font-sans tracking-wide text-sm">
                        {{column.title}}
                        <button class="btn float-right">Add task</button>
                    </p>
                    <VueDraggableNext :list="column.tasks" :animation="200" ghost-class="ghost-card" group="tasks" :move="checkMove">
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
    </div>
</template>

<script>
//import draggable from "vuedraggable";
import { VueDraggableNext } from "vue-draggable-next";
import TaskCard from "./components/TaskCard.vue";
import apiClient from 'axios';
export default {
    name: "App",
    components: {
        TaskCard,
        VueDraggableNext
    },
    methods:{
        checkMove: function(evt){
            console.log(evt.draggedContext.element.id);
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
            .get('https://api.coindesk.com/v1/bpi/currentprice.json')
            .then(response => (this.columns = response))
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
