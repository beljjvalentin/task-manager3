<template>
    <div class="pa-4 text-center">
        <v-dialog
            v-model="dialog"
            max-width="600"
        >
<!--            <template v-slot:activator="{ props: activatorProps }">-->
<!--                <v-btn-->
<!--                    class="text-none font-weight-regular"-->
<!--                    prepend-icon="mdi-account"-->
<!--                    text="Edit Profile"-->
<!--                    variant="tonal"-->
<!--                    v-bind="activatorProps"-->
<!--                ></v-btn>-->
<!--            </template>-->

            <v-card
                prepend-icon="mdi-account"
                :title="this.taskId!==0?'Editing Task #' + this.taskId:'Adding new task'"
            >
                <v-card-text>
                    <v-row dense>
                        <v-col
                            cols="12"
                            md="12"
                            sm="12"
                        >
                            <v-text-field
                                label="Task description*"
                                v-model="taskName"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="6"
                            sm="6"
                        >
                            <v-text-field
                                type="date"
                                v-model="selectedDate"
                                label="Selected Date"
                                @click=""
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="6"
                            sm="6"
                        >
                            <v-select
                                :items="urgencyList"
                                v-model="urgency"
                                label="Urgency"
                                variant="outlined"
                                required
                            ></v-select>
                        </v-col>

                    </v-row>

                    <small class="text-caption text-medium-emphasis">*indicates required field</small>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-btn
                        text="Remove"
                        color="red"
                        variant="tonal"
                        class="float-start"
                        @click="removeAndClose"
                    ></v-btn>
                    <v-spacer></v-spacer>

                    <v-btn
                        text="Close"
                        variant="plain"
                        @click="dialog = false"
                    ></v-btn>

                    <v-btn
                        color="primary"
                        text="Save"
                        variant="tonal"
                        @click="saveAndClose"
                    ></v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

import {
    VAutocomplete,
    VBtn,
    VCard, VCardActions,
    VCardText,
    VCol, VDatePicker,
    VDialog,
    VDivider, VInput, VMenu,
    VRow,
    VSelect,
    VSpacer,
    VTextarea,
    VTextField
} from "vuetify/components";
import moment from 'moment'

export default {
    name: "Dialog",
    components: {
        VBtn,
        VDialog,
        VSelect,
        VDivider,
        VTextarea,
        VCard,
        VSpacer,
        VTextField,
        VRow,
        VCol,
        VCardText,
        VCardActions,
        VAutocomplete,
        VInput,
        VMenu,
        VDatePicker
    },
    emits: ['save-event', 'remove-event'],
    props: {
        id: {
            type: Number,
            default: 0
        },
        name: {
            type: String,
            default: ""
        },
        task: {
            default: () => ({})
        }
    },
    computed:{
        urgencyIndex(){
            for(let i=0; i<this.urgencyList.length; i++){
                if(this.urgency === this.urgencyList[i]){
                    return i+1;
                }
            }
            return 0
        }
    },
    watch: {
        dialog: function(newVal, oldVal) { // watch it
            //console.log(newVal + "|" + oldVal)
        },
    },
    methods: {
        open(task){
            this.taskId = 0;
            this.taskName = "";
            this.urgency = "1. Urgent";
            this.selectedDate = moment(new Date()).format('yyyy-MM-DD');
            if(task){
                this.taskId = task.id;
                this.taskName = task.name;
                this.selectedDate = task.date;
                let selectedId = 0;
                let selectedName = "";
                this.urgencyList.forEach(function (el, idx) {
                    if(idx === (task.urgency - 1)){
                        selectedName = el;
                        selectedId = idx;
                    }
                });
                this.urgency = selectedName;
            }
            this.dialog = true;
        },
        saveAndClose(){
            this.dialog = false;
            this.$emit('save-event', this.taskId, this.taskName, this.selectedDate, this.urgencyIndex)
        },
        removeAndClose(){
            if (window.confirm("Are you sure you want to remove this record?")) {
                this.dialog = false;
                this.$emit('remove-event', this.taskId)
            }
        }
    },
    data(){
        return {
            selectedDate: "",
            taskId: 0,
            taskName: "",
            urgencyList: ['1. Urgent', '2. Finish soon', '3. Regular tasks', '4. Low priority'],
            urgencySelected: "",
            urgency: "",
            dialog: false,
        }
    }
}
</script>

<style scoped>

</style>
