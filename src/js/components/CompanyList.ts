export default {
    name:  "company-list",
    props: ['companies'],
    template: `
      <div>
          <ul v-for="company in companies">
            <li>#{ company.title }</li>
          </ul> 
      </div>
    `
};