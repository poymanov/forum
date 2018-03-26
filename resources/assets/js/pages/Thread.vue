<script>
    import Replies from '../components/Replies.vue';
    import SubscriptionButton from '../components/SubscriptionButton.vue';

    export default {
        props: ['thread'],
        components: { Replies, SubscriptionButton},
        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                editing: false,
                title: this.thread.title,
                body: this.thread.body,
                form: {}
            }
        },
        created() {
            this.resetForm();
        },
        methods: {
            toggleLock() {
                axios[this.locked ? 'delete' : 'post']('/lock-thread/' + this.thread.slug);
                this.locked = ! this.locked;
            },
            update() {
                let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;

                axios.patch(uri, this.form).then(() => {
                    flash('Thread was updated');

                    this.title = this.form.title;
                    this.body = this.form.body;
                    this.editing = false;
                });
            },
            resetForm() {
                this.form.title = this.thread.title;
                this.form.body = this.thread.body;
                this.editing = false;
            }
        }
    }
</script>