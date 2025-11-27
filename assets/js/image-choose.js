jQuery(window).on("elementor:init", function() {
    "use strict";
    
    var BaseDataControl = elementor.modules.controls.BaseData;
    
    var ImageChooseControl = BaseDataControl.extend({
        
        ui: function() {
            var baseUI = BaseDataControl.prototype.ui.apply(this, arguments);
            baseUI.inputs = '[type="radio"]';
            return baseUI;
        },
        
        events: function() {
            return _.extend(BaseDataControl.prototype.events.apply(this, arguments), {
                "click @ui.inputs": "onClickInput",
                "change @ui.inputs": "onBaseInputChange"
            });
        },
        
        onClickInput: function(event) {
            var input = jQuery(event.currentTarget);
            
            // Remove checked class from all inputs
            this.ui.inputs.removeClass("checked");
            
            // Add checked class to clicked input
            if (input.prop("checked")) {
                input.addClass("checked");
            }
        },
        
        onRender: function() {
            BaseDataControl.prototype.onRender.apply(this, arguments);
            
            var controlValue = this.getControlValue();
            
            if (controlValue) {
                this.ui.inputs.filter('[value="' + controlValue + '"]').prop("checked", true);
                this.ui.inputs.filter('[value="' + controlValue + '"]').addClass("checked");
            }
        }
        
    }, {
        
        onPasteStyle: function(controlOptions, value) {
            return value === "" || undefined !== controlOptions.options[value];
        }
        
    });
    
    elementor.addControlView("elematic-image-choose", ImageChooseControl);
    
});