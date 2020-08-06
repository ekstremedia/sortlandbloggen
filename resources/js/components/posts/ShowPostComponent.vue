<template>
    <div>
        <div v-if="!posts" class="text-center">
            <div class="spinner-border text-success" role="status">
                <span class="sr-only">Loading posts...</span>
            </div>
            <h3>Loading posts</h3>
        </div>
        <div>
            <form v-on:submit.prevent="checkForm">
                <div v-if="errors.length">
                    <ul>
                        <li v-for="error in errors" :key="error">
                            {{ error }}
                        </li>
                    </ul>
                </div>
                <input
                    type="hidden"
                    name="post_id"
                    v-model="post_id"
                    value=""
                />
                <div class="form-group">
                    <label for="title">Title</label>
                    <input
                        type="text"
                        class="form-control"
                        name="title"
                        id="title"
                        v-model="title"
                        aria-describedby="helpId"
                        placeholder="Post title"
                    />
                    <small id="helpId" class="form-text text-muted"
                        >Title of your post</small
                    >
                </div>
                <div class="form-group">
                    <label for="post">Post</label>
                    <textarea
                        placeholder="Post body"
                        class="form-control"
                        name="post"
                        v-model="post"
                        id="post"
                        rows="3"
                    ></textarea>
                </div>
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    Close
                </button>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
        <div v-if="posts">
            <div class="row justify-content-center">
                <div class="col-8">
                    <h3>Posts</h3>
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-toggle="modal"
                        data-target="#edit"
                    >
                        <i class="fas fa-plus"></i> New post
                    </button>
                </div>
                <div class="col-8 pt-1">
                    <table class="table table-striped table-hover">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Title</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post of posts" :key="post.id">
                                <td scope="row">{{ post.title }}</td>
                                <td>
                                    {{
                                        post.created_at
                                            | moment(
                                                "dddd, MMMM Do YYYY HH:mm:ss"
                                            )
                                    }}
                                </td>
                                <td>
                                    <div class="dropdown open">
                                        <button
                                            class="btn btn-secondary dropdown-toggle float-right"
                                            type="button"
                                            id="triggerId"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                        >
                                            Action
                                        </button>
                                        <div
                                            class="dropdown-menu"
                                            aria-labelledby="triggerId"
                                        >
                                            <button
                                                class="dropdown-item"
                                                href="#"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="dropdown-item"
                                                href="#"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            errors: [],

            posts: null,
            title: null,
            post: null,
            post_id: null
        };
    },
    methods: {
        async getPosts() {
            let response = await axios.get("getPosts");
            if (response.data) {
                // this.yrdata = response.data;
                this.posts = response.data;
            }
            this.$notice["info"]({
                title: `Posts loaded`,
                description: `Successfully loaded ${this.posts.length} posts`
            });
        },
        notice(type, title, message) {
            this.$notice[type]({
                title: title,
                description: message
            });
        },
        checkForm: function(e) {
            if (this.name && this.age) {
                return true;
            }

            this.errors = [];

            if (!this.title) {
                this.errors.push("Title required.");
            }
            if (!this.post) {
                this.errors.push("Post required.");
            }

            if (this.errors.length) {
                let errorMessages = "";
                for (let error of this.errors) {
                    errorMessages += error+' ';
                }
                this.notice("error", "Errors in form", errorMessages);
                
            }

            if (!this.errors.length) {
                this.notice("success", "Suksess", "Alt stemmer");
                return true;
            }
            e.preventDefault();
        }
    },
    mounted() {
        this.getPosts();
    }
};
</script>
