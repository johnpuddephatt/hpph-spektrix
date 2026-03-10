/**
 * Card Block for Editor.js
 *
 * A block with name, description, image (uploaded via configurable endpoint), and URL fields.
 *
 * @example
 * // In your Editor.js config:
 * import CardTool from './card-plugin';
 *
 * const editor = new EditorJS({
 *   tools: {
 *     card: {
 *       class: CardTool,
 *       config: {
 *         endpoints: {
 *           byFile: 'https://your-api.com/upload/image',   // multipart/form-data upload
 *           byUrl:  'https://your-api.com/fetch/image',    // { url: '...' } JSON upload
 *         },
 *         field: 'image',           // form field name for the file (default: 'image')
 *         types: 'image/*',         // accepted MIME types (default: 'image/*')
 *         additionalRequestData: {  // extra data merged into every upload request (optional)
 *           token: 'abc123',
 *         },
 *         additionalRequestHeaders: { // extra headers on every upload request (optional)
 *           Authorization: 'Bearer ...',
 *         },
 *       },
 *     },
 *   },
 * });
 *
 * ---
 * Expected server response shape (same convention as @editorjs/image):
 * {
 *   "success": 1,
 *   "file": {
 *     "url": "https://cdn.example.com/image.jpg",
 *     // any extra fields you want stored (size, name, …)
 *   }
 * }
 */

class CardTool {
    // ---------------------------------------------------------------------------
    // Static metadata
    // ---------------------------------------------------------------------------

    static get toolbox() {
        return {
            title: "Card",
            icon: `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
        <line x1="8" y1="21" x2="16" y2="21"></line>
        <line x1="12" y1="17" x2="12" y2="21"></line>
      </svg>`,
        };
    }

    static get isReadOnlySupported() {
        return true;
    }

    static get enableLineBreaks() {
        return true;
    }

    static get sanitize() {
        return {
            name: { br: true },
            description: { br: true },
            url: {},
            image: {},
        };
    }

    // ---------------------------------------------------------------------------
    // Constructor
    // ---------------------------------------------------------------------------

    /**
     * @param {object}  params
     * @param {object}  params.data      – previously saved block data
     * @param {object}  params.config    – tool config from EditorJS setup
     * @param {object}  params.api       – EditorJS API
     * @param {boolean} params.readOnly  – read-only mode flag
     */
    constructor({ data, config, api, readOnly }) {
        console.log("CardTool config:", config); // Debug log to verify config is received correctly
        this.api = api;
        this.readOnly = readOnly;

        // Merge config with defaults
        this.config = {
            endpoints: {
                byFile: "",
                byUrl: "",
                ...((config && config.endpoints) || {}),
            },
            field: (config && config.field) || "image",
            types: (config && config.types) || "image/*",
            additionalRequestData:
                (config && config.additionalRequestData) || {},
            additionalRequestHeaders:
                (config && config.additionalRequestHeaders) || {},
        };

        // Block data
        this.data = {
            name: data.name || "",
            description: data.description || "",
            url: data.url || "",
            image: data.image || null, // { url, ...serverExtras }
        };

        // Internal state
        this._imageFile = null;
        this._nodes = {};
    }

    // ---------------------------------------------------------------------------
    // Rendering
    // ---------------------------------------------------------------------------

