<template>
    <div :id="'reply-' + reply.id" class="card card-default mb-4">
        <div class="card-header" :class="isBest ? 'alert-success': ''">

            <div class="reply-header">
                <div>
                    <a :href="'/profile/' + owner_name" v-text="">{{ owner_name }}</a> said {{ ago }}
                </div>
                <div v-if="signedIn === true">
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>

        <div class="card-body" v-if="editing === true">
            <form @submit.prevent="update">
                <p>
                    <textarea name="edit-reply" rows="5" class="form-control" v-model="body" required></textarea>
                </p>

                <button class="btn btn-primary">Update</button>
                <button class="btn btn-link" @click="editing = false" type="button">Cancel</button>
            </form>
        </div>

        <div class="card-body" v-else-if="editing === false" v-html="body"></div>

        <div class="card-footer d-flex" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-primary mr-2" @click="editing = true">Edit</button>
                <button class="btn btn-danger" @click="destroy">Delete</button>
            </div>
            <button class="btn btn-default ml-auto" v-if="authorize('owns', reply.thread)" v-show="! isBest" @click="markBestReply">Best Reply?</button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],
        components: { Favorite },
        data() {
            return {
                editing: false,
                body: this.reply.body,
                isBest: this.reply.isBest
            }
        },
        created() {
            window.events.$on('best-reply-select', (id) => {
                this.isBest = (this.reply.id === id);
            });
        },
        computed: {
            owner_name() {
                return this.reply.owner.name;
            },
            ago() {
                return moment(this.reply.created_at).fromNow();
            },
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.reply.id, {
                    body: this.body
                }).catch(error => {
                    flash(error.response.data, 'danger');
                }).then(({data}) => {
                    this.editing = false;
                    flash('Updated');
                });

            },
            destroy() {
                axios.delete('/replies/' + this.reply.id);

                this.$emit('deleted', this.reply.id);
            },
            markBestReply() {
                axios.post('/replies/' + this.reply.id + '/best');
                window.events.$emit('best-reply-select', this.reply.id);
            }
        }
    }
</script>