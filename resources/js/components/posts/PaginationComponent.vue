<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div
                    v-if="
                        laravelData &&
                            laravelData.data &&
                            laravelData.data.length == 0
                    "
                    class="text-center"
                >
                    There are no posts, yet
                </div>
                <post-component
                    class="mb-2"
                    v-for="post in laravelData.data"
                    :key="post.id"
                    :title_link="true"
                    :post="post"
                ></post-component>
            </div>
            <div class="col-12">
                <pagination
                    :limit="1"
                    :align="'center'"
                    :data="laravelData"
                    @pagination-change-page="getResults"
                    size="small"
                ></pagination>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            // Our data object that holds the Laravel paginator data
            laravelData: {}
        };
    },
    mounted() {
        // Fetch initial results
        this.getResults();
    },
    methods: {
        // Our method to GET results from a Laravel endpoint
        getResults(page = 1) {
            axios.get("paginationResults?page=" + page).then(response => {
                this.laravelData = response.data;
            });
        }
    }
};
</script>
