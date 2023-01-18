import { createApp } from "vue";
import AsyncPosts from "../../components/AsyncPosts.vue";
import {getRawDataFromScript, Post} from "../../lib";

const main = async () => {
/*    const jsonPosts = getRawDataFromScript('posts');
    const posts: Post[] = JSON.parse(jsonPosts);
    const app = createApp(Posts, {
        posts
    });
    console.log(posts)*/
    const app = createApp(AsyncPosts);
    return app.mount('#posts-container');
};

main().then(root => {
    console.log("Mounted:", root);
});
