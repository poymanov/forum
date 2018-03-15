<template>
    <div :id="'reply-' + data.id" class="card card-default mb-4">
        <div class="card-header">

            <div class="reply-header">
                <div>
                    <a :href="'/profile/' + owner_name" v-text="">{{ owner_name }}</a> said {{ ago }}
                </div>
                <div v-if="signedIn === true">
                    <favorite :reply="data"></favorite>
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

        <div class="card-footer d-flex" v-if="canUpdate">
            <button class="btn btn-primary mr-2" @click="editing = true">Edit</button>
            <button class="btn btn-danger" @click="destroy">Delete</button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['data'],
        components: { Favorite },
        data() {
            return {
                editing: false,
                body: this.data.body
            }
        },
        computed: {
            owner_name() {
                return this.data.owner.name;
            },
            ago() {
                return moment(this.data.created_at).fromNow();
            },
            signedIn() {
                return window.App.signedIn;
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id);
            }
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                }).catch(error => {
                    flash(error.response.data, 'danger');
                }).then(({data}) => {
                    this.editing = false;
                    flash('Updated');
                });

            },
            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);
            }
        }
    }
</script>