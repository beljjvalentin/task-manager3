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
                            sm="6"
                        >
                            <v-text-field
                                label="Task description*"
                                v-model="taskName"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col
                            cols="12"
                            md="8"
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
                            md="4"
                            sm="6"
                        >
                            <v-select
                                :items="urgencyList"
                                v-model="urgencyList[urgencyIndex - 1]"
                                label="Priority"
                                required
                            ></v-select>
                        </v-col>

                    </v-row>

                    <small class="text-caption text-medium-emphasis">*indicates required field</small>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
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
    emits: ['save-event'],
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
            this.urgencyIndex = 1;
            this.selectedDate = moment(new Date()).format('yyyy-MM-DD');
            if(task){
                this.taskId = task.id;
                this.taskName = task.name;
                this.selectedDate = task.date;
                // urgencyList.forEach(el => {
                //     el.id ==
                // });
                this.urgencyIndex = task.urgency;

            }
            this.dialog = true;
        },
        saveAndClose(){
            this.dialog = false
            this.$emit('save-event', this.taskId, this.taskName, this.selectedDate, this.urgencyIndex)
        }
    },
    data(){
        return {
            selectedDate: "",
            taskId: 0,
            taskName: "",
            urgencyList: ['1. Urgent', '2. Finish soon', '3. Regular tasks', '4. Low priority'],
            urgencySelected: "",
            urgencyIndex: 1,
            dialog: false,
        }
    }
}
</script>

<style scoped>

</style>
