const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        container: {
            screens: { mobile: "1440px", tablet: "1440px", desktop: "1440px" },
        },
        fontFamily: {
            sans: ['"Basis Grotesque"', ...defaultTheme.fontFamily.sans],
            mono: [
                '"Basis Grotesque Mono"',
                "mono",
                ...defaultTheme.fontFamily.sans,
            ],
        },
        colors: {
            white: {
                DEFAULT: "#FFFFFF",
            },

            black: {
                DEFAULT: "#000000",
            },
            gray: {
                DEFAULT: "#ededed",
                light: "#b5b5b5",
                medium: "#6f6f6f",
                dark: "#393939",
            },

            yellow: {
                DEFAULT: "#ffe622",
            },

            sand: {
                DEFAULT: "#e6e4dd",
            },

            orange: {
                DEFAULT: "#f2b062",
            },

            pink: {
                DEFAULT: "#f4b8f3",
            },
        },
        extend: {
            maxWidth: {
                "8xl": "90rem",
            },
        },
    },
};
