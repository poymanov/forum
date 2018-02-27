<template>

    <div class="create-reply" v-if="signedIn">
        <div class="form-group">
            <textarea name="body"
                      class="form-control"
                      rows="5"
                      placeholder="Have something to say?"
                      required
                      v-model="body">
            </textarea>
        </div>
        <button class="btn" @click="postReply">Post</button>
    </div>

    <p class="text-center" v-else>Please <a href="/login">sign in</a> to participate this discussion</p>


</template>

<script>
    export default {
        props: ['newReplyUrl'],
        data() {
            return {
                body: ""
            }
        },
        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },
        methods: {
            postReply() {
                axios.post(this.newReplyUrl, {
                    body: this.body
                }).then(({data}) => {
                    this.body = '';
                    this.$emit('added', data);
                })
            }
        }
    }
</script>