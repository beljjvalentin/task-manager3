<template>
    <div id="app">
        <div class="flex justify-center">
            <v-btn v-show="userId!==0" variant="elevated" class=" h-1" @click="logOut">Log Out</v-btn>
            <div class="min-h-screen flex overflow-x-scroll py-12">
                <div
                    v-for="column in columns"
                    :key="column.name"
                    class="bg-gray-100 rounded-lg px-3 py-3 column-width mr-4"
                >
                    <p class="text-gray-700 font-bold font-sans tracking-wide text-base leading-loose">
                        {{column.name}}
                        <v-btn variant="elevated" class="float-right h-1" @click="addTask(column.id, $event)">Add task</v-btn>
                    </p>
                    <VueDraggableNext :list="column.tasks" :animation="200" ghost-class="ghost-card" group="tasks" @end="onEnd">
                        <!-- Each element from here will be draggable and animated. Note :key is very important here to be unique both for draggable and animations to be smooth & consistent. -->
                        <task-card
                            v-for="(task) in column.tasks"
                            :key="task.id"
                            :task="task"
                            class="mt-3 cursor-move"
                            @edit-event="editTask"
                        ></task-card>
                        <!-- </transition-group> -->
                    </VueDraggableNext>
                </div>
            </div>
        </div>
        <Login ref="loginForm" @authenticated="handleAuthentication"></Login>
        <Dialog ref="taskForm" @save-event="saveTask" @remove-event="removeTask"></Dialog>
    </div>
</template>

<script>
import { VueDraggableNext } from "vue-draggable-next";
import TaskCard from "./components/TaskCard.vue";
import Dialog from "./components/Dialog.vue";
import {VBtn} from "vuetify/components";
import axios from "axios";
import Login from "./components/Login.vue";
export default {
    name: "App",
    components: {
        VBtn,
        Dialog,
        Login,
        TaskCard,
        VueDraggableNext
    },
    methods: {
        onEnd: function (evt) {
            this.columns.forEach(col => {
                col.tasks.forEach(task => {
                    if (task.id === evt.target.__draggable_component__.context.element.id) {
                        const jsonData = {
                            name: task.name,
                            date: task.date,
                            category_id: col.id,
                            user_id: this.userId,
                            urgency: task.urgency,
                        };

                        axios.put(`/api/tasks/${task.id}/`, jsonData)
                            .then(response => {
                                console.log('Task moved successfully');
                            })
                            .catch(error => {
                                console.error('Error sending data:', error);
                            });
                    }
                })
            })
        },
        addTask: function (col_id, event) {
            this.selectedTaskId = 0;
            this.$refs.taskForm.open(null, col_id);
        },
        editTask: function (id) {
            this.selectedTaskId = id;
            this.columns.forEach(col => {
                col.tasks.forEach(task => {
                    if(this.selectedTaskId === task.id){
                        this.$refs.taskForm.open(task, col.id);
                    }
                })
            });
        },
        saveTask: function (id, name, date, urgency, category) {
            if(id === 0){
                const jsonData = {
                    name: name,
                    date: date,
                    category_id: category,
                    user_id: this.userId,
                    urgency: urgency,
                };

                axios
                    .post('/api/task', jsonData)
                    .then(response => {
                        this.columns.forEach(col => {
                            if(col.id === category){
                                col.tasks.push({
                                    "id": response.data.task.id,
                                    "name": name,
                                    "date": date,
                                    "urgency": urgency
                                });
                            }
                        })
                    })
                    .catch(error => {
                        console.error('Error sending data:', error);
                    });

            } else {
                const jsonData = {
                    name: name,
                    date: date,
                    category_id: category,
                    user_id: this.userId,
                    urgency: urgency,
                };

                axios.put(`/api/tasks/${this.selectedTaskId}/`, jsonData)
                    .then(response => {
                        this.columns.forEach(col => {
                            col.tasks.forEach(task => {
                                if(this.selectedTaskId === task.id){
                                    task.id = id;
                                    task.name = name;
                                    task.date = date;
                                    task.urgency = urgency;
                                }
                            })
                        });
                    })
                    .catch(error => {
                        console.error('Error sending data:', error);
                    });
            }

        },
        removeTask: function () {
            axios.delete(`/api/tasks/${this.selectedTaskId}/`)
                .then(response => {
                    this.columns.forEach(col => {
                        col.tasks.forEach((task, index) => {
                            if(this.selectedTaskId === task.id){
                                col.tasks.splice(index, 1);
                            }
                        })
                    });
                })
                .catch(error => {
                    console.error('Error sending data:', error);
                });
        },
        handleAuthentication: function(userId, authToken) {
            localStorage.setItem('userId', userId)
            this.userId = userId;
            const jsonData = {
                user_id: userId
            };

            axios
                .post('/api/tasks', jsonData)
                .then(response => {
                    this.columns = response.data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        logOut: function (){
            this.columns = [];
            this.userId = 0;
            localStorage.removeItem('userId')
            this.$refs.loginForm.open();
        }
    },
    data() {
        return {
            selectedTaskId: 0,
            columns: [],
            userId: 0
        };
    },
    mounted() {
        const userId = localStorage.getItem('userId');
        const authToken = localStorage.getItem('authToken');

        if (!userId) {
            this.$refs.loginForm.open();
        }
         else
        {
            this.handleAuthentication(userId, authToken);
                // const jsonData = {
                //     token: authToken
                // };
                //
                // axios
                //     .post('/api/check', jsonData)
                //     .then(response => {
                //         if(response.data.result === 'true'){
                //             console.log()
                //         } else {
                //             this.$refs.loginForm.open();
                //         }
                //         //this.$emit('authenticated', response.data.user_id, response.data.token);
                //         //this.dialog = false;
                //     })
                //     .catch(error => {
                //         console.error('Error sending data:', error);
                //     });
        }
    },
    watchers:{
    },
    computed: {
    }

};
</script>

<style scoped>

.column-width {
    min-width: 320px;
    width: 320px;
}

</style>
