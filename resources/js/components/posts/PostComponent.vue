<template>
    <div v-if="parsed_post">
        <h3>{{ parsed_post.title }}</h3>
        <small class="text-muted">
            Author: {{ parsed_post.author.name }}<br />
            Last updated:
            {{ parsed_post.updated_at | moment("dddd, MMMM Do YYYY HH:mm") }}
        </small>
        <hr />
        <p>{{ parsed_post.post }}</p>
    </div>
</template>

<script>
export default {
    props: ["post_id", "post", "json_post"],
    methods: {
        route: function() {
            // console.log(JSON.parse(this.post_var))
        }
    },
    computed: {
        parsed_post: function() {
            if (this.json_post) {
                return JSON.parse(this.json_post);
            } else {
                return this.post;
            }
        }
    },
    mounted() {
        this.route();
    }
};
</script>
