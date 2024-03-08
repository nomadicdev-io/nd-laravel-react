var PGSADMIN = (function () {
    var _self = this,
        galleryUploaders = [],
        uploaders = [];
    _self.configs = {
        newCKConfig: {
            plugins: [
                "Alignment",
                "Autoformat",
                "AutoImage",
                // "AutoLink",
                "BlockQuote",
                // "BlockImage",
                "Bold",
                // "CloudServices",
                "Code",
                // "CodeBlock",
                "Essentials",
                // "ExportPdf",
                // "ExportWord",
                // "FindAndReplace",
                // "Font",
                // "GeneralHtmlSupport",
                "Heading",
                "HorizontalLine",
                "HtmlEmbed",
                "Image",
                "ImageCaption",
                // "ImageInsert",
                // "ImageResize",
                "ImageStyle",
                "ImageToolbar",
                "ImageUpload",
                // "Base64UploadAdapter",
                // "ImportWord",
                "Indent",
                "IndentBlock",
                "Italic",
                "Link",
                // "LinkImage",
                "List",
                // "ListProperties",
                "MediaEmbed",
                // "Mention",
                "PageBreak",
                "Paragraph",
                "PasteFromOffice",
                // "PictureEditing",
                // "RemoveFormat",
                "SourceEditing",
                "Strikethrough",
                // "Style",
                "Subscript",
                "Superscript",
                "Table",
                // "TableCaption",
                "TableCellProperties",
                // "TableColumnResize",
                // "TableProperties",
                "TableToolbar",
                // "TextPartLanguage",
                // "TextTransformation",
                // "TodoList",
                // "Underline",
                // "UploadAdapter"
            ],
            language: "en",
            toolbar: {
                shouldNotGroupWhenFull: true,
                items: [
                    // --- Document-wide tools ----------------------------------------------------------------------
                    "undo",
                    "redo",
                    "|",
                    "sourceEditing",
                    "|",
                    "importWord",
                    "exportWord",
                    "exportPdf",
                    "|",
                    "findAndReplace",
                    "selectAll",
                    "wproofreader",
                    "|",

                    // --- "Insertables" ----------------------------------------------------------------------------
                    "link",
                    "insertImage",
                    /* You must provide a valid token URL in order to use the CKBox application.
						After registering to CKBox, the fastest way to try out CKBox is to use the development token endpoint:
						https://ckeditor.com/docs/ckbox/latest/guides/configuration/authentication.html#token-endpoint*/
                    // 'ckbox',
                    "insertTable",
                    "blockQuote",
                    "mediaEmbed",
                    "codeBlock",
                    // "htmlEmbed",
                    "pageBreak",
                    "horizontalLine",
                    "-",

                    // --- Block-level formatting -------------------------------------------------------------------
                    "heading",
                    "style",
                    "|",

                    // --- Basic styles, font and inline formatting -------------------------------------------------------
                    "bold",
                    "italic",
                    "underline",
                    "strikethrough",
                    "superscript",
                    "subscript",
                    {
                        label: "Basic styles",
                        icon: "text",
                        items: [
                            "fontSize",
                            "fontFamily",
                            "fontColor",
                            "fontBackgroundColor",
                            "code",
                            "|",
                            "textPartLanguage",
                            "|",
                        ],
                    },
                    "removeFormat",
                    "|",

                    // --- Text alignment ---------------------------------------------------------------------------
                    "alignment",
                    "|",

                    // --- Lists and indentation --------------------------------------------------------------------
                    "bulletedList",
                    "numberedList",
                    "todoList",
                    "|",
                    "outdent",
                    "indent",
                ],
            },
            myOembedTagsimage: {
                schema: "image",
                re: /(.*\.(?:png|jpg|gif|webp|svg))/i,
                url: function (a) {
                    var b =
                        PGSADMIN.configs.newCKConfig.myOembedTagsimage.re.exec(
                            a
                        );
                    return b && 2 == b.length ? "" + b[1] : null;
                },
            },
            myOembedTagsvideo: {
                schema: "video",
                re: /(.*\.(?:mp4))/i,
                url: function (a) {
                    var b =
                        PGSADMIN.configs.newCKConfig.myOembedTagsvideo.re.exec(
                            a
                        );
                    return b && 2 == b.length ? "" + b[1] : null;
                },
            },
            mediaEmbed: {
                previewsInData: true,
                extraProviders: [
                    {
                        name: "extraProvider",
                        url: /^(.*)/,
                        html: function (match) {
                            var _imageURL =
                                PGSADMIN.configs.newCKConfig.myOembedTagsimage.url(
                                    match[1]
                                );
                            var _str = "";
                            console.log(_imageURL);
                            if (_imageURL != null) {
                                _str =
                                    "<div class='imgWrap '><img style='max-width:330px;' src='" +
                                    match[1] +
                                    "' /></div>";
                            } else {
                                _str =
                                    "<div class='imgWrap '><video style='max-width:330px;' playsinline='' controls ><source src='" +
                                    match[1] +
                                    "' type='video/mp4'> </video>";
                            }
                            return _str;
                        },
                    },
                ],
            },
            exportPdf: {
                stylesheets: ["EDITOR_STYLES", "./content.css"],
                fileName: "export-pdf-demo.pdf",
                appID: "cke5-demos",
                converterOptions: {
                    format: "Tabloid",
                    margin_top: "20mm",
                    margin_bottom: "20mm",
                    margin_right: "7mm",
                    margin_left: "7mm",
                    page_orientation: "portrait",
                },
                tokenUrl: false,
            },
            exportWord: {
                stylesheets: ["EDITOR_STYLES", "./content.css"],
                fileName: "export-word-demo.docx",
                appID: "cke5-demos",
                converterOptions: {
                    format: "A4",
                    margin_top: "20mm",
                    margin_bottom: "20mm",
                    margin_right: "7mm",
                    margin_left: "7mm",
                },
                tokenUrl: false,
            },
            fontFamily: {
                supportAllValues: true,
            },
            fontSize: {
                options: [10, 12, 14, "default", 18, 20, 22],
                supportAllValues: true,
            },
            /*fontColor: {
					columns: 12,
					colors: REDUCED_MATERIAL_COLORS
				},
				fontBackgroundColor: {
					columns: 12,
					colors: REDUCED_MATERIAL_COLORS
				},*/
            heading: {
                options: [
                    {
                        model: "paragraph",
                        title: "Paragraph",
                        class: "ck-heading_paragraph",
                    },
                    {
                        model: "paragraphCap",
                        view: {
                            name: "p",
                            classes: "dropcap",
                        },
                        title: "Paragraph First Cap",
                        class: "ck-heading_paragraph_cap",

                        // It needs to be converted before the standard 'heading2'.
                        converterPriority: "high",
                    },
                    {
                        model: "heading1",
                        view: "h1",
                        title: "Heading 1",
                        class: "ck-heading_heading1",
                    },
                    {
                        model: "heading2",
                        view: "h2",
                        title: "Heading 2",
                        class: "ck-heading_heading2",
                    },
                    {
                        model: "heading3",
                        view: "h3",
                        title: "Heading 3",
                        class: "ck-heading_heading3",
                    },
                    {
                        model: "heading4",
                        view: "h4",
                        title: "Heading 4",
                        class: "ck-heading_heading4",
                    },
                    {
                        model: "heading5",
                        view: "h5",
                        title: "Heading 5",
                        class: "ck-heading_heading5",
                    },
                    {
                        model: "heading6",
                        view: "h6",
                        title: "Heading 6",
                        class: "ck-heading_heading6",
                    },
                ],
            },
            htmlEmbed: {
                showPreviews: true,
            },
            htmlSupport: {
                allow: [
                    // Enables all HTML features.
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true,
                    },
                ],
                disallow: [
                    {
                        attributes: [
                            {
                                key: /.*/,
                                value: /data:(?!image\/(png|jpeg|gif|webp))/i,
                            },
                        ],
                    },
                ],
            },

            image: {
                styles: ["alignCenter", "alignLeft", "alignRight"],
                resizeOptions: [
                    {
                        name: "resizeImage:original",
                        label: "Default image width",
                        value: null,
                    },
                    {
                        name: "resizeImage:50",
                        label: "50% page width",
                        value: "50",
                    },
                    {
                        name: "resizeImage:75",
                        label: "75% page width",
                        value: "75",
                    },
                ],
                toolbar: [
                    "imageTextAlternative",
                    "toggleImageCaption",
                    "|",
                    "imageStyle:inline",
                    "imageStyle:wrapText",
                    "imageStyle:breakText",
                    "imageStyle:side",
                    "|",
                    "resizeImage",
                ],
                insert: {
                    integrations: ["insertImageViaUrl"],
                },
            },
            importWord: {
                tokenUrl: false,
                defaultStyles: true,
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true,
                },
            },
            link: {
                decorators: {
                    toggleDownloadable: {
                        mode: "manual",
                        label: "Downloadable",
                        attributes: {
                            download: "file",
                        },
                    },
                },
                addTargetToExternalLinks: true,
                defaultProtocol: "https://",
            },
            /* mention: {
					feeds: MENTION_FEEDS
				}, */
            placeholder: "Type or paste your content here!",
            style: {
                definitions: [
                    {
                        name: "Title",
                        element: "h1",
                        classes: ["document-title"],
                    },
                    {
                        name: "Subtitle",
                        element: "h2",
                        classes: ["document-subtitle"],
                    },
                    {
                        name: "Callout",
                        element: "p",
                        classes: ["callout"],
                    },
                    {
                        name: "Side quote",
                        element: "blockquote",
                        classes: ["side-quote"],
                    },
                    {
                        name: "Needs clarification",
                        element: "span",
                        classes: ["needs-clarification"],
                    },
                    {
                        name: "Wide spacing",
                        element: "span",
                        classes: ["wide-spacing"],
                    },
                    {
                        name: "Small caps",
                        element: "span",
                        classes: ["small-caps"],
                    },
                    {
                        name: "Code (dark)",
                        element: "pre",
                        classes: ["stylish-code", "stylish-code-dark"],
                    },
                    {
                        name: "Code (bright)",
                        element: "pre",
                        classes: ["stylish-code", "stylish-code-bright"],
                    },
                ],
            },
            table: {
                contentToolbar: [
                    "tableColumn",
                    "tableRow",
                    "mergeTableCells",
                    "tableProperties",
                    "tableCellProperties",
                    "toggleTableCaption",
                ],
            },

            /* You must provide a valid token URL in order to use the CKBox application.
				After registering to CKBox, the fastest way to try out CKBox is to use the development token endpoint:
				https://ckeditor.com/docs/ckbox/latest/guides/configuration/authentication.html#token-endpoint */
            // ckbox: {
            // 	tokenUrl: 'https://your.token.url'
            // }
        },

        newCKConfigAR: {
            contentsLangDirection: "rtl",
            contentsLanguage: "ar",
            language: "ar",
            alignment: {
                options: ["left", "right", "justify"],
            },
            plugins: [
                "Alignment",
                "Autoformat",
                "AutoImage",
                // "AutoLink",
                "BlockQuote",
                // "BlockImage",
                "Bold",
                // "CloudServices",
                "Code",
                // "CodeBlock",
                "Essentials",
                // "ExportPdf",
                // "ExportWord",
                // "FindAndReplace",
                // "Font",
                // "GeneralHtmlSupport",
                "Heading",
                "HorizontalLine",
                "HtmlEmbed",
                "Image",
                "ImageCaption",
                // "ImageInsert",
                // "ImageResize",
                "ImageStyle",
                "ImageToolbar",
                "ImageUpload",
                // "Base64UploadAdapter",
                // "ImportWord",
                "Indent",
                "IndentBlock",
                "Italic",
                "Link",
                // "LinkImage",
                "List",
                // "ListProperties",
                "MediaEmbed",
                // "Mention",
                "PageBreak",
                "Paragraph",
                "PasteFromOffice",
                // "PictureEditing",
                // "RemoveFormat",
                "SourceEditing",
                "Strikethrough",
                //"Style",
                "Subscript",
                "Superscript",
                "Table",
                // "TableCaption",
                "TableCellProperties",
                // "TableColumnResize",
                // "TableProperties",
                "TableToolbar",
                // "TextPartLanguage",
                // "TextTransformation",
                // "TodoList",
                // "Underline",
                // "UploadAdapter"
            ],

            toolbar: {
                shouldNotGroupWhenFull: true,
                items: [
                    // --- Document-wide tools ----------------------------------------------------------------------
                    "undo",
                    "redo",
                    "|",
                    "sourceEditing",
                    "|",
                    "importWord",
                    "exportWord",
                    "exportPdf",
                    "|",
                    "findAndReplace",
                    "selectAll",
                    "wproofreader",
                    "|",

                    // --- "Insertables" ----------------------------------------------------------------------------
                    "link",
                    "insertImage",
                    /* You must provide a valid token URL in order to use the CKBox application.
						After registering to CKBox, the fastest way to try out CKBox is to use the development token endpoint:
						https://ckeditor.com/docs/ckbox/latest/guides/configuration/authentication.html#token-endpoint*/
                    // 'ckbox',
                    "insertTable",
                    "blockQuote",
                    "mediaEmbed",
                    "codeBlock",
                    // "htmlEmbed",
                    "pageBreak",
                    "horizontalLine",
                    "-",

                    // --- Block-level formatting -------------------------------------------------------------------
                    "heading",
                    "style",
                    "|",

                    // --- Basic styles, font and inline formatting -------------------------------------------------------
                    "bold",
                    "italic",
                    "underline",
                    "strikethrough",
                    "superscript",
                    "subscript",
                    {
                        label: "Basic styles",
                        icon: "text",
                        items: [
                            "fontSize",
                            "fontFamily",
                            "fontColor",
                            "fontBackgroundColor",
                            "code",
                            "|",
                            "textPartLanguage",
                            "|",
                        ],
                    },
                    "removeFormat",
                    "|",

                    // --- Text alignment ---------------------------------------------------------------------------
                    "alignment",
                    "|",

                    // --- Lists and indentation --------------------------------------------------------------------
                    "bulletedList",
                    "numberedList",
                    "todoList",
                    "|",
                    "outdent",
                    "indent",
                ],
            },

            myOembedTagsimage: {
                schema: "image",
                re: /(.*\.(?:png|jpg|gif|webp|svg))/i,
                url: function (a) {
                    var b =
                        PGSADMIN.configs.newCKConfig.myOembedTagsimage.re.exec(
                            a
                        );
                    return b && 2 == b.length ? "" + b[1] : null;
                },
            },
            myOembedTagsvideo: {
                schema: "video",
                re: /(.*\.(?:mp4))/i,
                url: function (a) {
                    var b =
                        PGSADMIN.configs.newCKConfig.myOembedTagsvideo.re.exec(
                            a
                        );
                    return b && 2 == b.length ? "" + b[1] : null;
                },
            },
            mediaEmbed: {
                previewsInData: true,
                extraProviders: [
                    {
                        name: "extraProvider",
                        url: /^(.*)/,
                        html: function (match) {
                            var _imageURL =
                                PGSADMIN.configs.newCKConfig.myOembedTagsimage.url(
                                    match[1]
                                );
                            var _str = "";
                            console.log(_imageURL);
                            if (_imageURL != null) {
                                _str =
                                    "<div class='imgWrap '><img style='max-width:330px;' src='" +
                                    match[1] +
                                    "' /></div>";
                            } else {
                                _str =
                                    "<div class='imgWrap '><video style='max-width:330px;' playsinline='' controls ><source src='" +
                                    match[1] +
                                    "' type='video/mp4'> </video>";
                            }
                            return _str;
                        },
                    },
                ],
            },
            exportPdf: {
                stylesheets: ["EDITOR_STYLES", "./content.css"],
                fileName: "export-pdf-demo.pdf",
                appID: "cke5-demos",
                converterOptions: {
                    format: "Tabloid",
                    margin_top: "20mm",
                    margin_bottom: "20mm",
                    margin_right: "7mm",
                    margin_left: "7mm",
                    page_orientation: "portrait",
                },
                tokenUrl: false,
            },
            exportWord: {
                stylesheets: ["EDITOR_STYLES", "./content.css"],
                fileName: "export-word-demo.docx",
                appID: "cke5-demos",
                converterOptions: {
                    format: "A4",
                    margin_top: "20mm",
                    margin_bottom: "20mm",
                    margin_right: "7mm",
                    margin_left: "7mm",
                },
                tokenUrl: false,
            },
            fontFamily: {
                supportAllValues: true,
            },
            fontSize: {
                options: [10, 12, 14, "default", 18, 20, 22],
                supportAllValues: true,
            },
            /*fontColor: {
					columns: 12,
					colors: REDUCED_MATERIAL_COLORS
				},
				fontBackgroundColor: {
					columns: 12,
					colors: REDUCED_MATERIAL_COLORS
				},*/
            heading: {
                options: [
                    {
                        model: "paragraph",
                        title: "Paragraph",
                        class: "ck-heading_paragraph",
                    },
                    {
                        model: "heading1",
                        view: "h1",
                        title: "Heading 1",
                        class: "ck-heading_heading1",
                    },
                    {
                        model: "heading2",
                        view: "h2",
                        title: "Heading 2",
                        class: "ck-heading_heading2",
                    },
                    {
                        model: "heading3",
                        view: "h3",
                        title: "Heading 3",
                        class: "ck-heading_heading3",
                    },
                    {
                        model: "heading4",
                        view: "h4",
                        title: "Heading 4",
                        class: "ck-heading_heading4",
                    },
                    {
                        model: "heading5",
                        view: "h5",
                        title: "Heading 5",
                        class: "ck-heading_heading5",
                    },
                    {
                        model: "heading6",
                        view: "h6",
                        title: "Heading 6",
                        class: "ck-heading_heading6",
                    },
                ],
            },
            htmlEmbed: {
                showPreviews: true,
            },
            htmlSupport: {
                allow: [
                    // Enables all HTML features.
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true,
                    },
                ],
                disallow: [
                    {
                        attributes: [
                            {
                                key: /.*/,
                                value: /data:(?!image\/(png|jpeg|gif|webp))/i,
                            },
                        ],
                    },
                ],
            },

            image: {
                styles: ["alignCenter", "alignLeft", "alignRight"],
                resizeOptions: [
                    {
                        name: "resizeImage:original",
                        label: "Default image width",
                        value: null,
                    },
                    {
                        name: "resizeImage:50",
                        label: "50% page width",
                        value: "50",
                    },
                    {
                        name: "resizeImage:75",
                        label: "75% page width",
                        value: "75",
                    },
                ],
                toolbar: [
                    "imageTextAlternative",
                    "toggleImageCaption",
                    "|",
                    "imageStyle:inline",
                    "imageStyle:wrapText",
                    "imageStyle:breakText",
                    "imageStyle:side",
                    "|",
                    "resizeImage",
                ],
                insert: {
                    integrations: ["insertImageViaUrl"],
                },
            },
            importWord: {
                tokenUrl: false,
                defaultStyles: true,
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true,
                },
            },
            link: {
                decorators: {
                    toggleDownloadable: {
                        mode: "manual",
                        label: "Downloadable",
                        attributes: {
                            download: "file",
                        },
                    },
                },
                addTargetToExternalLinks: true,
                defaultProtocol: "https://",
            },
            /* mention: {
					feeds: MENTION_FEEDS
				}, */
            placeholder: "Type or paste your content here!",
            style: {
                definitions: [
                    {
                        name: "Title",
                        element: "h1",
                        classes: ["document-title"],
                    },
                    {
                        name: "Subtitle",
                        element: "h2",
                        classes: ["document-subtitle"],
                    },
                    {
                        name: "Callout",
                        element: "p",
                        classes: ["callout"],
                    },
                    {
                        name: "Side quote",
                        element: "blockquote",
                        classes: ["side-quote"],
                    },
                    {
                        name: "Needs clarification",
                        element: "span",
                        classes: ["needs-clarification"],
                    },
                    {
                        name: "Wide spacing",
                        element: "span",
                        classes: ["wide-spacing"],
                    },
                    {
                        name: "Small caps",
                        element: "span",
                        classes: ["small-caps"],
                    },
                    {
                        name: "Code (dark)",
                        element: "pre",
                        classes: ["stylish-code", "stylish-code-dark"],
                    },
                    {
                        name: "Code (bright)",
                        element: "pre",
                        classes: ["stylish-code", "stylish-code-bright"],
                    },
                ],
            },
            table: {
                contentToolbar: [
                    "tableColumn",
                    "tableRow",
                    "mergeTableCells",
                    "tableProperties",
                    "tableCellProperties",
                    "toggleTableCaption",
                ],
            },

            /* You must provide a valid token URL in order to use the CKBox application.
				After registering to CKBox, the fastest way to try out CKBox is to use the development token endpoint:
				https://ckeditor.com/docs/ckbox/latest/guides/configuration/authentication.html#token-endpoint */
            // ckbox: {
            // 	tokenUrl: 'https://your.token.url'
            // }
        },
    };
    _self.utils = {
        getRand: function () {
            return (moment().unix() + Math.random())
                .toString()
                .replace(".", "_");
        },
        copyData: function (from, to) {
            $("body").on("keyup", from, function (e) {
                $(to).val($(this).val());
            });
        },
        test: function () {
            console.log("Hello WOrld");
        },
        catchPaste: function (evt, elem, callback) {
            if (navigator.clipboard && navigator.clipboard.readText) {
                // modern approach with Clipboard API
                navigator.clipboard.readText().then(callback);
            } else if (evt.originalEvent && evt.originalEvent.clipboardData) {
                // OriginalEvent is a property from jQuery, normalizing the event object
                callback(evt.originalEvent.clipboardData.getData("text"));
            } else if (evt.clipboardData) {
                // used in some browsers for clipboardData
                callback(evt.clipboardData.getData("text/plain"));
            } else if (window.clipboardData) {
                // Older clipboardData version for Internet Explorer only
                callback(window.clipboardData.getData("Text"));
            } else {
                // Last resort fallback, using a timer
                setTimeout(function () {
                    callback(elem.value);
                }, 100);
            }
        },
        getYoutubeID: function (url) {
            var re =
                /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i;
            var match = url.match(re);
            if (!match) {
                return false;
            }
            return match[1];
        },
        isArabic: function (str) {
            var arabic = /[\u0600-\u06FF]/;
            return arabic.test(str);
        },
        sendAjax: function (url, type, dataToSend, callback) {
            dataToSend._token = window.Laravel.csrfToken;

            /* if(type != 'GET' || type != 'POST'){
                console.log('The 2nd Arg is send Type - POST or GET');
            } */

            if ($("#commonAjaxLoader").length) {
                $("#commonAjaxLoader").show();
            }
            $.ajax({
                url: url,
                type: type,
                async: true,
                data: dataToSend,
                dataType: "json",
                statusCode: {
                    302: function () {
                        alert("Forbidden. Access Restricted");
                    },
                    403: function () {
                        alert("Forbidden. Access Restricted", "403");
                    },
                    404: function () {
                        alert("Page not found", "404");
                    },
                    500: function () {
                        alert("Internal Server Error", "500");
                    },
                },
            })
                .done(function (responseData) {
                    callback(responseData);
                    $("#commonAjaxLoader").hide();
                })
                .fail(function (jqXHR, textStatus) {
                    $("#commonAjaxLoader").hide();
                    callback(jqXHR);
                });
        },
        showTopMessage: function (message) {
            $("#topMessage").html(message);
            $("#topMessage").removeClass("hidden");

            setTimeout(function () {
                $("#topMessage").html("");
                $("#topMessage").addClass("hidden");
            }, 6000);
        },
        singleAjaxUpload: function (settings, customData) {
            var uploader = new plupload.Uploader({
                runtimes: "html5,flash,silverlight,html4",
                drop_element: "uploader-target",
                browse_button: "uploader-target", // you can pass in id...
                url: settings.url,
                filters: settings.filters,
                multipart_params: {},
                headers: { "X-CSRF-TOKEN": window.Laravel.csrfToken },
                init: {
                    BeforeUpload: function (up, files) {
                        if (typeof customData == "object") {
                            uploader.settings.multipart_params = customData;
                        }
                        var status_before = files.status;
                        $("#loader").show();
                        var htm = $("#" + files.id).html();
                        $("#" + files.id).html(
                            htm +
                                ' <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i><span class="percent"></span>'
                        );
                    },
                    FilesAdded: function (up, files) {
                        total = files.length;
                        $(files).each(function (i, v) {
                            $("#selected_files").append(
                                '<div id="' + v.id + '">' + v.name + "</div>"
                            );
                        });

                        // $('.file-list').html('');
                        count = 1;
                        uploader.start();
                    },
                },
            });
        },
        youtubeVideoThumbUploader: function (elementID, uploadUrl, basePath) {
            var _slug = $("#" + elementID).attr("data-slug");

            var uploader = new plupload.Uploader({
                runtimes: "html5,flash,silverlight,html4",
                browse_button: elementID, // you can pass in id...
                url: uploadUrl,
                filters: {
                    max_file_size: "100mb",
                    mime_types: [
                        { title: "Image file", extensions: "jpg" },
                        { title: "Image file", extensions: "jpeg" },
                        { title: "Image file", extensions: "png" },
                        { title: "Image file", extensions: "svg" },
                        { title: "Image file", extensions: "gif" },
                    ],
                },
                multipart_params: {
                    name: "video",
                    slug: _slug + "_ytthumb",
                },
                headers: { "X-CSRF-TOKEN": window.Laravel.csrfToken },
                init: {
                    BeforeUpload: function (up, files) {},
                    FilesAdded: function (up, files) {
                        uploader.start();
                    },
                    UploadProgress: function (up, file) {
                        $("#ytThumb")
                            .find(".uploadProgress")
                            .css({ width: file.percent + "%" });
                        $("#ytThumb")
                            .find(".uploadPercentage")
                            .html(file.percent + "%");
                    },
                    FileUploaded: function (up, file, response) {
                        var t = response.response;

                        try {
                            var rt = $.parseJSON(t);

                            if (rt.status == true) {
                                $("#youtube_thumb").attr(
                                    "src",
                                    basePath + rt.data.fileName
                                );
                                $("#customImage").val(rt.data.id);
                                $("#ytThumb").find(".uploadFileName").html("");
                                $("#ytThumb").find(".original_name").val("");
                                $("#ytThumb")
                                    .find(".uploadProgress")
                                    .css({ width: "0%" });
                                $("#ytThumb")
                                    .find(".uploadPercentage")
                                    .html("");
                            } else {
                                $("#ytThumb").find(".uploadFileName").html("");
                                $("#ytThumb").find(".original_name").val("");
                                $("#ytThumb")
                                    .find(".uploadProgress")
                                    .css({ width: "0%" });
                                $("#ytThumb")
                                    .find(".uploadPercentage")
                                    .html("");

                                if (typeof swal == "undefined") {
                                    alert(window.appTrans.invalidFile);
                                } else {
                                    swal.fire({
                                        title: window.appTrans.error,
                                        text: rt.response,
                                        type: "warning",
                                        confirmButtonText: window.appTrans.ok,
                                        confirmButtonColor: "#000",
                                        closeOnConfirm: false,
                                    });
                                }
                            }
                        } catch (ex) {
                            // console.log(ex);
                            Swal.fire({
                                text: "Network Error Occured. Please try again.",
                                type: "error",
                            });
                            $("#ytThumb").find(".uploadFileName").html("");
                            $("#ytThumb").find(".filename").val("");
                            $("#ytThumb").find(".original").val("");
                            $("#ytThumb")
                                .find(".uploadProgress")
                                .css({ width: "0%" });
                            $("#ytThumb").find(".uploadPercentage").html("");
                        }
                    },
                    UploadComplete: function (up, files) {
                        //$('#loader').hide();
                        // $('.uploadWrapperParent').addClass('uploaded')
                        uploader.splice();
                    },
                    Error: function (up, err) {
                        if (typeof swal == "undefined") {
                            alert(window.appTrans.invalidFile);
                        } else {
                            swal.fire({
                                title: window.appTrans.error,
                                text: window.appTrans.invalidFile + err.message,
                                type: "warning",
                                confirmButtonText: window.appTrans.ok,
                                confirmButtonColor: "#000",
                                closeOnConfirm: false,
                            });
                        }
                    },
                },
            });

            uploader.init();
        },
        createFileHolder: function (type, basePath, data, downloadPath) {
            switch (type) {
                case "image":
                    dispElement =
                        '<img src="' +
                        basePath +
                        data.fileName +
                        '" alt="" class="img-fluid imageCenter">';
                    break;
                case "video":
                    dispElement = data.name
                        ? '<img src="' +
                          basePath +
                          data.fileName +
                          '" alt="" class="img-fluid imageCenter">'
                        : '<img src="https://img.youtube.com/vi/' +
                          data.video +
                          '/hqdefault.jpg" alt="" class="img-fluid imageCenter">';

                    break;

                default:
                    dispElement =
                        '<span class="fa-stack fa-lg">' +
                        '<i class="fa fa-square fa-stack-2x text-primary"></i>' +
                        '<i class="fa fa-file-' +
                        type +
                        ' fa-stack-1x fa-inverse"></i>' +
                        "</span>";
                    break;
            }
            return (
                '<li class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 custCardWrapper gallery-grid">' +
                '<div class="card card-figure has-hoverable">' +
                '<div class="topControls">' +
                '<a class="downloadImage" href="' +
                downloadPath +
                data.id +
                '"> <span><i class="fas fa-download "></i></span></a>' +
                '<div class="text-center ytLang">' +
                '<div class="lang-dropdown">' +
                '<select name="mediaLang[]" class="cardLang">' +
                '<option value="">In Both</option>' +
                "<option " +
                (data.lang == "ar" ? " selected " : "") +
                ' value="ar">Arabic</option>' +
                "<option  " +
                (data.lang == "en" ? " selected " : "") +
                ' value="en">English</option>' +
                "</select>" +
                "</div>" +
                "</div>" +
                '<a href="#" class="btn btn-reset text-muted delUploadImage" title="Delete" data-id="' +
                data.id +
                '">' +
                '<span class="fas fa-times-circle"></span>' +
                "</a>" +
                "</div>" +
                '<figcaption class="figure-caption source-text">' +
                '<div><input data-id="' +
                data.id +
                '" type="text" class="form-control mediaInput source"  value="' +
                (data.source ? data.source : "") +
                '" placeholder="Source English" name="source[]"></div>' +
                '<div><input data-id="' +
                data.id +
                '"  type="text" class="form-control  mediaInput sourceAR"  value="' +
                (data.sourceAR ? data.sourceAR : "") +
                '" placeholder="Source Arabic" dir="rtl" name="sourceAR[]"></div>' +
                "</figcaption>" +
                '<figure class="figure">' +
                '<div class="figure-attachment adjustImage">' +
                '<input type="hidden" name="postMedia[' +
                data.fieldName +
                '][]" value="' +
                data.id +
                '" />' +
                dispElement +
                "</div>" +
                "</figure>" +
                '<figcaption class="figure-caption title-text">' +
                '<div><input data-id="' +
                data.id +
                '" type="text" class="form-control  mediaInput engTitle"  value="' +
                (data.title ? data.title : "") +
                '" placeholder="English Title" name="engTitle[]"></div>' +
                '<div><input data-id="' +
                data.id +
                '"  type="text" class="form-control  mediaInput  arTitle"  value="' +
                (data.titleAR ? data.titleAR : "") +
                '" placeholder="Arabic Title" dir="rtl" name="arTitle[]"></div>' +
                "</figcaption>" +
                "</div>" +
                "</li>"
            );
        },
        getCK5Toolbar: function () {
            return {
                toolbar: {
                    items: [
                        "heading",
                        "|",
                        "bold",
                        "italic",
                        "link",
                        "bulletedList",
                        "numberedList",
                        "|",
                        "indent",
                        "outdent",
                        "|",
                        "imageUpload",
                        "blockQuote",
                        "insertTable",
                        "codeBlock",
                        "alignment",
                        "fontBackgroundColor",
                        "fontColor",
                        "fontSize",
                        "highlight",
                        "horizontalLine",
                        "removeFormat",
                        "strikethrough",
                        "subscript",
                        "superscript",
                        "undo",
                        "redo",
                    ],
                },
            };
        },

        createEnglishArticleEditor: function () {
            var opt = PGSADMIN.utils.getCK5Toolbar();
            /* $('.ckeditorEn').each(function(){
				ClassicEditor.create( document.querySelector( '#'+this.id), opt);
			}); */
            $(".ckeditorEn").each(function () {
                /*var opt = {

                    alignment: {
                        options: ["left", "right", "justify"],
                    },
					heading: {
						options: [
							{ model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
							{ model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
							{ model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
							{ model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
							{ model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
							{ model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },

						]
					},
                    toolbar: [
                        "heading",
                        "|",
                        "bold",
                        "italic",
                        "link",
                        "mediaEmbed",
						"blockQuote",
                        "alignment",
                        "undo",
                        "redo",
                        "numberedList",
                        "bulletedList",
                        "removeFormat",
                        "SourceEditing",
                    ],
                    mediaEmbed: {
                        extraProviders: [
                            {
                                name: "extraProvider",
                                url: /^(.*)/,
                                html: (match) =>
                                    "<img src='" + match[1] + "' />",
                            },
                        ],
                    },
                };*/
                var _newOpt = _self.configs.newCKConfig;
                console.log(_newOpt);
                ClassicEditor.create(
                    document.querySelector("#" + this.id),
                    _newOpt
                );
            });
            /* $('.ckeditorEn').each(function(i,v){

				var id = $(this).attr('id') , exist = false;


					_self.configs.CKconfig.contentsLangDirection = 'ltr';
					_self.configs.CKconfig.contentsLanguage = 'en';
					_self.configs.CKconfig.language = 'en';
					ClassicEditor.create( document.querySelector( $(this).attr('id')));

			}); */
        },

        createArabicArticleEditor: function () {
            /* var opt = {
                contentsLangDirection: "rtl",
                contentsLanguage: "ar",
                language: "ar",
                alignment: {
                    options: ["left", "right", "justify"],
                },
                toolbar: [
                    "heading",
                    "|",
                    "bold",
                    "italic",
                    "link",
                    "mediaEmbed",
                    "blockQuote",
                    "alignment",
                    "undo",
                    "redo",
                    "numberedList",
                    "bulletedList",
                    "removeFormat",
                ],
                mediaEmbed: {
                    extraProviders: [
                        {
                            name: "extraProvider",
                            url: /^(.*)/,
                            html: (match) => "<img src='" + match[1] + "' />",
                        },
                    ],
                },
            };*/

            var _newOptAr = _self.configs.newCKConfigAR;

            $(".ckeditorAr").each(function () {
                ClassicEditor.create(
                    document.querySelector("#" + this.id),
                    _newOptAr
                );
            });
            /* var opt = PGSADMIN.utils.getCK5Toolbar();
            jQuery.extend( true, opt , opt ,{ 'contentsLangDirection':'rtl' , 'contentsLanguage':'ar' , 'language':'ar'} );

			$('.ckeditorAr').each(function(){
				ClassicEditor.create( document.querySelector( '#'+this.id) , opt);
			});
 */
            /* $('.ckeditorAr').each(function(i,v){
				var id = $(this).attr('id') , exist = false;

					_self.configs.CKconfig.contentsLangDirection = 'rtl';
					_self.configs.CKconfig.contentsLanguage = 'ar';
					_self.configs.CKconfig.language = 'ar';
					ClassicEditor.create( document.querySelector( $(this).attr('id')));

			}); */
        },
        createEnglishUlLiEditor: function () {
            var opt = PGSADMIN.utils.getCK5Toolbar();

            $(".ckeditorEnUlLi").each(function () {
                var opt = {
                    alignment: {
                        options: ["left", "right", "justify"],
                    },
                    toolbar: ["bulletedList"],
                };
                ClassicEditor.create(
                    document.querySelector("#" + this.id),
                    opt
                );
            });
        },
        createArabicUlLIEditor: function () {
            var opt = {
                contentsLangDirection: "rtl",
                contentsLanguage: "ar",
                language: "ar",
                alignment: {
                    options: ["left", "right", "justify"],
                },
                toolbar: ["bulletedList"],
            };
            $(".ckeditorArUlLi").each(function () {
                ClassicEditor.create(
                    document.querySelector("#" + this.id),
                    opt
                );
            });
        },

        createAjaxFileMultiUploader: function (
            URLArray,
            downloadPathArr,
            basePathArr
        ) {
            var indexCount = 0;
            $(".singleuploader").each(function (i, v) {
                var _this = $(this);
                var _type = $(this).attr("data-type");
                var _slug = $(this).attr("data-slug");
                var _name = $(this).attr("name");
                indexCount = $(this).attr("data-index");
                var _mimeTypesTmp = $(this).attr("data-allowed");
                if (!_type) {
                    _type = "default";
                }
                if (!_mimeTypesTmp) {
                    _mimeTypes = [
                        { title: "Pdf Document", extensions: "pdf" },
                        { title: "Word Document", extensions: "doc" },
                        { title: "Word Document", extensions: "docx" },
                        { title: "Word Document", extensions: "odt" },
                        { title: "Image file", extensions: "jpg" },
                        { title: "Image file", extensions: "jpeg" },
                        { title: "Image file", extensions: "png" },
                        { title: "Image file", extensions: "svg" },
                    ];
                } else {
                    _mimeTypes = [];
                    var _spitArr = _mimeTypesTmp.split(",");

                    $.each(_spitArr, function (i, v) {
                        _mimeTypes.push({ title: "document", extensions: v });
                    });
                }

                var uploader = new plupload.Uploader({
                    runtimes: "html5,flash,silverlight,html4",
                    browse_button: $(this).attr("id"), // you can pass in id...
                    url: URLArray[indexCount],
                    multi_selection: false,
                    /* resize: {
								width: 100,
								height: 100
							  }, */
                    filters: {
                        max_file_size: "100mb",
                        mime_types: _mimeTypes,
                    },
                    multipart_params: {
                        controlName: _type,
                        slug: _slug,
                        name: _name,
                    },
                    headers: { "X-CSRF-TOKEN": window.Laravel.csrfToken },
                    init: {
                        PostInit: function () {},

                        BeforeUpload: function (up, files) {
                            var status_before = files.status;
                            _this
                                .closest(".input_parent")
                                .find(".uploadProgress")
                                .css({ width: "0%" });
                            _this
                                .closest(".input_parent")
                                .find(".uploadPercentage")
                                .html("");

                            uploader.settings.url = URLArray[indexCount];
                        },
                        FilesAdded: function (up, files) {
                            _this
                                .closest(".input_parent")
                                .find(".uploadFileName")
                                .html(files[0].name);
                            _this
                                .closest(".input_parent")
                                .find('input[type="file"]')
                                .attr("required", true);
                            /* _this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').removeClass('uploaded')
									_this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').addClass('uploading') */
                            uploader.start();
                        },

                        UploadProgress: function (up, file) {
                            _this
                                .closest(".input_parent")
                                .find(".uploadProgress")
                                .css({ width: file.percent + "%" });
                            _this
                                .closest(".input_parent")
                                .find(".uploadPercentage")
                                .html(file.percent + "%");
                        },
                        FileUploaded: function (up, file, response) {
                            var t = response.response;
                            try {
                                var rt = $.parseJSON(t);
                                if (rt.status == true) {
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .removeClass("error");
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .next("label")
                                        .hide();
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .attr("required", false);
                                    _this
                                        .closest(".input_parent")
                                        .find(".filename")
                                        .val(rt.data.fileName);
                                    _this
                                        .closest(".input_parent")
                                        .find(".original_name")
                                        .val(file.name);
                                    var fileHTML, fileType;
                                    fileType = _type;

                                    if (
                                        typeof rt.data.fileType != "undefined"
                                    ) {
                                        fileType = rt.data.fileType;
                                    } else if (
                                        typeof rt.fileType != "undefined"
                                    ) {
                                        fileType = rt.fileType;
                                    }
                                    if (
                                        typeof fileType == "undefined" &&
                                        typeof rt.data.type != "undefined"
                                    ) {
                                        fileType = rt.data.type;
                                    }
                                    //console.log(basePathArr);
                                    //console.log(indexCount);
                                    if (
                                        jQuery.inArray(rt.data.mimeType, [
                                            "image/webp",
                                            "image/jpg",
                                            "image/jpeg",
                                            "image/png",
                                            "image/gif",
                                        ]) !== -1
                                    ) {
                                        fileHTML =
                                            '<div class="uploadPreview img_uploaded"><div class="upImgWrapper"><input type="hidden" name="postMedia[' +
                                            rt.data.fieldName +
                                            '][]" value="' +
                                            rt.data.id +
                                            '" /><span class="delUploadImage" data-id="' +
                                            rt.data.id +
                                            '"><i class="fa fa-times-circle"></i></span><img src="' +
                                            basePathArr[indexCount] +
                                            rt.data.fileName +
                                            '" class="uploadPreview"/></div>' +
                                            '<div class="clearfix"></div></div>';
                                    } else {
                                        // fileHTML = '<div class="uploadPreview filePreview img_uploaded"><div class="upImgWrapper"><input type="hidden" name="postMedia['+rt.data.fieldName+'][]" value="'+rt.data.id+'" /><span class="delUploadImage" data-id="'+
                                        // 		 rt.data.fileName+'"><i class="fa fa-times-circle"></i></span><a target="_blank" href="'+
                                        // 		 downloadPathArr[indexCount]+rt.data.id+'">Download</a></div>'+
                                        // 		 '<div class="clearfix"></div></div>';
                                        fileHTML =
                                            '<div style="display:none;" class="uploadPreview filePreview img_uploaded"><div class="upImgWrapper"><input type="hidden" name="postMedia[' +
                                            rt.data.fieldName +
                                            '][]" value="' +
                                            rt.data.id +
                                            '" /><span class="delUploadImage" data-id="' +
                                            rt.data.fileName +
                                            '"><i class="fa fa-times-circle"></i></span><a target="_blank" href="' +
                                            downloadPathArr[indexCount] +
                                            rt.data.id +
                                            '">Download</a></div>' +
                                            '<div class="clearfix"></div></div>';
                                    }

                                    fileHTML += "";
                                    _this
                                        .parent()
                                        .parent()
                                        .find(".img_uploaded")
                                        .remove();
                                    _this
                                        .closest(".input_parent")
                                        .before(fileHTML);
                                    $(".uploaded-filename").html("");
                                } else {
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadFileName")
                                        .val("");
                                    _this
                                        .closest(".input_parent")
                                        .find(".original_name")
                                        .val("");
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadProgress")
                                        .css({ width: "0%" });
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadPercentage")
                                        .html("");

                                    if (typeof swal == "undefined") {
                                        alert(window.appTrans.invalidFile);
                                    } else {
                                        swal.fire({
                                            title: window.appTrans.error,
                                            text: rt.response,
                                            type: "warning",
                                            confirmButtonText:
                                                window.appTrans.ok,
                                            confirmButtonColor: "#000",
                                            closeOnConfirm: false,
                                        });
                                    }
                                }
                            } catch (ex) {
                                //console.log(ex);
                                Swal.fire({
                                    text: "Network Error Occured. Please try again.",
                                    type: "error",
                                });

                                _this
                                    .closest(".input_parent")
                                    .find(".uploadFileName")
                                    .html("");
                                _this
                                    .closest(".input_parent")
                                    .find(".filename")
                                    .val("");
                                _this
                                    .closest(".input_parent")
                                    .find(".original")
                                    .val("");
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadProgress")
                                    .css({ width: "0%" });
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadPercentage")
                                    .html("");
                            }
                        },
                        UploadComplete: function (up, files) {
                            //$('#loader').hide();
                            // $('.uploadWrapperParent').addClass('uploaded')
                            uploader.splice();
                        },
                        Error: function (up, err) {
                            if (typeof swal == "undefined") {
                                alert(window.appTrans.invalidFile);
                            } else {
                                swal.fire({
                                    title: window.appTrans.error,
                                    text:
                                        window.appTrans.invalidFile +
                                        err.message,
                                    type: "warning",
                                    confirmButtonText: window.appTrans.ok,
                                    confirmButtonColor: "#000",
                                    closeOnConfirm: false,
                                });
                            }
                        },
                    },
                });

                uploader.init();

                uploaders.push(uploader);
            });

            $(document).ready(function () {
                function deleteFile($elem, fileId) {
                    if (!fileId) {
                        console.log("Invalid File name");
                        return false;
                    }

                    var url = window.postMediaDelURL + fileId;

                    PGSADMIN.utils.sendAjax(
                        url,
                        "GET",
                        {},
                        function (response) {
                            if ($.fn.sticky && response.msgClass) {
                                $.sticky(response.message, {
                                    classList: response.msgClass,
                                    position: "top-center",
                                    speed: "slow",
                                });
                            }
                            if (response.status) {
                                var $uploadHTML = $elem
                                    .closest(".form-group")
                                    .find(".uploadControlWrapper");
                                if (
                                    $uploadHTML.hasClass("uploadControlWrapper")
                                ) {
                                    $uploadHTML
                                        .find(".uploadPercentage")
                                        .html("");
                                    $uploadHTML
                                        .find(".uploadFileName")
                                        .html("");
                                    $uploadHTML
                                        .find(".uploadProgress")
                                        .css({ width: "0%" });
                                    $uploadHTML.find(".filename").val("");
                                    $uploadHTML.find(".original_name").val("");
                                }
                                $elem.closest("li").remove();
                                $elem.parent().remove();
                            }
                        }
                    );
                }

                $("body").on("click", ".delUploadImage", function (e) {
                    e.preventDefault();
                    var $elem = $(this);
                    if (typeof Swal == "undefined") {
                        if (confirm("Are you sure?")) {
                            deleteFile($elem, $elem.attr("data-id"));
                        }
                    } else {
                        Swal.fire({
                            title: window.appTrans.areYouSure,
                            text: window.appTrans.cannotRevert,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: window.appTrans.yes,
                        }).then((result) => {
                            if (result.value) {
                                deleteFile($elem, $elem.attr("data-id"));
                            }
                        });
                    }
                });
            });
        },

        createAjaxFileUploader: function (URL, downloadPath, basePath) {
            $(".singleuploader").each(function (i, v) {
                var _this = $(this);
                var _type = $(this).attr("data-type");
                var _slug = $(this).attr("data-slug");
                var _name = $(this).attr("name");

                var _mimeTypesTmp = $(this).attr("data-allowed");
                if (!_type) {
                    _type = "default";
                }
                if (!_mimeTypesTmp) {
                    _mimeTypes = [
                        { title: "Pdf Document", extensions: "pdf" },
                        { title: "Word Document", extensions: "doc" },
                        { title: "Word Document", extensions: "docx" },
                        { title: "Word Document", extensions: "odt" },
                        { title: "Image file", extensions: "jpg" },
                        { title: "Image file", extensions: "jpeg" },
                        { title: "Image file", extensions: "png" },
                        { title: "Image file", extensions: "svg" },
                    ];
                } else {
                    _mimeTypes = [];
                    var _spitArr = _mimeTypesTmp.split(",");

                    $.each(_spitArr, function (i, v) {
                        _mimeTypes.push({ title: "document", extensions: v });
                    });
                }

                var uploader = new plupload.Uploader({
                    runtimes: "html5,flash,silverlight,html4",
                    browse_button: $(this).attr("id"), // you can pass in id...
                    url: URL,
                    multi_selection: false,
                    /* resize: {
								width: 100,
								height: 100
							  }, */
                    filters: {
                        max_file_size: "100mb",
                        mime_types: _mimeTypes,
                    },
                    multipart_params: {
                        controlName: _type,
                        slug: _slug,
                        name: _name,
                    },
                    headers: { "X-CSRF-TOKEN": window.Laravel.csrfToken },
                    init: {
                        PostInit: function () {},

                        BeforeUpload: function (up, files) {
                            var status_before = files.status;
                            _this
                                .closest(".input_parent")
                                .find(".uploadProgress")
                                .css({ width: "0%" });
                            _this
                                .closest(".input_parent")
                                .find(".uploadPercentage")
                                .html("");

                            uploader.settings.url = URL;
                        },
                        FilesAdded: function (up, files) {
                            _this
                                .closest(".input_parent")
                                .find(".uploadFileName")
                                .html(files[0].name);
                            _this
                                .closest(".input_parent")
                                .find('input[type="file"]')
                                .attr("required", true);
                            /* _this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').removeClass('uploaded')
									_this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').addClass('uploading') */
                            uploader.start();
                        },

                        UploadProgress: function (up, file) {
                            _this
                                .closest(".input_parent")
                                .find(".uploadProgress")
                                .css({ width: file.percent + "%" });
                            _this
                                .closest(".input_parent")
                                .find(".uploadPercentage")
                                .html(file.percent + "%");
                        },
                        FileUploaded: function (up, file, response) {
                            var t = response.response;
                            try {
                                var rt = $.parseJSON(t);
                                if (rt.status == true) {
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .removeClass("error");
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .next("label")
                                        .hide();
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .attr("required", false);
                                    _this
                                        .closest(".input_parent")
                                        .find(".filename")
                                        .val(rt.data.fileName);
                                    _this
                                        .closest(".input_parent")
                                        .find(".original_name")
                                        .val(file.name);
                                    // var basePath = '{{ asset("storage/app/post/uploads") }}/';
                                    // var downloadPath = '{{ apa("post_media_download") }}/';
                                    var fileHTML, fileType;
                                    fileType = _type;

                                    if (
                                        typeof rt.data.fileType != "undefined"
                                    ) {
                                        fileType = rt.data.fileType;
                                    } else if (
                                        typeof rt.fileType != "undefined"
                                    ) {
                                        fileType = rt.fileType;
                                    }
                                    if (
                                        typeof fileType == "undefined" &&
                                        typeof rt.data.type != "undefined"
                                    ) {
                                        fileType = rt.data.type;
                                    }

                                    if (
                                        jQuery.inArray(rt.data.mimeType, [
                                            "image/jpeg",
                                            "image/png",
                                            "image/gif",
                                            "image/svg+xml",
                                        ]) !== -1
                                    ) {
                                        fileHTML =
                                            '<div class="uploadPreview img_uploaded"><div class="upImgWrapper"><input type="hidden" name="postMedia[' +
                                            rt.data.fieldName +
                                            '][]" value="' +
                                            rt.data.id +
                                            '" /><span class="delUploadImage" data-id="' +
                                            rt.data.id +
                                            '"><i class="fa fa-times-circle"></i></span><img src="' +
                                            basePath +
                                            rt.data.fileName +
                                            '" class="uploadPreview"/></div>' +
                                            '<div class="clearfix"></div></div>';
                                    } else {
                                        fileHTML =
                                            '<div class="uploadPreview filePreview img_uploaded"><div class="upImgWrapper"><input type="hidden" name="postMedia[' +
                                            rt.data.fieldName +
                                            '][]" value="' +
                                            rt.data.id +
                                            '" /><span class="delUploadImage" data-id="' +
                                            rt.data.fileName +
                                            '"><i class="fa fa-times-circle"></i></span><a target="_blank" href="' +
                                            downloadPath +
                                            rt.data.id +
                                            '">Download</a></div>' +
                                            '<div class="clearfix"></div></div>';
                                    }

                                    fileHTML += "";
                                    _this
                                        .parent()
                                        .parent()
                                        .find(".img_uploaded")
                                        .remove();
                                    _this
                                        .closest(".input_parent")
                                        .before(fileHTML);
                                } else {
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadFileName")
                                        .val("");
                                    _this
                                        .closest(".input_parent")
                                        .find(".original_name")
                                        .val("");
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadProgress")
                                        .css({ width: "0%" });
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadPercentage")
                                        .html("");

                                    if (typeof swal == "undefined") {
                                        alert(window.appTrans.invalidFile);
                                    } else {
                                        swal.fire({
                                            title: window.appTrans.error,
                                            text: rt.response,
                                            type: "warning",
                                            confirmButtonText:
                                                window.appTrans.ok,
                                            confirmButtonColor: "#000",
                                            closeOnConfirm: false,
                                        });
                                    }
                                }
                            } catch (ex) {
                                Swal.fire({
                                    text: "Network Error Occured. Please try again.",
                                    type: "error",
                                });
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadFileName")
                                    .html("");
                                _this
                                    .closest(".input_parent")
                                    .find(".filename")
                                    .val("");
                                _this
                                    .closest(".input_parent")
                                    .find(".original")
                                    .val("");
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadProgress")
                                    .css({ width: "0%" });
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadPercentage")
                                    .html("");
                            }
                        },
                        UploadComplete: function (up, files) {
                            //$('#loader').hide();
                            // $('.uploadWrapperParent').addClass('uploaded')
                            uploader.splice();
                        },
                        Error: function (up, err) {
                            if (typeof swal == "undefined") {
                                alert(window.appTrans.invalidFile);
                            } else {
                                swal.fire({
                                    title: window.appTrans.error,
                                    text:
                                        window.appTrans.invalidFile +
                                        err.message,
                                    type: "warning",
                                    confirmButtonText: window.appTrans.ok,
                                    confirmButtonColor: "#000",
                                    closeOnConfirm: false,
                                });
                            }
                        },
                    },
                });

                uploader.init();

                uploaders.push(uploader);
            });

            $(document).ready(function () {
                function deleteFile($elem, fileId) {
                    if (!fileId) {
                        console.log("Invalid File name");
                        return false;
                    }

                    var url = window.postMediaDelURL + fileId;

                    PGSADMIN.utils.sendAjax(
                        url,
                        "POST",
                        {},
                        function (response) {
                            if ($.fn.sticky && response.msgClass) {
                                $.sticky(response.message, {
                                    classList: response.msgClass,
                                    position: "top-center",
                                    speed: "slow",
                                });
                            }
                            if (response.status) {
                                var $uploadHTML = $elem
                                    .closest(".form-group")
                                    .find(".uploadControlWrapper");
                                if (
                                    $uploadHTML.hasClass("uploadControlWrapper")
                                ) {
                                    $uploadHTML
                                        .find(".uploadPercentage")
                                        .html("");
                                    $uploadHTML
                                        .find(".uploadFileName")
                                        .html("");
                                    $uploadHTML
                                        .find(".uploadProgress")
                                        .css({ width: "0%" });
                                    $uploadHTML.find(".filename").val("");
                                    $uploadHTML.find(".original_name").val("");
                                }
                                $elem.closest("li").remove();
                                $elem.parent().remove();
                            }
                        }
                    );
                }

                $("body").on("click", ".delUploadImage", function (e) {
                    e.preventDefault();
                    var $elem = $(this);
                    if (typeof Swal == "undefined") {
                        if (confirm("Are you sure?")) {
                            deleteFile($elem, $elem.attr("data-id"));
                        }
                    } else {
                        Swal.fire({
                            title: window.appTrans.areYouSure,
                            text: window.appTrans.cannotRevert,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: window.appTrans.yes,
                        }).then((result) => {
                            if (result.value) {
                                deleteFile($elem, $elem.attr("data-id"));
                            }
                        });
                    }
                });
            });
        },
        createRegFileUploader: function (URL, downloadPath, basePath) {
            $(".uploader").each(function (i, v) {
                var _this = $(this);
                var _type = $(this).attr("data-type");
                var _slug = $(this).attr("data-slug");
                var _name = $(this).attr("name");

                var _mimeTypesTmp = $(this).attr("data-allowed");
                if (!_type) {
                    _type = "default";
                }
                if (!_mimeTypesTmp) {
                    _mimeTypes = [
                        { title: "Pdf Document", extensions: "pdf" },
                        { title: "Word Document", extensions: "doc" },
                        { title: "Word Document", extensions: "docx" },
                        { title: "Word Document", extensions: "odt" },
                        { title: "Image file", extensions: "jpg" },
                        { title: "Image file", extensions: "jpeg" },
                        { title: "Image file", extensions: "png" },
                        { title: "Image file", extensions: "svg" },
                    ];
                } else {
                    _mimeTypes = [];
                    var _spitArr = _mimeTypesTmp.split(",");

                    $.each(_spitArr, function (i, v) {
                        _mimeTypes.push({ title: "document", extensions: v });
                    });
                }

                var uploader = new plupload.Uploader({
                    runtimes: "html5,flash,silverlight,html4",
                    browse_button: $(this).attr("id"), // you can pass in id...
                    url: URL,
                    multi_selection: false,
                    /* resize: {
								width: 100,
								height: 100
							  }, */
                    filters: {
                        max_file_size: "100mb",
                        mime_types: _mimeTypes,
                    },
                    multipart_params: {
                        controlName: _type,
                        slug: _slug,
                        name: _name,
                    },
                    headers: { "X-CSRF-TOKEN": window.Laravel.csrfToken },
                    init: {
                        PostInit: function () {},

                        BeforeUpload: function (up, files) {
                            var status_before = files.status;
                            _this
                                .closest(".input_parent")
                                .find(".uploadProgress")
                                .css({ width: "0%" });
                            _this
                                .closest(".input_parent")
                                .find(".uploadPercentage")
                                .html("");

                            uploader.settings.url = URL;
                        },
                        FilesAdded: function (up, files) {
                            _this
                                .closest(".input_parent")
                                .find(".uploadFileName")
                                .html(files[0].name);
                            _this
                                .closest(".input_parent")
                                .find('input[type="file"]')
                                .attr("required", true);
                            /* _this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').removeClass('uploaded')
									_this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').addClass('uploading') */
                            uploader.start();
                        },

                        UploadProgress: function (up, file) {
                            _this
                                .closest(".input_parent")
                                .find(".uploadProgress")
                                .css({ width: file.percent + "%" });
                            _this
                                .closest(".input_parent")
                                .find(".uploadPercentage")
                                .html(file.percent + "%");
                        },
                        FileUploaded: function (up, file, response) {
                            var t = response.response;
                            try {
                                var rt = $.parseJSON(t);
                                if (rt.status == true) {
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .removeClass("error");
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .next("label")
                                        .hide();
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .attr("required", false);
                                    _this
                                        .closest(".input_parent")
                                        .find(".filename")
                                        .val(rt.uploadDetails.fileName);
                                    _this
                                        .closest(".input_parent")
                                        .find(".original_name")
                                        .val(file.name);
                                    // var basePath = '{{ asset("storage/app/post/uploads") }}/';
                                    // var downloadPath = '{{ apa("post_media_download") }}/';
                                    var fileHTML, fileType;
                                    fileType = _type;

                                    if (
                                        typeof rt.uploadDetails.fileType !=
                                        "undefined"
                                    ) {
                                        fileType = rt.uploadDetails.fileType;
                                    } else if (
                                        typeof rt.fileType != "undefined"
                                    ) {
                                        fileType = rt.fileType;
                                    }
                                    if (
                                        typeof fileType == "undefined" &&
                                        typeof rt.uploadDetails.type !=
                                            "undefined"
                                    ) {
                                        fileType = rt.uploadDetails.type;
                                    }

                                    fileHTML += "";
                                    _this
                                        .parent()
                                        .parent()
                                        .find(".img_uploaded")
                                        .remove();
                                } else {
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadFileName")
                                        .val("");
                                    _this
                                        .closest(".input_parent")
                                        .find(".original_name")
                                        .val("");
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadProgress")
                                        .css({ width: "0%" });
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadPercentage")
                                        .html("");

                                    if (typeof swal == "undefined") {
                                        alert(window.appTrans.invalidFile);
                                    } else {
                                        swal.fire({
                                            title: window.appTrans.error,
                                            text: rt.response,
                                            type: "warning",
                                            confirmButtonText:
                                                window.appTrans.ok,
                                            confirmButtonColor: "#000",
                                            closeOnConfirm: false,
                                        });
                                    }
                                }
                            } catch (ex) {
                                Swal.fire({
                                    text: "Network Error Occured. Please try again.",
                                    type: "error",
                                });
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadFileName")
                                    .html("");
                                _this
                                    .closest(".input_parent")
                                    .find(".filename")
                                    .val("");
                                _this
                                    .closest(".input_parent")
                                    .find(".original")
                                    .val("");
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadProgress")
                                    .css({ width: "0%" });
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadPercentage")
                                    .html("");
                            }
                        },
                        UploadComplete: function (up, files) {
                            //$('#loader').hide();
                            // $('.uploadWrapperParent').addClass('uploaded')
                            uploader.splice();
                        },
                        Error: function (up, err) {
                            if (typeof swal == "undefined") {
                                alert(window.appTrans.invalidFile);
                            } else {
                                swal.fire({
                                    title: window.appTrans.error,
                                    text:
                                        window.appTrans.invalidFile +
                                        err.message,
                                    type: "warning",
                                    confirmButtonText: window.appTrans.ok,
                                    confirmButtonColor: "#000",
                                    closeOnConfirm: false,
                                });
                            }
                        },
                    },
                });

                uploader.init();

                uploaders.push(uploader);
            });

            $(document).ready(function () {
                function deleteFile($elem, fileId) {
                    if (!fileId) {
                        console.log("Invalid File name");
                        return false;
                    }

                    var url = window.postMediaDelURL + fileId;

                    PGSADMIN.utils.sendAjax(
                        url,
                        "GET",
                        {},
                        function (response) {
                            if ($.fn.sticky && response.msgClass) {
                                $.sticky(response.message, {
                                    classList: response.msgClass,
                                    position: "top-center",
                                    speed: "slow",
                                });
                            }
                            if (response.status) {
                                var $uploadHTML = $elem
                                    .closest(".form-group")
                                    .find(".uploadControlWrapper");
                                if (
                                    $uploadHTML.hasClass("uploadControlWrapper")
                                ) {
                                    $uploadHTML
                                        .find(".uploadPercentage")
                                        .html("");
                                    $uploadHTML
                                        .find(".uploadFileName")
                                        .html("");
                                    $uploadHTML
                                        .find(".uploadProgress")
                                        .css({ width: "0%" });
                                    $uploadHTML.find(".filename").val("");
                                    $uploadHTML.find(".original_name").val("");
                                }
                                $elem.closest("li").remove();
                                $elem.parent().remove();
                            }
                        }
                    );
                }

                $("body").on("click", ".delUploadImage", function (e) {
                    e.preventDefault();
                    var $elem = $(this);
                    if (typeof Swal == "undefined") {
                        if (confirm("Are you sure?")) {
                            deleteFile($elem, $elem.attr("data-id"));
                        }
                    } else {
                        Swal.fire({
                            title: window.appTrans.areYouSure,
                            text: window.appTrans.cannotRevert,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: window.appTrans.yes,
                        }).then((result) => {
                            if (result.value) {
                                deleteFile($elem, $elem.attr("data-id"));
                            }
                        });
                    }
                });
            });
        },
        createMediaUploader: function (
            URL,
            resultDivID,
            downloadPath,
            basePath
        ) {
            $("#youtubeURL").on("keydown", function (e) {
                // console.log($(this).val());
                var videoID = PGSADMIN.utils.getYoutubeID($(this).val());
                if (!videoID) {
                    $("#youtubeURL").addClass("error");
                    $("#youtube_thumb").attr(
                        "src",
                        window.baseURL +
                            "assets/admin/img/def-youtube-thumb.png"
                    );
                } else {
                    $("#youtubeURL").removeClass("error");
                    $("#youtube_thumb").attr(
                        "src",
                        "https://img.youtube.com/vi/" +
                            videoID +
                            "/hqdefault.jpg"
                    );
                    $("#changeImage").attr("href", "#");
                    //$('#chCoverWrapper').addClass('btn').addClass('btn-primary');
                    //$('#saveWrapper').addClass('btn').addClass('btn-success');
                }
            });

            $("#youtubeURL").on("paste", function (e) {
                PGSADMIN.utils.catchPaste(e, this, function (url) {
                    var videoID = PGSADMIN.utils.getYoutubeID(url);
                    if (!videoID) {
                        // console.log('add class');
                        $("#youtubeURL").addClass("error");
                        $("#youtube_thumb").attr(
                            "src",
                            basePath + "assets/admin/img/def-youtube-thumb.png"
                        );
                        return false;
                    }
                    $("#youtubeURL").removeClass("error");
                    $("#youtube_thumb").attr(
                        "src",
                        "https://img.youtube.com/vi/" +
                            videoID +
                            "/hqdefault.jpg"
                    );
                    $("#changeImage").attr("href", "#");
                    //$('#chCoverWrapper').addClass('btn').addClass('btn-primary');
                    //$('#saveWrapper').addClass('btn').addClass('btn-success');
                });
            });

            $("#saveYoutube").on("click", function (e) {
                e.preventDefault();
                var resultDiv = $(this).attr("data-resultDiv");
                var url = $("#youtubeURL").val();
                var videoID = PGSADMIN.utils.getYoutubeID(url);
                if (!videoID) {
                    $("#youtubeURL").addClass("error");
                    return false;
                }
                var dataToSend = {};
                $(".ytInput").each(function (i, v) {
                    var name = $(this).attr("name");
                    var val = $(this).val();
                    dataToSend[name] = val;
                });
                //console.log(dataToSend);
                PGSADMIN.utils.sendAjax(
                    window.saveYoutubeURL,
                    "POST",
                    dataToSend,
                    function (responseData) {
                        // console.log(PGSADMIN.utils.createFileHolder('video',basePath,responseData,downloadPath));
                        if (resultDiv && responseData.status) {
                            $("#" + resultDiv).append(
                                PGSADMIN.utils.createFileHolder(
                                    "video",
                                    basePath,
                                    responseData.data,
                                    downloadPath
                                )
                            );
                            $("#youtubeURL").val("");
                            $("#customImage").val("");
                            $("#youtube_thumb").attr("src", "");
                        }
                    }
                );
            });

            $(".multiuploader").each(function (i, v) {
                var _this = $(this);
                var _type = $(this).attr("data-type");
                var _slug = $(this).attr("data-slug");
                var _name = $(this).attr("name");

                var _mimeTypesTmp = $(this).attr("data-allowed");
                if (!_type) {
                    _type = "default";
                }
                if (!_mimeTypesTmp) {
                    _mimeTypes = [
                        { title: "Pdf Document", extensions: "pdf" },
                        { title: "Word Document", extensions: "doc" },
                        { title: "Word Document", extensions: "docx" },
                        { title: "Word Document", extensions: "odt" },
                        { title: "Image file", extensions: "jpg" },
                        { title: "Image file", extensions: "jpeg" },
                        { title: "Image file", extensions: "png" },
                        { title: "Image file", extensions: "svg" },
                    ];
                } else {
                    _mimeTypes = [];
                    var _spitArr = _mimeTypesTmp.split(",");

                    $.each(_spitArr, function (i, v) {
                        _mimeTypes.push({ title: "document", extensions: v });
                    });
                }

                var uploader = new plupload.Uploader({
                    runtimes: "html5,flash,silverlight,html4",
                    browse_button: $(this).attr("id"), // you can pass in id...
                    url: URL,
                    multi_selection: true,
                    /* resize: {
								width: 100,
								height: 100
							  }, */
                    filters: {
                        max_file_size: "100mb",
                        mime_types: _mimeTypes,
                    },
                    multipart_params: {
                        controlName: _type,
                        slug: _slug + "_gallery",
                        name: _name,
                    },
                    headers: { "X-CSRF-TOKEN": window.Laravel.csrfToken },
                    init: {
                        PostInit: function () {},

                        BeforeUpload: function (up, files) {
                            var status_before = files.status;
                            _this
                                .closest(".input_parent")
                                .find(".uploadProgress")
                                .css({ width: "0%" });
                            _this
                                .closest(".input_parent")
                                .find(".uploadPercentage")
                                .html("");

                            uploader.settings.url = URL;
                        },
                        FilesAdded: function (up, files) {
                            _this
                                .closest(".input_parent")
                                .find(".uploadFileName")
                                .html(files[0].name);
                            _this
                                .closest(".input_parent")
                                .find('input[type="file"]')
                                .attr("required", true);
                            /* _this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').removeClass('uploaded')
									_this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').addClass('uploading') */
                            uploader.start();
                        },

                        UploadProgress: function (up, file) {
                            _this
                                .closest(".input_parent")
                                .find(".uploadProgress")
                                .css({ width: file.percent + "%" });
                            _this
                                .closest(".input_parent")
                                .find(".uploadPercentage")
                                .html(file.percent + "%");
                        },
                        FileUploaded: function (up, file, response) {
                            var t = response.response;

                            try {
                                var rt = $.parseJSON(t);
                                if (rt.status == true) {
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .removeClass("error");
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .next("label")
                                        .hide();
                                    _this
                                        .closest(".input_parent")
                                        .find('input[type="file"]')
                                        .attr("required", false);
                                    _this
                                        .closest(".input_parent")
                                        .find(".filename")
                                        .val(rt.data.fileName);
                                    _this
                                        .closest(".input_parent")
                                        .find(".original_name")
                                        .val(file.name);

                                    var fileHTML, fileType;
                                    fileType = _type;

                                    if (
                                        typeof rt.data.fileType != "undefined"
                                    ) {
                                        fileType = rt.data.fileType;
                                    } else if (
                                        typeof rt.fileType != "undefined"
                                    ) {
                                        fileType = rt.fileType;
                                    }
                                    if (
                                        typeof fileType == "undefined" &&
                                        typeof rt.data.type != "undefined"
                                    ) {
                                        fileType = rt.data.type;
                                    }

                                    if (
                                        jQuery.inArray(rt.data.mimeType, [
                                            "image/jpeg",
                                            "image/png",
                                            "image/gif",
                                            "image/svg+xml",
                                        ]) !== -1
                                    ) {
                                        fileHTML =
                                            PGSADMIN.utils.createFileHolder(
                                                "image",
                                                basePath,
                                                rt.data,
                                                downloadPath
                                            );
                                    } else if (
                                        jQuery.inArray(rt.data.mimeType, [
                                            "application/pdf",
                                        ]) !== -1
                                    ) {
                                        fileHTML =
                                            PGSADMIN.utils.createFileHolder(
                                                "pdf",
                                                basePath,
                                                rt.data,
                                                downloadPath
                                            );
                                    } else if (
                                        jQuery.inArray(rt.data.mimeType, [
                                            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                                        ]) !== -1
                                    ) {
                                        fileHTML =
                                            PGSADMIN.utils.createFileHolder(
                                                "word",
                                                basePath,
                                                rt.data,
                                                downloadPath
                                            );
                                    } else {
                                        fileHTML =
                                            PGSADMIN.utils.createFileHolder(
                                                "file",
                                                basePath,
                                                rt.data,
                                                downloadPath
                                            );
                                    }

                                    fileHTML += "";
                                    $(".myFileLister").append(fileHTML);
                                    _this
                                        .closest(".fileUploadWrapper")
                                        .find(".uploadPreview")
                                        .remove();

                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadFileName")
                                        .html("");
                                    _this
                                        .closest(".input_parent")
                                        .find(".original_name")
                                        .val("");
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadProgress")
                                        .css({ width: "0%" });
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadPercentage")
                                        .html("");
                                } else {
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadFileName")
                                        .html("");
                                    _this
                                        .closest(".input_parent")
                                        .find(".original_name")
                                        .val("");
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadProgress")
                                        .css({ width: "0%" });
                                    _this
                                        .closest(".input_parent")
                                        .find(".uploadPercentage")
                                        .html("");

                                    if (typeof swal == "undefined") {
                                        alert(window.appTrans.invalidFile);
                                    } else {
                                        swal.fire({
                                            title: window.appTrans.error,
                                            text: rt.response,
                                            type: "warning",
                                            confirmButtonText:
                                                window.appTrans.ok,
                                            confirmButtonColor: "#000",
                                            closeOnConfirm: false,
                                        });
                                    }
                                }
                            } catch (ex) {
                                //console.log(ex);
                                Swal.fire({
                                    text: "Network Error Occured. Please try again.",
                                    type: "error",
                                });
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadFileName")
                                    .html("");
                                _this
                                    .closest(".input_parent")
                                    .find(".filename")
                                    .val("");
                                _this
                                    .closest(".input_parent")
                                    .find(".original")
                                    .val("");
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadProgress")
                                    .css({ width: "0%" });
                                _this
                                    .closest(".input_parent")
                                    .find(".uploadPercentage")
                                    .html("");
                            }
                        },
                        UploadComplete: function (up, files) {
                            //$('#loader').hide();
                            // $('.uploadWrapperParent').addClass('uploaded')
                            uploader.splice();
                        },
                        Error: function (up, err) {
                            if (typeof swal == "undefined") {
                                alert(window.appTrans.invalidFile);
                            } else {
                                swal.fire({
                                    title: window.appTrans.error,
                                    text:
                                        window.appTrans.invalidFile +
                                        err.message,
                                    type: "warning",
                                    confirmButtonText: window.appTrans.ok,
                                    confirmButtonColor: "#000",
                                    closeOnConfirm: false,
                                });
                            }
                        },
                    },
                });

                uploader.init();

                galleryUploaders.push(uploader);
            });

            $(document).ready(function () {
                function deleteMultiFile($elem, fileId) {
                    if (!fileId) {
                        console.log("Invalid File name");
                        return false;
                    }
                    var url = window.postMediaDelURL + fileId;

                    PGSADMIN.utils.sendAjax(
                        url,
                        "GET",
                        {},
                        function (response) {
                            if ($.fn.sticky && response.msgClass) {
                                $.sticky(response.message, {
                                    classList: response.msgClass,
                                    position: "top-center",
                                    speed: "slow",
                                });
                            }

                            if (response.status) {
                                $elem.closest(".custCardWrapper").remove();
                            }
                        }
                    );
                }

                $(".myFileLister").on("click", ".delUploadImage", function (e) {
                    e.preventDefault();
                    var $elem = $(this);
                    if (typeof Swal == "undefined") {
                        if (confirm("Are you sure?")) {
                            deleteMultiFile($elem, $elem.attr("data-id"));
                        }
                    } else {
                        Swal.fire({
                            title: window.appTrans.areYouSure,
                            text: window.appTrans.cannotRevert,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: window.appTrans.yes,
                        }).then((result) => {
                            if (result.value) {
                                deleteMultiFile($elem, $elem.attr("data-id"));
                            }
                        });
                    }
                });
            });
        },
    };
    _self.init = function () {
        $(".dirChange").on("change", function (e) {
            var tt = $(this).val();
            if (PGSADMIN.utils.isArabic(tt)) {
                $(this).attr("dir", "rtl");
            } else {
                $(this).attr("dir", "ltr");
            }
        });
        $(".dirChange").on("keyup", function (e) {
            var tt = $(this).val();
            if (PGSADMIN.utils.isArabic(tt)) {
                $(this).attr("dir", "rtl");
            } else {
                $(this).attr("dir", "ltr");
            }
        });

        $("body").on("click", ".delRow", function (e) {
            e.preventDefault();
            var elem = this;
            var delURL = $(this).attr("href");
            if (typeof swal == "undefined") {
                if (confirm("Are you sure?")) {
                    PGSADMIN.utils.sendAjax(
                        delURL,
                        "get",
                        {},
                        function (responseData) {
                            $(elem).closest("tr").remove();
                            $.sticky(responseData.message, {
                                classList: responseData.msgClass,
                                position: "top-center",
                                speed: "slow",
                            });
                        }
                    );
                }
            } else {
                swal(
                    {
                        title: "Are you sure?",
                        showCancelButton: true,
                    },
                    function () {
                        PGSADMIN.utils.sendAjax(
                            delURL,
                            "get",
                            {},
                            function (responseData) {
                                $(elem).closest("tr").remove();
                                $.sticky(responseData.message, {
                                    classList: responseData.msgClass,
                                    position: "top-center",
                                    speed: "slow",
                                });
                            }
                        );
                    }
                );
            }
        });

        $(".table").basictable({
            breakpoint: 768,
        });
        $(".custom-select").select2({});
    };
    _self.singleUploadResponseHandler = function (
        responseData,
        type,
        targetID
    ) {
        if (
            type == "table" &&
            $(targetID).length &&
            responseData.status == true
        ) {
            var delURL =
                window.baseURL +
                window.adminPrefix +
                "resource_manager/delete_attachment/" +
                responseData.fileID;
            var hiddenInput =
                '<input type="hidden" name="resource_attachments[]" value="' +
                responseData.fileID +
                '" />';

            var tdHTML =
                "<tr><td>" +
                ($(targetID + " tbody > tr").length + 1) +
                hiddenInput +
                "</td><td>" +
                responseData.fileName +
                "</td><td>" +
                responseData.fileSize +
                '</td><td><a data-id="' +
                responseData.fileID +
                '" class="delRow" href="' +
                delURL +
                '">Delete</a></td></tr>';

            $("#res_attach > tbody").append(tdHTML);
        }
    };
    return _self;
})();
