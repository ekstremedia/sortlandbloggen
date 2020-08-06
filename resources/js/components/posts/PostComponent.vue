<template>
    <div v-if="parsed_post">
        <h3>{{ parsed_post.title }}</h3>
        Author: {{ parsed_post.author.name }}<br />
        Last updated:
        {{ parsed_post.updated_at | moment("dddd, MMMM Do YYYY HH:mm") }}
        <hr />
        <p>{{ parsed_post.post }}</p>
    </div>
</template>

<script>
export default {
    props: ["post_id", "post"],
    methods: {
        route: function() {
            // console.log(JSON.parse(this.post_var))
        }
    },
    computed: {
        parsed_post: function() {
            return JSON.parse(this.post);
        }
    },
    mounted() {
        this.route();
    }
};
</script>
