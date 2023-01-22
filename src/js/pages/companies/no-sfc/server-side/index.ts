import { createApp } from "@vue-dist";
import CompanyList from "@js/components/CompanyList.ts"

const app = createApp({
    components: {
        CompanyList
    },
});

app.config.compilerOptions.delimiters = ['#{', '}'];
app.mount("#companies-container");
