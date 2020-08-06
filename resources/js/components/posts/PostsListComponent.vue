<template>
    <div>
        <div v-if="!posts" class="text-center">
            <div class="spinner-border text-success" role="status">
                <span class="sr-only">Loading posts...</span>
            </div>
            <h3>Loading posts</h3>
        </div>

        <!-- Delete modal -->

        <div
            class="modal fade"
            id="deleteModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="deleteModalLabel"
            aria-hidden="true"
        >
            <form v-on:submit.prevent="checkDeleteForm">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">
                                Delete post: <b>{{ delete_post.title }}</b
                                >?
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this post?
                            <hr />
                            <h4>
                                <i>{{ delete_post.title }}</i>
                            </h4>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-danger">
                                Yes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Delete modal end -->

        <!-- Post modal -->
        <div
            class="modal fade"
            id="editPost"
            tabindex="-1"
            role="dialog"
            aria-labelledby="editPostLabel"
            aria-hidden="true"
        >
            <form v-on:submit.prevent="checkForm">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPostLabel">
                                <span v-if="post_id"
                                    >Editing post (id: #{{ post_id }}):
                                    {{ title }}</span
                                >
                                <span v-else>
                                    New post
                                </span>
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-if="errors.length">
                                {{ errors.length }} error<span
                                    v-if="errors.length > 1"
                                    >s</span
                                >
                                in form:
                                <ul>
                                    <li
                                        v-for="(error, index) in errors"
                                        :key="index"
                                    >
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
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Close
                            </button>

                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Post modal end -->

        <div v-if="posts">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h3>Posts ({{ posts.length }})</h3>
                    <button
                        @click="newPost"
                        type="button"
                        class="btn btn-primary"
                    >
                        <i class="fas fa-plus"></i> New post
                    </button>
                </div>
                <div class="col-12 pt-1">
                    <table class="table table-striped table-hover">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Title</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(post, index) of posts" :key="index">
                                <td scope="row">
                                    <a :href="'post/' + post.id + '/' + post.slug">
                                        {{ post.title }}
                                    </a>
                                </td>
                                <td>
                                    {{
                                        post.created_at
                                            | moment(
                                                "dddd, MMMM Do YYYY HH:mm:ss"
                                            )
                                    }}
                                </td>
                                <td>
                                    {{
                                        post.updated_at
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
                                                @click="editPost(post)"
                                            >
                                                <i
                                                    class="fas fa-fw fa-edit"
                                                ></i>
                                                Edit
                                            </button>
                                            <div class="dropdown-divider"></div>

                                            <button
                                                class="dropdown-item"
                                                href="#"
                                                @click="deletePost(post)"
                                            >
                                                <i
                                                    class="far fa-fw text-danger fa-trash-alt"
                                                ></i>
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
            post_id: null,
            delete_post: {}
        };
    },
    methods: {
        async getPosts() {
            let response = await axios.get("getPosts");
            if (response.data) {
                // this.yrdata = response.data;
                this.posts = response.data;
            }
        },
        editPost(post) {
            console.log(post);
            this.post_id = post.id;
            this.title = post.title;
            this.post = post.post;
            this.showModal();
        },
        newPost() {
            this.resetForm();
            this.showModal();
        },
        submitPost(postObj) {
            axios
                .post("postSubmit", {
                    body: postObj
                })
                .then(response => {
                    console.log("Response: ", response);
                    console.log(
                        "Response.postStatus: ",
                        response.data.postStatus
                    );
                    if (response.data.postStatus == "success") {
                        // Post was successfully added.
                        // Reset form, hide modal, notify user and reseed posts variable from backend data.
                        this.resetForm();
                        this.hideModal();
                        this.posts = response.data.allPosts; // Reseed posts with updated array from backend.
                        let post = response.data.savedPost; // Make variable with the post that was just made or changed.
                        this.notice(
                            "success",
                            "Post saved",
                            `Your post <b>${post.title}</b> was saved.`
                        );
                    }
                    if (response.data.error) {
                        this.errors = response.data.error; // Display error messages from backend
                    }
                })
                .catch(e => {
                    this.errors.push(e); // Add catched error from backend to errors array
                });
        },
        submitDeletePost(postObj) {
            axios
                .post("deletePost", {
                    body: postObj
                })
                .then(response => {
                    console.log("Response: ", response);
                    if (response.data.deleteStatus == "success") {
                        // Post was successfully added.
                        // Reset form, hide modal, notify user and reseed posts variable from backend data.
                        this.hideDeleteModal();
                        this.posts = response.data.allPosts; // Reseed posts with updated array from backend.
                        let post = response.data.deletedPost; // Make variable with the post that was just made or changed.
                        this.notice(
                            "success",
                            "Post deleted",
                            `Your post <b>${post.title}</b> was deleted.`
                        );
                    }
                    if (response.data.deleteStatus == "error") {
                        this.hideDeleteModal();
                        this.posts = response.data.allPosts; // Reseed posts with updated array from backend. If post was somehow deleted elsewhere, it will be removed from displayed list.
                        this.notice(
                            "error",
                            "Post delete error",
                            `There was an error with deleting the post: ${response.data.errors}`
                        );
                    }
                })
                .catch(e => {
                    this.notice("error", "Delete error", e); // Display notification with error from backend
                });
        },
        notice(type, title, message) {
            this.$notice[type]({
                title: title,
                description: message
            });
        },
        resetForm() {
            (this.title = null),
                (this.post = null),
                (this.errors = []),
                (this.post_id = null);
        },
        checkForm: function(e) {
            e.preventDefault(); // prevent default form action

            this.errors = []; // make errors array empty

            // add errors to errors array if found
            if (!this.title) {
                this.errors.push("Title required.");
            }
            if (!this.post) {
                this.errors.push("Post required.");
            }
            // If form validation has errors
            if (this.errors.length) {
                let errorMessages = "";
                for (let error of this.errors) {
                    errorMessages += error + " ";
                }
                this.notice("error", "Errors in form", errorMessages);
            }

            // If form validation is ok
            if (!this.errors.length) {
                this.error = null;
                let postObj = {
                    post_id: this.post_id,
                    title: this.title,
                    post: this.post
                };
                this.submitPost(postObj);
            }
        },
        checkDeleteForm: function(e) {
            e.preventDefault(); // prevent default form action
            console.log(this.delete_post);
            this.submitDeletePost(this.delete_post);
        },
        showModal() {
            $("#editPost").modal("show");
        },
        hideModal() {
            $("#editPost").modal("hide");
        },
        hideDeleteModal() {
            $("#deleteModal").modal("hide");
        },
        deletePost(post) {
            this.delete_post = post;
            $("#deleteModal").modal("show");
        }
    },
    mounted() {
        this.getPosts();
    }
};
</script>
