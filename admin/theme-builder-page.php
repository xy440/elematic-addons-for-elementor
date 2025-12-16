<!-- 
=================================================================
FILE: admin/theme-builder-page.php
=================================================================
This is the main admin page for Theme Builder
Uses Alpine.js for interactivity
-->

<div class="elematic-dashboard" x-data="themeBuilder()" x-init="init()">
    
    <!-- Header -->
    <div class="elematic-header">
        <div class="elematic-header-content">
            <div>
                <h1><?php esc_html_e('Theme Builder', 'elematic-addons-for-elementor'); ?></h1>
                <p><?php esc_html_e('Create and manage custom headers and footers with Elementor', 'elematic-addons-for-elementor'); ?></p>
            </div>
            
            <button @click="showCreateModal = true" class="elematic-btn elematic-btn-primary">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3V13M3 8H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <?php esc_html_e('Add New', 'elematic-addons-for-elementor'); ?>
            </button>
        </div>
    </div>
    
    <!-- Loading State -->
    <div x-show="loading" class="elematic-loading">
        <div class="elematic-spinner"></div>
        <p><?php esc_html_e('Loading templates...', 'elematic-addons-for-elementor'); ?></p>
    </div>
    
    <!-- Main Content -->
    <div x-show="!loading" class="elematic-content">
        
        <!-- Headers Section -->
        <div class="elematic-section">
            <div class="elematic-section-header">
                <h2>
                    <span class="elematic-icon">📋</span>
                    <?php esc_html_e('Headers', 'elematic-addons-for-elementor'); ?>
                </h2>
                <span class="elematic-count" x-text="headerTemplates.length + ' template(s)'"></span>
            </div>
            
            <div class="elematic-templates-list" id="header-templates-list">
                <template x-for="(template, index) in headerTemplates" :key="template.id">
                    <div class="elematic-template-card" :data-id="template.id">
                        <!-- Template Info -->
                        <div class="elematic-template-info">
                            <h3 x-text="template.title"></h3>
                            <div class="elematic-template-meta">
                                <span class="elematic-condition-badge">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                        <path d="M6 1L7 5H11L8 8L9 11L6 9L3 11L4 8L1 5H5L6 1Z" stroke="currentColor" stroke-width="1"/>
                                    </svg>
                                    <span x-text="getConditionLabel(template.conditions)"></span>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="elematic-template-actions">
                            <a :href="template.edit_url" class="elematic-btn elematic-btn-secondary">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M11 1L13 3L7 9L5 10L6 8L11 1Z" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                <?php esc_html_e('Edit', 'elematic-addons-for-elementor'); ?>
                            </a>
                            
                            <button @click="editConditions(template)" class="elematic-btn elematic-btn-conditions">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <circle cx="7" cy="7" r="6" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M7 4V7L9 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <?php esc_html_e('Conditions', 'elematic-addons-for-elementor'); ?>
                            </button>
                            
                            <button @click="duplicateTemplate(template)" class="elematic-btn elematic-btn-secondary" title="<?php esc_attr_e('Duplicate Template', 'elematic-addons-for-elementor'); ?>">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <rect x="1" y="5" width="7" height="8" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M6 1H10C11.1 1 12 1.9 12 3V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <?php esc_html_e('Duplicate', 'elematic-addons-for-elementor'); ?>
                            </button>
                            
                            <button @click="deleteTemplate(template)" class="elematic-btn elematic-btn-danger">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M3 3L11 11M11 3L3 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
                
                <!-- Empty State -->
                <div x-show="headerTemplates.length === 0" class="elematic-empty-state">
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                        <rect x="8" y="8" width="48" height="10" rx="2" fill="#E9ECEF"/>
                        <rect x="8" y="22" width="32" height="6" rx="2" fill="#E9ECEF"/>
                    </svg>
                    <p><?php esc_html_e('No header templates yet', 'elematic-addons-for-elementor'); ?></p>
                    <button @click="createTemplate('header')" class="elematic-btn elematic-btn-secondary">
                        <?php esc_html_e('Create Your First Header', 'elematic-addons-for-elementor'); ?>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Footers Section -->
        <div class="elematic-section">
            <div class="elematic-section-header">
                <h2>
                    <span class="elematic-icon">📋</span>
                    <?php esc_html_e('Footers', 'elematic-addons-for-elementor'); ?>
                </h2>
                <span class="elematic-count" x-text="footerTemplates.length + ' template(s)'"></span>
            </div>
            
            <div class="elematic-templates-list" id="footer-templates-list">
                <template x-for="(template, index) in footerTemplates" :key="template.id">
                    <div class="elematic-template-card" :data-id="template.id">
                        <!-- Template Info -->
                        <div class="elematic-template-info">
                            <h3 x-text="template.title"></h3>
                            <div class="elematic-template-meta">
                                <span class="elematic-condition-badge">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                        <path d="M6 1L7 5H11L8 8L9 11L6 9L3 11L4 8L1 5H5L6 1Z" stroke="currentColor" stroke-width="1"/>
                                    </svg>
                                    <span x-text="getConditionLabel(template.conditions)"></span>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="elematic-template-actions">
                            <a :href="template.edit_url" class="elematic-btn elematic-btn-secondary">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M11 1L13 3L7 9L5 10L6 8L11 1Z" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                <?php esc_html_e('Edit', 'elematic-addons-for-elementor'); ?>
                            </a>
                            
                            <button @click="editConditions(template)" class="elematic-btn elematic-btn-conditions">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <circle cx="7" cy="7" r="6" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M7 4V7L9 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <?php esc_html_e('Conditions', 'elematic-addons-for-elementor'); ?>
                            </button>
                            
                            <button @click="duplicateTemplate(template)" class="elematic-btn elematic-btn-secondary" title="<?php esc_attr_e('Duplicate Template', 'elematic-addons-for-elementor'); ?>">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <rect x="1" y="5" width="7" height="8" rx="1" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M6 1H10C11.1 1 12 1.9 12 3V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <?php esc_html_e('Duplicate', 'elematic-addons-for-elementor'); ?>
                            </button>
                            
                            <button @click="deleteTemplate(template)" class="elematic-btn elematic-btn-danger">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M3 3L11 11M11 3L3 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
                
                <!-- Empty State -->
                <div x-show="footerTemplates.length === 0" class="elematic-empty-state">
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                        <rect x="8" y="46" width="48" height="10" rx="2" fill="#E9ECEF"/>
                        <rect x="8" y="36" width="32" height="6" rx="2" fill="#E9ECEF"/>
                    </svg>
                    <p><?php esc_html_e('No footer templates yet', 'elematic-addons-for-elementor'); ?></p>
                    <button @click="createTemplate('footer')" class="elematic-btn elematic-btn-secondary">
                        <?php esc_html_e('Create Your First Footer', 'elematic-addons-for-elementor'); ?>
                    </button>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Create Template Modal -->
    <div x-show="showCreateModal" 
         x-cloak
         @click.self="showCreateModal = false"
         class="elematic-modal-overlay">
        <div class="elematic-modal">
            <div class="elematic-modal-header">
                <h2><?php esc_html_e('Create New Template', 'elematic-addons-for-elementor'); ?></h2>
                <button @click="showCreateModal = false" class="elematic-modal-close">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M5 5L15 15M15 5L5 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
            
            <div class="elematic-modal-body">
                <div class="elematic-form-group">
                    <label><?php esc_html_e('Template Name', 'elematic-addons-for-elementor'); ?></label>
                    <input type="text" 
                           x-model="newTemplate.title" 
                           @keyup.enter="createTemplate()"
                           placeholder="<?php esc_attr_e('Enter template name', 'elematic-addons-for-elementor'); ?>"
                           class="elematic-input">
                </div>
                
                <div class="elematic-form-group">
                    <label><?php esc_html_e('Template Type', 'elematic-addons-for-elementor'); ?></label>
                    <div class="elematic-radio-group">
                        <label class="elematic-radio">
                            <input type="radio" x-model="newTemplate.type" value="header">
                            <span><?php esc_html_e('Header', 'elematic-addons-for-elementor'); ?></span>
                        </label>
                        <label class="elematic-radio">
                            <input type="radio" x-model="newTemplate.type" value="footer">
                            <span><?php esc_html_e('Footer', 'elematic-addons-for-elementor'); ?></span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="elematic-modal-footer">
                <button @click="showCreateModal = false" class="elematic-btn elematic-btn-secondary">
                    <?php esc_html_e('Cancel', 'elematic-addons-for-elementor'); ?>
                </button>
                <button @click="createTemplate()" 
                        :disabled="!newTemplate.title || !newTemplate.type"
                        class="elematic-btn elematic-btn-primary">
                    <?php esc_html_e('Create & Edit', 'elematic-addons-for-elementor'); ?>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Conditions Modal -->
    <div x-show="showConditionsModal" 
         x-cloak
         @click.self="showConditionsModal = false"
         class="elematic-modal-overlay">
        <div class="elematic-modal elematic-modal-large">
            <div class="elematic-modal-header">
                <h2><?php esc_html_e('Display Conditions', 'elematic-addons-for-elementor'); ?></h2>
                <button @click="showConditionsModal = false" class="elematic-modal-close">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M5 5L15 15M15 5L5 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
            
            <div class="elematic-modal-body">
                <p class="elematic-modal-description">
                    <?php esc_html_e('Set the conditions that determine where your template is displayed throughout your site.', 'elematic-addons-for-elementor'); ?>
                </p>
                
                <div class="elematic-form-group">
                    <label><?php esc_html_e('Display On', 'elematic-addons-for-elementor'); ?></label>
                    <select x-model="editingTemplate.conditions.type" class="elematic-select">
                        <option value="none"><?php esc_html_e('No Conditions (Inactive)', 'elematic-addons-for-elementor'); ?></option>
                        <option value="global"><?php esc_html_e('Entire Site', 'elematic-addons-for-elementor'); ?></option>
                        <option value="all_pages"><?php esc_html_e('All Pages', 'elematic-addons-for-elementor'); ?></option>
                        <option value="all_posts"><?php esc_html_e('All Posts', 'elematic-addons-for-elementor'); ?></option>
                        <option value="specific_pages"><?php esc_html_e('Specific Pages', 'elematic-addons-for-elementor'); ?></option>
                        <option value="specific_posts"><?php esc_html_e('Specific Posts', 'elematic-addons-for-elementor'); ?></option>
                        <option value="post_type"><?php esc_html_e('Custom Post Type', 'elematic-addons-for-elementor'); ?></option>
                    </select>
                </div>
                
                <!-- Specific Pages -->
                <div x-show="editingTemplate.conditions.type === 'specific_pages'" class="elematic-form-group">
                    <label><?php esc_html_e('Select Pages', 'elematic-addons-for-elementor'); ?></label>
                    <input type="text" 
                           x-model="editingTemplate.conditions.page_ids" 
                           placeholder="<?php esc_attr_e('Enter page IDs (comma separated)', 'elematic-addons-for-elementor'); ?>"
                           class="elematic-input">
                    <small><?php esc_html_e('Example: 12, 45, 78', 'elematic-addons-for-elementor'); ?></small>
                </div>
                
                <!-- Specific Posts -->
                <div x-show="editingTemplate.conditions.type === 'specific_posts'" class="elematic-form-group">
                    <label><?php esc_html_e('Select Posts', 'elematic-addons-for-elementor'); ?></label>
                    <input type="text" 
                           x-model="editingTemplate.conditions.post_ids" 
                           placeholder="<?php esc_attr_e('Enter post IDs (comma separated)', 'elematic-addons-for-elementor'); ?>"
                           class="elematic-input">
                    <small><?php esc_html_e('Example: 12, 45, 78', 'elematic-addons-for-elementor'); ?></small>
                </div>
                
                <!-- Custom Post Type -->
                <div x-show="editingTemplate.conditions.type === 'post_type'" class="elematic-form-group">
                    <label><?php esc_html_e('Post Type', 'elematic-addons-for-elementor'); ?></label>
                    <input type="text" 
                           x-model="editingTemplate.conditions.post_type" 
                           placeholder="<?php esc_attr_e('Enter post type slug', 'elematic-addons-for-elementor'); ?>"
                           class="elematic-input">
                    <small><?php esc_html_e('Example: product, portfolio, team', 'elematic-addons-for-elementor'); ?></small>
                </div>
            </div>
            
            <div class="elematic-modal-footer">
                <button @click="showConditionsModal = false" class="elematic-btn elematic-btn-secondary">
                    <?php esc_html_e('Cancel', 'elematic-addons-for-elementor'); ?>
                </button>
                <button @click="saveConditions()" class="elematic-btn elematic-btn-primary">
                    <?php esc_html_e('Save Conditions', 'elematic-addons-for-elementor'); ?>
                </button>
            </div>
        </div>
    </div>
    
</div>
