<template>
    <nav aria-label="Page navigation example" v-if="shouldPaginate">
      <ul class="pagination">
        <li class="page-item" v-if="prev_page">
          <a class="page-link" href="#" aria-label="Previous" @click.prevent="page--">
            <span aria-hidden="true">&laquo; Previous</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item" v-if="next_page">
          <a class="page-link" href="#" aria-label="Next" @click.prevent="page++">
            <span aria-hidden="true">Next &raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>
    </nav>
</template>

<script>
    export default {
        props: ['dataSet'],
        data() {
            return {
                page: 1,
                prev_page: false,
                next_page: false
            }
        },
        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prev_page = this.dataSet.prev_page_url;
                this.next_page = this.dataSet.next_page_url;
            },
            page() {
                this.broadcast().updateUrl();
            }
        },
        computed: {
           shouldPaginate() {
               return !! this.prev_page || !! this.next_page
           }
        },
        methods: {
            broadcast() {
                return this.$emit('changed', this.page);
            },
            updateUrl() {
                history.pushState(null, null, "?page=" + this.page)
            }
        }
    }
</script>