    render() {
        const root = this._make("div", [this._css.root]);

        // ── Image area ────────────────────────────────────────────────────────────
        const imageArea = this._make("div", [this._css.imageArea]);

        if (!this.readOnly) {
            const fileInput = this._make("input", [], {
                type: "file",
                accept: this.config.types,
                style: "display:none",
            });
            fileInput.addEventListener("change", (e) =>
                this._handleFileChange(e),
            );

            const urlInput = this._make("input", [this._css.urlInput], {
                type: "url",
                placeholder: "Paste image URL…",
            });

            const fetchBtn = this._make(
                "button",
                [this._css.btn, this._css.btnSecondary],
                {
                    type: "button",
                    textContent: "Fetch",
                    title: "Fetch image from URL",
                },
            );
            fetchBtn.addEventListener("click", () =>
                this._handleUrlFetch(urlInput.value),
            );

            const uploadBtn = this._make(
                "button",
                [this._css.btn, this._css.btnPrimary],
                {
                    type: "button",
                    textContent: "↑ Upload image",
                },
            );
            uploadBtn.addEventListener("click", () => fileInput.click());

            const urlRow = this._make("div", [this._css.urlRow]);
            urlRow.appendChild(urlInput);
            urlRow.appendChild(fetchBtn);

            this._nodes.fileInput = fileInput;
            this._nodes.uploadBtn = uploadBtn;
            this._nodes.urlInput = urlInput;
            this._nodes.fetchBtn = fetchBtn;
            this._nodes.urlRow = urlRow;

            imageArea.appendChild(fileInput);

            // Show controls only when no image loaded yet
            if (!this.data.image) {
                imageArea.appendChild(uploadBtn);
                imageArea.appendChild(urlRow);
            }
        }

        // Preview (shown whether image already saved or just uploaded)
        const preview = this._make("div", [this._css.preview]);
        if (this.data.image && this.data.image.url) {
            this._renderImagePreview(preview, this.data.image.url);
        }
        this._nodes.preview = preview;
        imageArea.appendChild(preview);

        // Loading spinner
        const spinner = this._make("div", [
            this._css.spinner,
            this._css.hidden,
        ]);
        spinner.innerHTML = `<div class="${this._css.spinnerInner}"></div>`;
        this._nodes.spinner = spinner;
        imageArea.appendChild(spinner);

        // Error message
        const error = this._make("div", [this._css.error, this._css.hidden]);
        this._nodes.error = error;
        imageArea.appendChild(error);

        root.appendChild(imageArea);

        // ── Text fields ───────────────────────────────────────────────────────────
        const fields = this._make("div", [this._css.fields]);

        const nameInput = this._makeField(
            "Name",
            "name",
            this.data.name,
            false,
        );
        const descInput = this._makeField(
            "Description",
            "description",
            this.data.description,
            true,
        );
        const urlField = this._makeField(
            "URL",
            "url",
            this.data.url,
            false,
            "https://example.com",
        );

        this._nodes.nameInput = nameInput;
        this._nodes.descInput = descInput;
        this._nodes.urlField = urlField;

        fields.appendChild(nameInput);
        fields.appendChild(descInput);
        fields.appendChild(urlField);

        root.appendChild(fields);
        this._nodes.root = root;

        return root;
    }

    // ---------------------------------------------------------------------------
    // Save
    // ---------------------------------------------------------------------------

    save() {
        return {
            name: this._nodes.nameInput
                ? this._nodes.nameInput.innerText.trim()
                : this.data.name,
            description: this._nodes.descInput
                ? this._nodes.descInput.innerText.trim()
                : this.data.description,
            url: this._nodes.urlField
                ? this._nodes.urlField.innerText.trim()
                : this.data.url,
            image: this.data.image || null,
        };
    }

    // ---------------------------------------------------------------------------
    // Validation
    // ---------------------------------------------------------------------------

    validate(data) {
        return data.name.trim().length > 0;
    }

    // ---------------------------------------------------------------------------
    // Image upload helpers
    // ---------------------------------------------------------------------------

    async _handleFileChange(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (!this.config.endpoints.byFile) {
            this._showError(
                "No upload endpoint configured (endpoints.byFile).",
            );
            return;
        }

        this._showSpinner();

        try {
            const formData = new FormData();
            formData.append(this.config.field, file);

            // Merge any additionalRequestData
            Object.entries(this.config.additionalRequestData).forEach(
                ([k, v]) => formData.append(k, v),
            );

            const response = await fetch(this.config.endpoints.byFile, {
                method: "POST",
                headers: { ...this.config.additionalRequestHeaders },
                body: formData,
            });

            const result = await response.json();
            this._handleUploadResponse(result);
        } catch (err) {
            this._showError("Upload failed: " + err.message);
        }
    }

    async _handleUrlFetch(url) {
        if (!url) return;

        if (!this.config.endpoints.byUrl) {
            // Fallback: treat the pasted URL as a direct image URL without server round-trip
            this._applyImage({ url });
            return;
        }

        this._showSpinner();

        try {
            const body = {
                url,
                ...this.config.additionalRequestData,
            };

            const response = await fetch(this.config.endpoints.byUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    ...this.config.additionalRequestHeaders,
                },
                body: JSON.stringify(body),
            });

