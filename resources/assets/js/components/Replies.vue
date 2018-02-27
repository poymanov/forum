<template>
    <div>
        <div v-for="(item, index) in items">
            <reply :data="item" @deleted="remove(index)"></reply>
        </div>

        <new-reply :new-reply-url="newReplyUrl" @added="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';

    export default {
        props: ['data'],
        components: { Reply, NewReply},
        data() {
            return {
                items: this.data
            }
        },
        computed: {
            newReplyUrl() {
                return location.pathname + '/replies';
            }
        },
        methods: {
            remove(index) {
                this.items.splice(index, 1);
                this.$emit('removed');
                flash('Reply was deleted');
            },
            add(reply) {
                this.items.push(reply);
                this.$emit('added');
                flash('Your reply has been left');
            }
        }
    }
</script>