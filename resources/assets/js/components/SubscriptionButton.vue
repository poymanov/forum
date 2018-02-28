<template>
    <button :class="classes" @click="subscribe">Test</button>
</template>

<script>
    export default {
        props: ['active'],
        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            }
        },
        methods: {
            subscribe() {
                let method = this.active ? 'delete' : 'post';
                axios[method](location.pathname + '/subscriptions');
                this.active = ! this.active;
            }
        }
    }
</script>