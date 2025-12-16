/**
 * =================================================================
 * FILE: assets/js/admin-dashboard.js
 * =================================================================
 * Alpine.js application for Theme Builder dashboard
 */

function themeBuilder() {
    return {
        // State
        loading: true,
        templates: [],
        headerTemplates: [],
        footerTemplates: [],
        showCreateModal: false,
        showConditionsModal: false,
        newTemplate: {
            title: '',
            type: 'header'
        },
        editingTemplate: {
            id: null,
            conditions: {
                type: 'global',
                page_ids: '',
                post_ids: '',
                post_type: ''
            }
        },
        // Initialize
        async init() {
            await this.loadTemplates();
            this.loading = false;
        },
        
        // Load templates from API
        async loadTemplates() {
            try {
                const response = await fetch(elematicData.restUrl + '/templates', {
                    headers: {
                        'X-WP-Nonce': elematicData.restNonce
                    }
                });
                
                if (!response.ok) throw new Error('Failed to load templates');
                
                this.templates = await response.json();
                this.headerTemplates = this.templates.filter(t => t.type === 'header');
                this.footerTemplates = this.templates.filter(t => t.type === 'footer');
            } catch (error) {
                console.error('Error loading templates:', error);
                alert('Failed to load templates. Please refresh the page.');
            }
        },
        
        
        // Create new template
        async createTemplate(type = null) {
            if (type) {
                this.newTemplate.type = type;
                this.showCreateModal = true;
                return;
            }
            
            if (!this.newTemplate.title || !this.newTemplate.type) {
                alert('Please enter a template name and select a type.');
                return;
            }
            
            try {
                // Create post via AJAX
                const formData = new FormData();
                formData.append('action', 'elematic_create_template');
                formData.append('nonce', elematicData.nonce);
                formData.append('title', this.newTemplate.title);
                formData.append('type', this.newTemplate.type);
                
                const response = await fetch(elematicData.ajaxUrl, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Redirect to Elementor editor
                    window.location.href = data.data.edit_url;
                } else {
                    throw new Error(data.data.message || 'Failed to create template');
                }
            } catch (error) {
                console.error('Error creating template:', error);
                alert('Failed to create template. Please try again.');
            }
        },
        
        // Edit conditions
        editConditions(template) {
            // Deep clone and ensure conditions object exists
            this.editingTemplate = {
                id: template.id,
                title: template.title,
                conditions: template.conditions || { type: 'global' }
            };
            
            // Ensure all condition properties exist
            if (!this.editingTemplate.conditions.page_ids) {
                this.editingTemplate.conditions.page_ids = '';
            }
            if (!this.editingTemplate.conditions.post_ids) {
                this.editingTemplate.conditions.post_ids = '';
            }
            if (!this.editingTemplate.conditions.post_type) {
                this.editingTemplate.conditions.post_type = '';
            }
            
            this.showConditionsModal = true;
        },
        
        // Save conditions
        async saveConditions() {
            try {
                await fetch(elematicData.restUrl + '/template/' + this.editingTemplate.id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': elematicData.restNonce
                    },
                    body: JSON.stringify({
                        conditions: this.editingTemplate.conditions
                    })
                });
                
                // Update local state
                const template = this.templates.find(t => t.id === this.editingTemplate.id);
                if (template) {
                    template.conditions = this.editingTemplate.conditions;
                }
                
                this.showConditionsModal = false;
                
                // Show success message
                this.showNotification('Conditions saved successfully!');
            } catch (error) {
                console.error('Error saving conditions:', error);
                alert('Failed to save conditions. Please try again.');
            }
        },
        
        // Duplicate template
        async duplicateTemplate(template) {
            try {
                const formData = new FormData();
                formData.append('action', 'elematic_duplicate_template');
                formData.append('nonce', elematicData.nonce);
                formData.append('template_id', template.id);
                
                const response = await fetch(elematicData.ajaxUrl, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Reload templates
                    await this.loadTemplates();
                    this.showNotification('Template duplicated successfully!');
                } else {
                    throw new Error(data.data.message || 'Failed to duplicate template');
                }
            } catch (error) {
                console.error('Error duplicating template:', error);
                alert('Failed to duplicate template. Please try again.');
            }
        },
        
        // Delete template
        async deleteTemplate(template) {
            if (!confirm(`Are you sure you want to delete "${template.title}"? This action cannot be undone.`)) {
                return;
            }
            
            try {
                await fetch(elematicData.restUrl + '/template/' + template.id, {
                    method: 'DELETE',
                    headers: {
                        'X-WP-Nonce': elematicData.restNonce
                    }
                });
                
                // Remove from local state
                this.templates = this.templates.filter(t => t.id !== template.id);
                this.headerTemplates = this.headerTemplates.filter(t => t.id !== template.id);
                this.footerTemplates = this.footerTemplates.filter(t => t.id !== template.id);
                
                this.showNotification('Template deleted successfully! Cache cleared.');
                
                // Clear cache on frontend (force refresh next page load)
                this.clearCache();
            } catch (error) {
                console.error('Error deleting template:', error);
                alert('Failed to delete template. Please try again.');
            }
        },
        
        // Clear template cache
        async clearCache() {
            try {
                await fetch(elematicData.ajaxUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'elematic_clear_cache',
                        nonce: elematicData.nonce
                    })
                });
            } catch (error) {
                console.error('Error clearing cache:', error);
            }
        },
        
        // Get condition label
        getConditionLabel(conditions) {
            if (!conditions || !conditions.type) {
                return 'No conditions set';
            }
            
            const labels = {
                'none': '⚠️ Inactive',
                'global': 'Entire Site',
                'all_pages': 'All Pages',
                'all_posts': 'All Posts',
                'specific_pages': 'Specific Pages',
                'specific_posts': 'Specific Posts',
                'post_type': 'Custom Post Type: ' + (conditions.post_type || '')
            };
            
            return labels[conditions.type] || 'Unknown';
        },
        
        // Show notification
        showNotification(message) {
            // Simple notification - you can enhance this
            const notification = document.createElement('div');
            notification.className = 'elematic-notification';
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    };
}

/**
 * =================================================================
 * AJAX Handler for Creating Template
 * Add this to: includes/theme-builder/class-rest-api.php
 * =================================================================
 */
// PHP Code to add to class-rest-api.php:
/*
public function __construct() {
    // ... existing code ...
    add_action('wp_ajax_elematic_create_template', [$this, 'ajax_create_template']);
}

public function ajax_create_template() {
    check_ajax_referer('elematic_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Unauthorized']);
    }
    
    $title = sanitize_text_field($_POST['title']);
    $type = sanitize_text_field($_POST['type']);
    
    // Create post
    $post_id = wp_insert_post([
        'post_title' => $title,
        'post_type' => 'elematic_template',
        'post_status' => 'publish',
    ]);
    
    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => $post_id->get_error_message()]);
    }
    
    // Set type taxonomy
    wp_set_object_terms($post_id, $type, 'elematic_template_type');
    
    // Set default priority
    update_post_meta($post_id, '_elematic_priority', 999);
    
    // Set default conditions
    update_post_meta($post_id, '_elematic_conditions', ['type' => 'global']);
    
    // Set Elementor template type
    update_post_meta($post_id, '_elementor_template_type', 'page');
    
    // Set canvas template
    update_post_meta($post_id, '_wp_page_template', 'elementor_canvas');
    
    wp_send_json_success([
        'id' => $post_id,
        'edit_url' => admin_url('post.php?post=' . $post_id . '&action=elementor')
    ]);
}
*/