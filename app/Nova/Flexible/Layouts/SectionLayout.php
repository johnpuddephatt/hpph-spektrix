<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Spatie\MediaLibrary\HasMedia;

use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;

class SectionLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "sectionlayout";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "SectionLayout";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Images::make("Banner"),
            Text::make("Title"),
            NovaEditorJsField::make("Content", "section_content")->tools([
                "blockWidthTune" => [
                    "activated" => false,
                ],
                "attaches" => [
                    "activated" => true,
                    "shortcut" => "CMD+SHIFT+A",
                    "uploadFileEndpoint" => "/file-upload",
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
                    "activated" => false,
                    "shortcut" => "CMD+SHIFT+C",
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
            ]),
        ];
    }
}
