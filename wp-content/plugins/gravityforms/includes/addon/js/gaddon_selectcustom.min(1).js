jQuery(document).ready(function(a){a(".gaddon-setting-select-custom").on("change",function(){"gf_custom"==a(this).val()&&a(this).hide().siblings(".gaddon-setting-select-custom-container").show()}),a(".gaddon-setting-select-custom-container .select-custom-reset").on("click",function(b){b.preventDefault();var c=a(this).closest(".gaddon-setting-select-custom-container"),d=c.prev("select.gaddon-setting-select-custom");c.fadeOut(function(){c.find("input").val("").change(),d.fadeIn().focus().val("")})})});