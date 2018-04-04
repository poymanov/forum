<template>
    <div class="page-header mb-4">
        <h1>
            {{ user.name }}
            <small v-text="reputation"></small>
        </h1>
        <img :src="avatar" width="50" height="50">

        <form v-if="canUpdate" method="post" enctype="multipart/form-data">
            <image-upload name="avatar" class="mr-1" @loaded="onLoad"></image-upload>
            <button class="btn btn-primary" type="submit">Add avatar</button>
        </form>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';

    export default {
        props: ['user'],
        components: { ImageUpload },
        data() {
            return {
                avatar: this.user.avatar_path
            }
        },
        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id)
            },
            reputation() {
                return this.user.reputation + " XP";
            }
        },
        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;
                this.persist(avatar.file);
            },
            persist(avatar) {
                let data = new FormData();

                data.append('image', avatar);

                axios.post(`/users/${this.user.name}/avatar`, data).
                    then(() => flash('Avatar uploaded!'));
            }
        }
    }
</script>