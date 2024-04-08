<template>
    <div class="bg-white shadow rounded px-3 pt-3 pb-5 border border-white" :data-id="task.id">
        <div class="flex justify-between">
            <p class="text-gray-700 font-semibold font-sans tracking-wide text-sm">{{task.name}}</p>

            <img
                class="w-6 h-6 rounded-full ml-3 editButton"
                src="../../../public/edit.png"
                alt="Edit button"
                @click="editTask"
            >
        </div>
        <div class="flex mt-4 justify-between items-center">
            <span class="text-sm text-gray-600">{{task.date}}</span>
            <Badge :color="badgeColor" :text="task.urgency.toString()"></Badge>
        </div>
    </div>
</template>
<script>
import Badge from "./Badge.vue";
export default {
    components: {
        Badge
    },
    props: {
        task: {
            urgency: Object,
            default: () => ({})
        }
    },
    computed: {
        badgeColor() {
            const mappings = {
                1: "bg-red-500",
                2: "bg-amber-500",
                3: "bg-lime-500",
                4: "bg-teal-500",
                default: "urgent"
            };
            return mappings[this.task.urgency] || mappings.default;
        }
    },
    methods:{
        editTask: function() {
            console.log("Editing task #" + this.task.id)

        }
    },
    mounted() {

    }
};
</script>

<style>
.editButton {
    cursor: pointer;
}
</style>