            const result = await response.json();
            this._handleUploadResponse(result);
        } catch (err) {
            this._showError("Fetch failed: " + err.message);
        }
    }

    _handleUploadResponse(result) {
        if (result.success && result.file && result.file.url) {
            this._applyImage(result.file);
        } else {
            this._showError(
                "Server returned an error. Check the response format.",
            );
        }
    }

    _applyImage(imageData) {
        this.data.image = imageData;
        this._hideSpinner();
        this._hideError();
        this._renderImagePreview(this._nodes.preview, imageData.url);

        // Hide upload controls
        if (this._nodes.uploadBtn) this._nodes.uploadBtn.style.display = "none";
        if (this._nodes.urlRow) this._nodes.urlRow.style.display = "none";
    }

    _renderImagePreview(container, url) {
        container.innerHTML = "";
        const wrapper = this._make("div", [this._css.imgWrapper]);

        const img = this._make("img", [this._css.img], { src: url, alt: "" });
        img.addEventListener("load", () =>
            img.classList.add(this._css.imgLoaded),
        );

        if (!this.readOnly) {
            const removeBtn = this._make("button", [this._css.removeBtn], {
                type: "button",
                title: "Remove image",
                innerHTML: "×",
            });
            removeBtn.addEventListener("click", () => this._removeImage());
            wrapper.appendChild(removeBtn);
        }

        wrapper.appendChild(img);
        container.appendChild(wrapper);
    }

    _removeImage() {
        this.data.image = null;
        this._nodes.preview.innerHTML = "";
        if (this._nodes.uploadBtn) this._nodes.uploadBtn.style.display = "";
        if (this._nodes.urlRow) this._nodes.urlRow.style.display = "";
        if (this._nodes.fileInput) this._nodes.fileInput.value = "";
        if (this._nodes.urlInput) this._nodes.urlInput.value = "";
    }

    // ---------------------------------------------------------------------------
    // UI helpers
    // ---------------------------------------------------------------------------

    _showSpinner() {
        this._nodes.spinner.classList.remove(this._css.hidden);
        if (this._nodes.uploadBtn) this._nodes.uploadBtn.disabled = true;
        if (this._nodes.fetchBtn) this._nodes.fetchBtn.disabled = true;
    }

    _hideSpinner() {
        this._nodes.spinner.classList.add(this._css.hidden);
        if (this._nodes.uploadBtn) this._nodes.uploadBtn.disabled = false;
        if (this._nodes.fetchBtn) this._nodes.fetchBtn.disabled = false;
    }

    _showError(msg) {
        this._hideSpinner();
        this._nodes.error.textContent = msg;
        this._nodes.error.classList.remove(this._css.hidden);
    }

    _hideError() {
        this._nodes.error.classList.add(this._css.hidden);
        this._nodes.error.textContent = "";
    }

    _makeField(label, key, value, multiline, placeholder) {
        const wrapper = this._make("div", [this._css.fieldWrapper]);

        const lbl = this._make("label", [this._css.label], {
            textContent: label,
        });
        wrapper.appendChild(lbl);

        const el = this._make(
            multiline ? "div" : "div",
            [this._css.fieldInput],
            {
                contentEditable: this.readOnly ? "false" : "true",
                dataset: { placeholder: placeholder || label },
                innerHTML: value || "",
            },
        );

        if (this.readOnly) el.setAttribute("contenteditable", "false");

        wrapper.appendChild(el);
        return el; // Return the editable node so save() can read it
    }

    _make(tag, classes = [], attrs = {}) {
        const el = document.createElement(tag);
        if (classes.length) el.classList.add(...classes);
        Object.entries(attrs).forEach(([k, v]) => {
            if (k === "dataset") {
                Object.entries(v).forEach(([dk, dv]) => (el.dataset[dk] = dv));
            } else if (k === "innerHTML") {
                el.innerHTML = v;
            } else if (k === "textContent") {
                el.textContent = v;
            } else {
                el.setAttribute(k, v);
            }
        });
        return el;
    }

    // ---------------------------------------------------------------------------
    // CSS class names (BEM-style, scoped)
    // ---------------------------------------------------------------------------

    get _css() {
        return {
            root: "cdx-card",
            imageArea: "cdx-card__image-area",
            preview: "cdx-card__preview",
            imgWrapper: "cdx-card__img-wrapper",
            img: "cdx-card__img",
            imgLoaded: "cdx-card__img--loaded",
            removeBtn: "cdx-card__remove-btn",
            urlRow: "cdx-card__url-row",
            urlInput: "cdx-card__url-input",
            spinner: "cdx-card__spinner",
            spinnerInner: "cdx-card__spinner-inner",
            error: "cdx-card__error",
            fields: "cdx-card__fields",
            fieldWrapper: "cdx-card__field-wrapper",
            label: "cdx-card__label",
            fieldInput: "cdx-card__field-input",
            btn: "cdx-card__btn",
            btnPrimary: "cdx-card__btn--primary",
            btnSecondary: "cdx-card__btn--secondary",
            hidden: "cdx-card--hidden",
        };
    }
}

// Attach styles once when the module loads
CardTool._stylesInjected = false;

