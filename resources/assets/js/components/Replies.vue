<template>
    <div>
        <div v-for="(item, index) in items" :key="item.id">
            <reply :reply="item" @deleted="remove(index)"></reply>
        </div>

        <paginator :dataSet="dataSet" @changed="fetch"></paginator>

        <p v-if="$parent.locked">
            Thread is locked. New replies are not allowed.
        </p>

        <new-reply :new-reply-url="endpoint" @added="add" v-else></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    import collection from '../mixins/collection';

    export default {
        components: { Reply, NewReply},
        mixins: [collection],
        data() {
            return {
                dataSet: false
            }
        },
        computed: {
            endpoint() {
                return location.pathname + '/replies';
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch(page) {
                return axios.get(this.url(page)).then(this.refresh);
            },
            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }

                return `${location.pathname}/replies?page=${page}`
            },
            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;

                window.scrollTo(0, 0);
            }
        }
    }
</script>