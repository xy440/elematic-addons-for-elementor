/**
 * Inline header/footer/page editing inside the Elementor editor preview.
 */
(function($) {
    'use strict';

    var regionSetupAttempts = 0;
    var editorWaitAttempts = 0;
    var maxSetupAttempts = 20;
    var buttonTemplates = {};

    function getEditorWindow() {
        try {
            if (window.parent && window.parent.elementor && window.parent.$e) {
                return window.parent;
            }
        } catch (e) {
            return null;
        }

        return null;
    }

    function switchToTemplate(templateId) {
        var editorWin = getEditorWindow();

        if (!editorWin) {
            return false;
        }

        var id = parseInt(templateId, 10);

        if (!id) {
            return false;
        }

        editorWin.$e.run('editor/documents/switch', { id: id });
        return true;
    }

    function switchToPage() {
        var editorWin = getEditorWindow();

        if (!editorWin || !editorWin.elementor || !editorWin.elementor.config.initial_document) {
            return false;
        }

        return switchToTemplate(editorWin.elementor.config.initial_document.id);
    }

    function showEditPageButton() {
        $('.elematic-edit-page').addClass('is-visible');
    }

    function hideEditPageButton() {
        $('.elematic-edit-page').removeClass('is-visible');
    }

    function isThemePartDocument(documentModel) {
        if (!documentModel || !documentModel.config) {
            return false;
        }

        var type = documentModel.config.type;
        return type === 'header' || type === 'footer';
    }

    function syncEditPageVisibility(documentModel) {
        var editorWin = getEditorWindow();

        if (!editorWin || !editorWin.elementor || !editorWin.elementor.config.initial_document) {
            return;
        }

        if (!documentModel) {
            documentModel = editorWin.elementor.documents.getCurrent();
        }

        if (!documentModel) {
            return;
        }

        var initialId = editorWin.elementor.config.initial_document.id;

        if (documentModel.id === initialId) {
            hideEditPageButton();
        } else if (isThemePartDocument(documentModel)) {
            showEditPageButton();
        }

        syncRegionEditState(documentModel);
    }

    function syncRegionEditState(documentModel) {
        $('body').removeClass('elematic-editing-header elematic-editing-footer');

        if (!documentModel || !documentModel.config) {
            return;
        }

        if (documentModel.config.type === 'header') {
            $('body').addClass('elematic-editing-header');
        } else if (documentModel.config.type === 'footer') {
            $('body').addClass('elematic-editing-footer');
        }
    }

    function cacheButtonTemplates() {
        var $headerBtn = $('.elematic-edit-header').first();
        var $footerBtn = $('.elematic-edit-footer').first();

        if ($headerBtn.length) {
            buttonTemplates.header = $headerBtn.first().clone(true);
        }

        if ($footerBtn.length) {
            buttonTemplates.footer = $footerBtn.first().clone(true);
        }
    }

    function restoreMissingButton(type) {
        var selector = '.elematic-edit-' + type;

        if ($(selector).length || !buttonTemplates[type]) {
            return;
        }

        var $store = $('.elematic-frontend-editor').first();

        if (!$store.length) {
            return;
        }

        $store.append(buttonTemplates[type].clone(true));
    }

    function attachButtonToRegion($button, $region) {
        if (!$button.length || !$region.length) {
            return;
        }

        $region.addClass('elematic-edit-region');

        if (!$button.closest($region).length) {
            $region.append($button);
        }
    }

    function ensureRegionButtons() {
        restoreMissingButton('header');
        restoreMissingButton('footer');

        attachButtonToRegion($('.elematic-edit-header').first(), $('.elematic-custom-header').first());
        attachButtonToRegion($('.elematic-edit-footer').first(), $('.elematic-custom-footer').first());
    }

    function setupRegionButtons() {
        var $header = $('.elematic-custom-header').first();
        var $footer = $('.elematic-custom-footer').first();

        if ((!$header.length && $('.elematic-edit-header').length) ||
            (!$footer.length && $('.elematic-edit-footer').length)) {
            if (regionSetupAttempts < maxSetupAttempts) {
                regionSetupAttempts++;
                setTimeout(setupRegionButtons, 150);
            }
            return;
        }

        ensureRegionButtons();
    }

    function bindDocumentSwitchListener() {
        var editorWin = getEditorWindow();

        if (!editorWin || !editorWin.elementor || editorWin.elematicDocumentListenerBound) {
            return;
        }

        editorWin.elematicDocumentListenerBound = true;

        editorWin.elementor.on('document:loaded', function(documentModel) {
            syncEditPageVisibility(documentModel);
            ensureRegionButtons();
            setTimeout(ensureRegionButtons, 150);
        });

        syncEditPageVisibility();
    }

    var eventsBound = false;

    function bindEvents() {
        if (eventsBound) {
            return;
        }

        eventsBound = true;

        $(document).on('click', '.elematic-edit-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();

            if ($(this).hasClass('elematic-edit-page')) {
                hideEditPageButton();
                $('body').removeClass('elematic-editing-header elematic-editing-footer');
                switchToPage();
                return;
            }

            if ($(this).hasClass('elematic-edit-header')) {
                showEditPageButton();
                $('body').addClass('elematic-editing-header').removeClass('elematic-editing-footer');
            }

            if ($(this).hasClass('elematic-edit-footer')) {
                showEditPageButton();
                $('body').addClass('elematic-editing-footer').removeClass('elematic-editing-header');
            }

            switchToTemplate($(this).data('template-id'));
        });

        $(document).on('keydown', function(e) {
            if (!e.altKey) {
                return;
            }

            if (e.key === 'e') {
                e.preventDefault();
                var $headerBtn = $('.elematic-edit-header').first();
                if ($headerBtn.length) {
                    $headerBtn.trigger('click');
                }
            }

            if (e.key === 'p') {
                e.preventDefault();
                var $pageBtn = $('.elematic-edit-page.is-visible').first();
                if ($pageBtn.length) {
                    $pageBtn.trigger('click');
                }
            }

            if (e.key === 'f') {
                e.preventDefault();
                var $footerBtn = $('.elematic-edit-footer').first();
                if ($footerBtn.length) {
                    $footerBtn.trigger('click');
                }
            }
        });
    }

    function initEditorUI() {
        cacheButtonTemplates();
        setupRegionButtons();
        bindDocumentSwitchListener();
        hideEditPageButton();
    }

    function waitForEditor() {
        if (document.body.classList.contains('post-type-elematic_template')) {
            return;
        }

        if (!$('body').hasClass('elementor-editor-active')) {
            if (editorWaitAttempts < maxSetupAttempts) {
                editorWaitAttempts++;
                setTimeout(waitForEditor, 150);
            }
            return;
        }

        bindEvents();
        initEditorUI();
    }

    function init() {
        waitForEditor();
    }

    $(init);
})(jQuery);
