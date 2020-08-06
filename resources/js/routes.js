import ViewPostComponent from "./components/posts/ViewPostComponent";

export default [
    {
        path: "/post/:id/:slug",
        name: "post",
        component: ViewPostComponent
    }
];