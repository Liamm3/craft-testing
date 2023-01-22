import { createApp } from "@vue-dist";
import CompanyList from "@js/components/CompanyList.ts"
import { PulseLoader } from "vue-spinner/dist/vue-spinner"

const app = createApp({
    data() {
        return {
            companies: [],
            loading: true
        }
    },
    components: {
        CompanyList,
        PulseLoader
    },
    async mounted() {
        const response = await fetch("/actions/site-module/company/");
        this.companies = await response.json();
        this.loading = false;
    }
});

app.config.compilerOptions.delimiters = ['#{', '}'];
app.mount("#async-companies-container");
