export interface Post {
    title: string;
    body: string;
}

const MOCK_POSTS: Post[] = [
    { title: "Post One", body: "My first Post!" },
    { title: "Post Two", body: "My second Post!" },
];

export function getPosts(): Promise<Post[]> {
    return new Promise(resolve =>
        setTimeout(() => {
            resolve(MOCK_POSTS)
        }, 2000)
    );
}