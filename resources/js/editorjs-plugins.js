import Carousel from "editorjs-carousel";
// // import Carousel from "@vtchinh/gallery-editorjs";
import BlockWidthTune from "editorjs-block-width-tune";
import Quote from "@editorjs/quote";
import ToggleBlock from "editorjs-toggle-block";
import DetailsSummaryBlock from "editorjs-detailssummary";
import ImageTool from "@editorjs/image";
import AttachesBlock from "@editorjs/attaches";

NovaEditorJS.booting(function (editorConfig, fieldConfig) {
    // REMOVE THIS
    // AND RE-ENABLE IMAGE IN CONFIG TO REVERT
    editorConfig.tools.image = {
        class: ImageTool,
        config: {
            endpoints: {
                byFile: fieldConfig.uploadImageByFileEndpoint,
                byUrl: fieldConfig.uploadImageByUrlEndpoint,
            },
            additionalRequestHeaders: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        },
    };
    if (fieldConfig.toolSettings.attaches.activated === true) {
        editorConfig.tools.attaches = {
            class: AttachesBlock,
            inlineToolbar: fieldConfig.toolSettings.attaches.inlineToolbar,
            shortcut: fieldConfig.toolSettings.attaches.shortcut,
            config: {
                endpoint: fieldConfig.toolSettings.attaches.uploadFileEndpoint,
                additionalRequestHeaders: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            },
        };
    }
    if (fieldConfig.toolSettings.detailssummary.activated === true) {
        editorConfig.tools.detailssummary = {
            class: DetailsSummaryBlock,
            inlineToolbar:
                fieldConfig.toolSettings.detailssummary.inlineToolbar,
            shortcut: fieldConfig.toolSettings.detailssummary.shortcut,
        };
    }
    if (fieldConfig.toolSettings.toggle.activated === true) {
        editorConfig.tools.toggle = {
            class: ToggleBlock,
            shortcut: fieldConfig.toolSettings.quote.shortcut,
        };
    }
    if (fieldConfig.toolSettings.quote.activated === true) {
        editorConfig.tools.quote = {
            class: Quote,
            shortcut: fieldConfig.toolSettings.quote.shortcut,
        };
    }

    if (fieldConfig.toolSettings.carousel.activated === true) {
        editorConfig.tools.carousel = {
            class: Carousel,
            shortcut: fieldConfig.toolSettings.carousel.shortcut,
            toolbox: {
                icon: "<svg xmlns='http://www.w3.org/2000/svg' width='12' height='9.55' viewBox='0 0 12 9.55'><path d='M10 6.82a1.13 1.13 0 001.1 1.17h.9V4.75l-2 1.28zm-3.54.17l-1.37-1-1.81 1-2.6-2.33-.68.43v2.9h5.37a1.13 1.13 0 001.09-1z' opacity='.19'/><path d='M7.92 6.82V2.73A2.65 2.65 0 005.37 0H0v1.56h5.37a1.14 1.14 0 011.1 1.17V5.2L5.12 4.14l-1.82 1L.71 2.67l-.71.5v1.92l.68-.43 2.6 2.31 1.81-1 1.37 1a1.13 1.13 0 01-1.09 1H0v1.56h5.37a2.64 2.64 0 002.55-2.71zm.63-4.09v4.09a2.64 2.64 0 002.55 2.73h.9V7.99h-.9A1.13 1.13 0 0110 6.82v-.79l2-1.28v-2L10 4.2V2.73a1.14 1.14 0 011.1-1.17h.9V0h-.9a2.65 2.65 0 00-2.55 2.73z'/</svg>",
                title: "Gallery",
            },
            config: {
                additionalRequestHeaders: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                endpoints: {
                    byFile: fieldConfig.uploadImageByFileEndpoint,
                },
            },
        };
    }
    if (fieldConfig.toolSettings.blockWidthTune.activated === true) {
        editorConfig.tools.blockWidthTune = {
            class: BlockWidthTune,
            shortcut: fieldConfig.toolSettings.blockWidthTune.shortcut,
        };
        editorConfig.tools.image.tunes = ["blockWidthTune"];
        editorConfig.tools.carousel.tunes = ["blockWidthTune"];
        editorConfig.tools.quote.tunes = ["blockWidthTune"];
        editorConfig.tools.embed.tunes = ["blockWidthTune"];
        editorConfig.tools.raw.tunes = ["blockWidthTune"];
        editorConfig.tools.header.toolbox = [
            {
                icon: "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path d='M15.8 2.5h3.8v19.1h-3.8V14H8.2v7.6H4.4V2.5h3.8v7.6h7.6V2.5z' stroke='#000' stroke-width='.75' stroke-miterlimit='10'/></svg>",
                title: "Heading",
                data: {
                    level: 2,
                },
            },
            {
                icon: "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path d='M14.6 5.6h2.6v12.9h-2.6v-5.2H9.4v5.2H6.8V5.6h2.6v5.2h5.2V5.6z'/></svg>", // icon for H3,
                title: "Subheading",
                data: {
                    level: 3,
                },
            },
        ];
    }
});
