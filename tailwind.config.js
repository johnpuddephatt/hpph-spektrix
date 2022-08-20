const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "tailwind.safelist.txt",
    ],
    plugins: [require("tailwind-scrollbar-hide")],
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
        letterSpacing: {
            normal: "-0.015em",
        },
        colors: {
            current: "currentColor",

            transparent: {
                DEFAULT: "#00000000",
            },
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
                DEFAULT: "#ffe621",
                dark: "#f9da5d",
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
