import { createApp } from "vue";
import AsyncCompaniesComponent from "../../../../components/AsyncCompanies.vue";

const main = async () => {
    const app = createApp(AsyncCompaniesComponent);
    return app.mount("#async-companies-container")
};

main().then(app => {
    console.log("Mounted:", app);
});