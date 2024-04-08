<template>
    <span :class="`inline-block whitespace-nowrap rounded-full justify-center px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none ${color}`"
    >{{text}}</span>
</template>
<script>
export default {
    props: {
        color: {
            type: String,
            default: "success"
        },
        text: {
            type: String,
            default: ""
        }
    }
};
</script>
