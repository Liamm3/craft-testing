export interface Post {
    title: string;
    body: string;
    uri: string;
}

const snakeCaseToLowerCamelCase = (s: string): string =>
    s.replace(/-./g, x=>x[1].toUpperCase())

export const getRawDataFromScript = (attribute: string): string => {
    const element = document.querySelector(`script[data-${attribute}]`);
    if (element instanceof HTMLElement) {
        return element.dataset[snakeCaseToLowerCamelCase(attribute)];
    }
};