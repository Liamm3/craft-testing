import Hello from "../components/Hello.vue";
import { createApp } from "vue";

const main = async () => {
    const app = createApp(Hello, {
        title: ":)"
    });
    return app.mount('#component-container');
};

main().then(root => {
    console.log("Mounted:", root);
});