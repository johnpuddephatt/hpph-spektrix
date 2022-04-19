let mix = require("laravel-mix");

mix.setPublicPath("dist")
    .js("resources/js/index.js", "js/field.js")
    .postCss("resources/css/app.css", "css/field.css", [require("tailwindcss")])
    .vue({ version: 3 })
    // .sass('resources/sass/field.scss', 'css')
    .webpackConfig({
        module: {
            exprContextCritical: false,
        },
        externals: {
            vue: "Vue",
        },
        output: {
            uniqueName: "advoor/nova-editor-js",
        },
    });
