<script>
    import Replies from '../components/Replies.vue';
    import SubscriptionButton from '../components/SubscriptionButton.vue';

    export default {
        props: ['thread'],
        components: { Replies, SubscriptionButton},
        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked
            }
        },
        methods: {
            toggleLock() {
                axios[this.locked ? 'delete' : 'post']('/lock-thread/' + this.thread.slug);
                this.locked = ! this.locked;
            }
        }
    }
</script>