import {createApp, onMounted} from "vue";
import CompanyComponent from "../../../../components/Companies.vue";
import { getRawDataFromScript, Company  } from "../../../../lib";

const main = async () => {
    const companies: Company[] = JSON.parse(getRawDataFromScript("companies"));
    const app = createApp(CompanyComponent, {
        companies
    });
    return app.mount("#companies-container")
};

main().then(app => {
    console.log("Mounted:", app);
});