import {createApp} from "vue";
import AsyncPosts from "../../components/AsyncPosts.vue";

const main = async () => {
    const app = createApp(AsyncPosts);
    return app.mount('#async-posts-container');
};

main().then(app => {
    console.log("Mounted:", app);
});