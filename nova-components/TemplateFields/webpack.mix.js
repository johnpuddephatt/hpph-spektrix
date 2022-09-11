let mix = require("laravel-mix");

require("./nova.mix");

mix.setPublicPath("dist")
    .postCss("resources/banner/css/field.css", "banner/field.css", [
        require("tailwindcss"),
    ])
    .postCss("resources/basic-header/css/field.css", "basic-header/field.css", [
        require("tailwindcss"),
    ])
    .postCss("resources/heading/css/field.css", "heading/field.css", [
        require("tailwindcss"),
    ])
    .js("resources/banner/js/field.js", "banner")
    .js("resources/basic-header/js/field.js", "basic-header")
    .js("resources/heading/js/field.js", "heading")
    .vue({ version: 3 })
    .nova("hpph/test-field")
    .override((webpackConfig) => {
        webpackConfig.resolve.modules = [
            "node_modules",
            __dirname + "/vendor/spatie/laravel-medialibrary-pro/resources/js",
        ];
    });
