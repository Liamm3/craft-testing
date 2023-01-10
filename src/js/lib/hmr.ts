export default function initHmr() {
     if (import.meta.hot) {
        import.meta.hot.accept(() => {
            console.log("HMR");
        });
    }
}
