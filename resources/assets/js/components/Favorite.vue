<template>
    <button :class="classes" @click="toggle">Likes: <span v-text="count"></span></button>
</template>

<script>
    export default {
        props: ['reply'],
        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited
            };
        },
        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default']
            },
            repliesUrl()
            {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },
        methods: {
            toggle() {
                this.active ? this.unfavorite() : this.favorite();
            },
            favorite() {
                axios.post(this.repliesUrl);
                this.active = true;
                this.count++;
            },
            unfavorite() {
                axios.delete(this.repliesUrl);
                this.active = false;
                this.count--;
            }
        }
    }
</script>