module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./nova-components/**/*.vue",
    ],
    theme: {
        container: {
            center: true,
        },
        extend: {},
    },
    plugins: [require("@tailwindcss/typography")],
};
