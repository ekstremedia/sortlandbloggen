<template>
    <div class="card">
        <div class="card-body" v-if="post">
            <h3>
                <a
                    v-if="title_link"
                    :href="
                        this.appBaseUrl +
                            '/post/' +
                            computed_post.id +
                            '/' +
                            computed_post.slug
                    "
                >
                    {{ computed_post.title }}
                </a>
                <span v-if="!title_link">{{ computed_post.title }}</span>
            </h3>
            <small class="text-muted">
                Author: {{ computed_post.author.name }} -
                {{ computed_post.created_at | moment("MMMM Do YYYY") }}
                <i class="far fa-clock"></i>
                {{ computed_post.created_at | moment("HH:mm") }}
            </small>
            <hr />
            <p class="pre-formatted">{{ computed_post.post }}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        post: Object,
        title_link: Boolean
    },
    computed: {
        computed_post() {
            // Computing the post model will update it for the modal if it changes
            return this.post;
        }
    }
};
</script>