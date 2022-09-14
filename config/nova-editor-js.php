<?php

return [
    /**
     * Editor settings
     */
    "editorSettings" => [
        "placeholder" => "Start typing something...",
        "defaultBlock" => "paragraph",
        "autofocus" => false,
    ],

    /**
     * Configure tools
     */
    "toolSettings" => [
        "blockWidthTune" => [
            "activated" => true,
        ],
        "header" => [
            "package" => "@editorjs/header",
            "activated" => true,
            "placeholder" => "Heading",
            "shortcut" => "CMD+SHIFT+H",
        ],
        "list" => [
            "package" => "@editorjs/list",
            "activated" => true,
            "inlineToolbar" => true,
            "shortcut" => "CMD+SHIFT+L",
        ],
        "detailssummary" => [
            "activated" => true,
            "inlineToolbar" => true,
            "shortcut" => "CMD+SHIFT+>",
        ],
        "carousel" => [
            "activated" => true,
            "shortcut" => "CMD+SHIFT+C",
        ],
        "attaches" => [
            "activated" => true,
            "shortcut" => "CMD+SHIFT+A",
            "uploadFileEndpoint" => "/file-upload",
        ],
        "toggle" => [
            "activated" => false,
            "inlineToolbar" => true,
        ],
        "quote" => [
            "activated" => true,
            "inlineToolbar" => true,
            "shortcut" => "CMD+SHIFT+Q",
        ],
        "code" => [
            "activated" => false,
            "placeholder" => "",
            "shortcut" => "CMD+SHIFT+C",
        ],
        "link" => [
            "activated" => true,
            "shortcut" => "CMD+SHIFT+L",
        ],
        "image" => [
            "activated" => false,
            "shortcut" => "CMD+SHIFT+I",
            "path" => "public/images",
            "disk" => "local",
            "alterations" => [
                "resize" => [
                    "width" => false, // integer
                    "height" => false, // integer
                ],
                "optimize" => true, // true or false
            ],
            "thumbnails" => [
                // Specify as many thumbnails as required. Key is used as the name.
                "_small" => [
                    "resize" => [
                        "width" => 250, // integer
                        "height" => 250, // integer
                    ],
                    "optimize" => true, // true or false
                ],
            ],
        ],
        "inlineCode" => [
            "activated" => false,
            "shortcut" => "CMD+SHIFT+A",
        ],
        "checklist" => [
            "activated" => false,
            "inlineToolbar" => true,
            "shortcut" => "CMD+SHIFT+J",
        ],
        "marker" => [
            "activated" => false,
            "shortcut" => "CMD+SHIFT+M",
        ],
        "delimiter" => [
            "activated" => false,
        ],
        "table" => [
            "activated" => true,
            "inlineToolbar" => true,
        ],
        "raw" => [
            "activated" => true,
            "placeholder" => "",
        ],
        "embed" => [
            "activated" => true,
            "inlineToolbar" => true,
            "services" => [
                "codepen" => true,
                "imgur" => false,
                "vimeo" => true,
                "youtube" => true,
            ],
        ],
    ],

    /**
     * Output validation config
     * https://github.com/editor-js/editorjs-php
     */
    "validationSettings" => [
        "tools" => [
            "attaches" => [
                "title" => [
                    "type" => "string",
                ],
                "file" => [
                    "type" => "array",
                    "data" => [
                        "title" => [
                            "type" => "string",
                        ],
                        "url" => [
                            "type" => "string",
                        ],
                        "name" => [
                            "type" => "string",
                        ],
                        "size" => [
                            "type" => "integer",
                        ],
                    ],
                ],
            ],
            "carousel" => [
                "type" => "array",
                "data" => [
                    "url" => [
                        "type" => "string",
                    ],
                    "caption" => [
                        "type" => "string",
                    ],
                ],
            ],
            "header" => [
                "text" => [
                    "type" => "string",
                ],
                "level" => [
                    "type" => "int",
                    "canBeOnly" => [1, 2, 3, 4, 5],
                ],
            ],
            "detailssummary" => [
                "summary" => [
                    "type" => "string",
                    "allowedTags" => "i,b,u,a[href]",
                ],
                "details" => [
                    "type" => "string",
                    "allowedTags" => "i,b,u,a[href]",
                ],
            ],
            "paragraph" => [
                "text" => [
                    "type" => "string",
                    "allowedTags" =>
                        "i,b,u,a[href],span[class],code[class],mark[class]",
                ],
            ],
            "list" => [
                "style" => [
                    "type" => "string",
                    "canBeOnly" => [
                        0 => "ordered",
                        1 => "unordered",
                    ],
                ],
                "items" => [
                    "type" => "array",
                    "data" => [
                        "-" => [
                            "type" => "string",
                            "allowedTags" => "i,b,u",
                        ],
                    ],
                ],
            ],
            "image" => [
                "file" => [
                    "type" => "array",
                    "data" => [
                        "url" => [
                            "type" => "string",
                        ],
                        "thumbnails" => [
                            "type" => "array",
                            "required" => false,
                            "data" => [
                                "-" => [
                                    "type" => "string",
                                ],
                            ],
                        ],
                    ],
                ],
                "caption" => [
                    "type" => "string",
                ],
                "withBorder" => [
                    "type" => "boolean",
                ],
                "withBackground" => [
                    "type" => "boolean",
                ],
                "stretched" => [
                    "type" => "boolean",
                ],
            ],
            "code" => [
                "code" => [
                    "type" => "string",
                ],
            ],
            "quote" => [
                "text" => [
                    "type" => "string",
                ],
                "caption" => [
                    "type" => "string",
                    "allowedTags" => "br",
                ],
                "alignment" => [
                    "type" => "string",
                ],
            ],
            "linkTool" => [
                "link" => [
                    "type" => "string",
                ],
                "meta" => [
                    "type" => "array",
                    "data" => [
                        "title" => [
                            "type" => "string",
                        ],
                        "description" => [
                            "type" => "string",
                        ],
                        "image" => [
                            "type" => "array",
                            "data" => [
                                "url" => [
                                    "type" => "string",
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            "checklist" => [
                "items" => [
                    "type" => "array",
                    "data" => [
                        "-" => [
                            "type" => "array",
                            "data" => [
                                "text" => [
                                    "type" => "string",
                                    "required" => false,
                                ],
                                "checked" => [
                                    "type" => "boolean",
                                    "required" => false,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            "delimiter" => [],
            "table" => [
                "withHeadings" => [
                    "type" => "boolean",
                    "required" => false,
                ],
                "content" => [
                    "type" => "array",
                    "data" => [
                        "-" => [
                            "type" => "array",
                            "data" => [
                                "-" => [
                                    "type" => "string",
                                    "allowedTags" =>
                                        "i,b,u,a[href],span[class],code[class],mark[class]",
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            "raw" => [
                "html" => [
                    "type" => "string",
                    "allowedTags" => "*",
                ],
            ],
            "embed" => [
                "service" => [
                    "type" => "string",
                ],
                "source" => [
                    "type" => "string",
                ],
                "embed" => [
                    "type" => "string",
                ],
                "width" => [
                    "type" => "int",
                ],
                "height" => [
                    "type" => "int",
                ],
                "caption" => [
                    "type" => "string",
                    "required" => false,
                ],
            ],
        ],
    ],
];
