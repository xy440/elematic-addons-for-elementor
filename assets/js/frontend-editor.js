/**
 * =================================================================
 * FILE: assets/js/frontend-editor.js
 * =================================================================
 * Frontend editor with modal iframe overlay
 * 
 * Opens Elementor editor in a full-screen modal overlay
 */

(function() {
    // Create modal HTML in the top-level document, not in any iframe
    function createModalIfNeeded() {
        if (document.getElementById('elematic-editor-modal')) {
            return;
        }
        
        const modal = document.createElement('div');
        modal.id = 'elematic-editor-modal';
        modal.className = 'elematic-editor-modal';
        modal.style.display = 'none';
        modal.innerHTML = `
            <div class="elematic-editor-modal-overlay"></div>
            <div class="elematic-editor-modal-content">
                <div class="elematic-editor-modal-header">
                    <button class="elematic-editor-close" id="elematic-editor-close-btn">&times;</button>
                </div>
                <iframe id="elematic-editor-iframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        `;
        document.documentElement.appendChild(modal);
    }
    
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', createModalIfNeeded);
    } else {
        createModalIfNeeded();
    }
    
    // Wait for jQuery if needed
    if (typeof jQuery !== 'undefined') {
        jQuery(document).ready(function($) {
            setupModal($);
        });
    } else {
        // Fallback if jQuery isn't loaded
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof jQuery !== 'undefined') {
                setupModal(jQuery);
            }
        });
    }
    
    function setupModal($) {
        const modal = document.getElementById('elematic-editor-modal');
        const iframe = document.getElementById('elematic-editor-iframe');
        const overlay = document.querySelector('.elematic-editor-modal-overlay');
        const closeBtn = document.getElementById('elematic-editor-close-btn');
        
        // Hide edit buttons on template's own page
        if (document.body.classList.contains('post-type-elematic_template')) {
            $('.elematic-edit-btn').hide();
            return;
        }
        
        // Open editor modal on edit button click
        $(document).on('click', '.elematic-edit-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const templateId = $(this).data('template-id');
            
            // Build admin edit URL
            const editUrl = new URL(window.location.origin + '/wp-admin/post.php');
            editUrl.searchParams.append('post', templateId);
            editUrl.searchParams.append('action', 'elementor');
            
            // Set iframe src and show modal
            iframe.src = editUrl.toString();
            modal.style.display = 'flex';
        });
        
        // Close modal
        function closeModal() {
            modal.style.display = 'none';
            iframe.src = '';
        }
        
        // Close on close button click
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });
        }
        
        // Close on overlay click
        $(overlay).on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeModal();
        });
        
        // Close on ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display !== 'none') {
                e.preventDefault();
                closeModal();
            }
        });
        
        // Add keyboard shortcut (Alt + E) to open header editor
        $(document).on('keydown', function(e) {
            if (e.altKey && e.key === 'e') {
                e.preventDefault();
                const $headerBtn = $('.elematic-edit-header').first();
                if ($headerBtn.length) {
                    $headerBtn.click();
                }
            }
        });
        
        // Add keyboard shortcut (Alt + F) to open footer editor
        $(document).on('keydown', function(e) {
            if (e.altKey && e.key === 'f') {
                e.preventDefault();
                const $footerBtn = $('.elematic-edit-footer').first();
                if ($footerBtn.length) {
                    $footerBtn.click();
                }
            }
        });
    }
})();
