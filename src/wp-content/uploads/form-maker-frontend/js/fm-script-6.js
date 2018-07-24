    var fm_currentDate = new Date();
    var FormCurrency_6 = '';
    var FormPaypalTax_6 = '0';
    var check_submit6 = 0;
    var check_before_submit6 = {};
    var required_fields6 = ["4","3","5"];
    var labels_and_ids6 = {"2":"type_text","4":"type_spinner","3":"type_spinner","5":"type_spinner","1":"type_submit_reset"};
    var check_regExp_all6 = [];
    var check_paypal_price_min_max6 = [];
    var file_upload_check6 = [];
    var spinner_check6 = {"4":["1",""],"3":["1","100"],"5":["0",""]};
    var scrollbox_trigger_point6 = '20';
    var header_image_animation6 = 'none';
    var scrollbox_loading_delay6 = '0';
    var scrollbox_auto_hide6 = '1';
         function before_load6() {	
}	
 function before_submit6() {
	 }	
 function before_reset6() {	
}
 function after_submit6() {
  
}
    function onload_js6() {
  jQuery("#form6 #wdform_4_element6")[0].spin = null;
  spinner = jQuery("#form6 #wdform_4_element6").spinner();
  if ("null" == "null" && jQuery("#form6 #wdform_4_element6").val() == "") { spinner.spinner("value", ""); }
  jQuery("#form6 #wdform_4_element6").spinner({ min: "1"});
  jQuery("#form6 #wdform_4_element6").spinner({ max: ""});
  jQuery("#form6 #wdform_4_element6").spinner({ step: "1"});
  jQuery("#form6 #wdform_3_element6")[0].spin = null;
  spinner = jQuery("#form6 #wdform_3_element6").spinner();
  if ("null" == "null" && jQuery("#form6 #wdform_3_element6").val() == "") { spinner.spinner("value", ""); }
  jQuery("#form6 #wdform_3_element6").spinner({ min: "1"});
  jQuery("#form6 #wdform_3_element6").spinner({ max: "100"});
  jQuery("#form6 #wdform_3_element6").spinner({ step: "1"});
  jQuery("#form6 #wdform_5_element6")[0].spin = null;
  spinner = jQuery("#form6 #wdform_5_element6").spinner();
  if ("null" == "null" && jQuery("#form6 #wdform_5_element6").val() == "") { spinner.spinner("value", ""); }
  jQuery("#form6 #wdform_5_element6").spinner({ min: "0"});
  jQuery("#form6 #wdform_5_element6").spinner({ max: ""});
  jQuery("#form6 #wdform_5_element6").spinner({ step: "1"});
    }
    function condition_js6() {
    }
    function check_js6(id, form_id) {
    if (id != 0) {
    x = jQuery("#" + form_id + "form_view"+id);
    }
    else {
    x = jQuery("#form"+form_id);
    }    }
    function onsubmit_js6() {
    
  var disabled_fields = "";
  jQuery("#form6 div[wdid]").each(function() {
    if(jQuery(this).css("display") == "none") {
      disabled_fields += jQuery(this).attr("wdid");
      disabled_fields += ",";
    }
    if(disabled_fields) {
      jQuery("<input type=\"hidden\" name=\"disabled_fields6\" value =\""+disabled_fields+"\" />").appendTo("#form6");
    }
  });    }
    jQuery(window).on('load', function () {
    if (jQuery('form#form6 .wdform_section').length > 0) {
      formOnload(6);
    }
    });
    form_view_count6 = 0;
    jQuery(document).ready(function () {
    if (jQuery('form#form6 .wdform_section').length > 0) {
      fm_document_ready(6);
    }
    });
    