const _injectStyles = () => {
    if (CardTool._stylesInjected || typeof document === "undefined") return;
    CardTool._stylesInjected = true;

    const style = document.createElement("style");
    style.textContent = `
/* ── Card block root ─────────────────────────────────────────────────────── */
.cdx-card {
  border: 1px solid #e8e8eb;
  border-radius: 8px;
  overflow: hidden;
  font-family: inherit;
  background: #fff;
  transition: box-shadow 0.2s ease;
}
.cdx-card:focus-within {
  box-shadow: 0 0 0 2px #388ae5;
  border-color: #388ae5;
}

/* ── Image area ──────────────────────────────────────────────────────────── */
.cdx-card__image-area {
  background: #f7f8fa;
  border-bottom: 1px solid #e8e8eb;
  min-height: 56px;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 14px 14px 10px;
}

/* ── Image preview ───────────────────────────────────────────────────────── */
.cdx-card__preview {
  width: 100%;
}
.cdx-card__img-wrapper {
  position: relative;
  width: 100%;
}
.cdx-card__img {
  display: block;
  width: 100%;
  max-height: 260px;
  object-fit: cover;
  border-radius: 4px;
  opacity: 0;
  transition: opacity 0.3s ease;
}
.cdx-card__img--loaded {
  opacity: 1;
}
.cdx-card__remove-btn {
  position: absolute;
  top: 6px;
  right: 6px;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: rgba(0,0,0,0.55);
  color: #fff;
  font-size: 16px;
  line-height: 1;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.15s;
}
.cdx-card__img-wrapper:hover .cdx-card__remove-btn {
  opacity: 1;
}

/* ── URL row ─────────────────────────────────────────────────────────────── */
.cdx-card__url-row {
  display: flex;
  gap: 6px;
  width: 100%;
}
.cdx-card__url-input {
  flex: 1;
  padding: 6px 10px;
  border: 1px solid #d0d0d8;
  border-radius: 5px;
  font-size: 13px;
  outline: none;
  background: #fff;
  color: #333;
  min-width: 0;
}
.cdx-card__url-input:focus {
  border-color: #388ae5;
}

/* ── Buttons ─────────────────────────────────────────────────────────────── */
.cdx-card__btn {
  padding: 6px 14px;
  border-radius: 5px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  border: none;
  outline: none;
  white-space: nowrap;
  transition: background 0.15s, opacity 0.15s;
}
.cdx-card__btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
.cdx-card__btn--primary {
  background: #388ae5;
  color: #fff;
  width: 100%;
}
.cdx-card__btn--primary:hover:not(:disabled) {
  background: #2c78d4;
}
.cdx-card__btn--secondary {
  background: #e8e8eb;
  color: #333;
}
.cdx-card__btn--secondary:hover:not(:disabled) {
  background: #d8d8de;
}

/* ── Spinner ─────────────────────────────────────────────────────────────── */
.cdx-card__spinner {
  padding: 10px 0;
}
.cdx-card__spinner-inner {
  width: 24px;
  height: 24px;
  border: 3px solid #e8e8eb;
  border-top-color: #388ae5;
  border-radius: 50%;
  animation: cdx-card-spin 0.7s linear infinite;
}
@keyframes cdx-card-spin {
  to { transform: rotate(360deg); }
}

/* ── Error ───────────────────────────────────────────────────────────────── */
.cdx-card__error {
  color: #e05252;
  font-size: 12px;
  text-align: center;
  padding: 4px 0;
}

/* ── Fields ──────────────────────────────────────────────────────────────── */
.cdx-card__fields {
  padding: 12px 14px 14px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.cdx-card__field-wrapper {
  display: flex;
  flex-direction: column;
  gap: 3px;
}
.cdx-card__label {
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: #9b9bac;
  user-select: none;
}
.cdx-card__field-input {
  font-size: 14px;
  line-height: 1.5;
  color: #1a1a2e;
  outline: none;
  border-bottom: 1px solid transparent;
  padding-bottom: 2px;
  min-height: 1.5em;
  transition: border-color 0.15s;
  word-break: break-word;
}
.cdx-card__field-input:focus {
  border-bottom-color: #388ae5;
}
.cdx-card__field-input:empty::before {
  content: attr(data-placeholder);
  color: #b0b0bf;
  pointer-events: none;
}
[contenteditable="false"].cdx-card__field-input {
  cursor: default;
  border-bottom-color: transparent;
}

/* ── Utility ─────────────────────────────────────────────────────────────── */
.cdx-card--hidden {
  display: none !important;
}
  `;
    document.head.appendChild(style);
};

// Inject on import (browser environment)
if (typeof document !== "undefined") _injectStyles();

export default CardTool;
