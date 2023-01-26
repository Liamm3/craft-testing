import {VueElement} from "vue";

export interface Company {
    title: string,
    description?: string,
    latitude?: string,
    longitude?: string,
    postalCode?: string,
    city?: string,
    streetName?: string,
    streetNumber? :string
}

export interface Post {
    title: string;
    body: string;
    uri: string;
}

export interface AppContainer {
    selector: string,
    component: VueElement,
    props?: any
}

const snakeCaseToLowerCamelCase = (s: string): string =>
    s.replace(/-./g, x=>x[1].toUpperCase())


export const getRawDataFromScript = (attribute: string): string => {
    const element = document.querySelector(`script[data-${attribute}]`);
    if (element instanceof HTMLElement) {
        return element.dataset[snakeCaseToLowerCamelCase(attribute)];
    }
};