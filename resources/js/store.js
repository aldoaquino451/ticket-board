import { reactive, watch } from "vue";

export const store = reactive({
    currentTheme: window.matchMedia("(prefers-color-scheme: dark)").matches
        ? "dark"
        : "light",

    setTheme(theme) {
        this.currentTheme = theme;

        localStorage.setItem("theme", theme);
        if (theme === "dark") {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    },

    toggleTheme() {
        document.documentElement.classList.toggle("dark");

        if (document.documentElement.classList.contains("dark")) {
            this.currentTheme = "dark";
        } else {
            this.currentTheme = "light";
        }
    },
});

watch(
    () => store.currentTheme,
    (currentTheme) => {
        if (currentTheme === "dark") {
            document.documentElement.classList.add("dark");
            currentTheme = "dark";
        } else {
            document.documentElement.classList.remove("dark");
            currentTheme = "light";
        }
    },
    { immediate: true }
);

store.setTheme(store.currentTheme);

const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
mediaQuery.addEventListener("change", (e) => {
    store.currentTheme = e.matches ? "dark" : "light";
});
