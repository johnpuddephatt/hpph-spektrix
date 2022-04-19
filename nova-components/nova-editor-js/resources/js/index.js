// Import the Nova Editor class
import NovaEditorJS from "./nova-editor";

// Expose it for other plugins
window.NovaEditorJS = new NovaEditorJS();

// Import the blocks
require("./blocks/delimiter");
require("./blocks/embed");
require("./blocks/heading");
require("./blocks/image");
require("./blocks/inline-code");
require("./blocks/list");
require("./blocks/marker");
require("./blocks/paragraph");
require("./blocks/raw");
require("./blocks/table");

require("./blocks/test");

// Import the Nova field declaration
require("./field");
