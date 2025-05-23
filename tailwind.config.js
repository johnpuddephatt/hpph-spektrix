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
            screens: { mobile: "9999px", tablet: "9999px", desktop: "9999px" },
        },
        fontFamily: {
            sans: ["BasisGrotesque", ...defaultTheme.fontFamily.sans],
            mono: [
                "BasisGrotesqueMono",
                "mono",
                ...defaultTheme.fontFamily.sans,
            ],
        },
        borderRadius: {
            none: "0",
            DEFAULT: "5px",
            full: "9999px",
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
                light: "#1D1D1D",
                DEFAULT: "#000000",
            },

            gray: {
                DEFAULT: "#ededed",
                light: "#b5b5b5",
                medium: "#6f6f6f",
                dark: "#393939",
            },

            yellow: {
                DEFAULT: "#FFDA3D",
                dark: "#f4cf48",
            },

            sand: {
                light: "#F8F7EF",
                DEFAULT: "#e6e4dd",
                dark: "#d6d4cd",
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
