<template>

    <div class="create-reply" v-if="signedIn">
        <div class="form-group">
            <wysiwyg v-model="body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>
        </div>
        <button class="btn" @click="postReply">Post</button>
    </div>

    <p class="text-center" v-else>Please <a href="/login">sign in</a> to participate this discussion</p>
</template>

<script>
    import 'jquery.caret';
    import 'at.js';

    export default {
        props: ['newReplyUrl'],
        data() {
            return {
                body: "",
                completed: false
            }
        },
        mounted() {
            $('#body').atwho({
                at: "@",
                callbacks: {
                    remoteFilter: function(query, callback) {
                      $.getJSON("/api/users", {name: query}, function(data) {
                        callback(data)
                      });
                    }
                  }
            })
        },
        methods: {
            postReply() {
                axios.post(this.newReplyUrl, {
                    body: this.body
                }).
                catch(error => {
                    flash(error.response.data, 'danger');
                }).then(({data}) => {
                    this.body = '';
                    this.$emit('added', data);
                    this.completed = true;
                    flash("You added a new reply");
                })
            }
        }
    }


</script>