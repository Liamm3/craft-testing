import { createApp } from "vue";
import AsyncPosts from "../../components/AsyncPosts.vue";
import Posts from "../../components/Posts.vue";
import {getRawDataFromScript, Post, AppContainer} from "../../lib";

const main = async () => {
    const jsonPosts = getRawDataFromScript('posts');
    const posts: Post[] = JSON.parse(jsonPosts);
    const app = createApp(Posts, {
        posts
    });
    return app.mount("#posts-container");
};

main().then(root => {
    console.log("Mounted:", root);
});
