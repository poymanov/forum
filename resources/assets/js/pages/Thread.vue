<script>
    import Replies from '../components/Replies.vue';
    import SubscriptionButton from '../components/SubscriptionButton.vue';

    export default {
        props: ['initialRepliesCount'],
        components: { Replies, SubscriptionButton},
        data() {
            return {
                repliesCount: this.initialRepliesCount
            }
        }
    }
</script>