<template>
    <div class="card">
        <div class="card-body" v-if="post">
            <h3>
                <a
                    v-if="title_link"
                    :href="
                        this.appBaseUrl +
                            '/post/' +
                            parsed_post.id +
                            '/' +
                            parsed_post.slug
                    "
                >
                    {{ parsed_post.title }}
                </a>
                <span v-if="!title_link">{{ parsed_post.title }}</span>
            </h3>
            <small class="text-muted">
                Author: {{ parsed_post.author.name }} -
                {{ parsed_post.created_at | moment("MMMM Do YYYY") }}
                <i class="far fa-clock"></i>
                {{ parsed_post.created_at | moment("HH:mm") }}
            </small>
            <hr />
            <p class="pre-formatted">{{ parsed_post.post }}</p>
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
        parsed_post() {
            return this.post;
        }
    }
};
</script>