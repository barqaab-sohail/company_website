/*global jQuery*/
/*
 *
 * Zoo_Options_radio_img function
 * Changes the radio select option, and changes class on images
 *
 */
function zoo_radio_img_select(relid, labelclass) {
    jQuery(this).prev('input[type="radio"]').prop('checked');
    jQuery('.zoo-radio-img-' + labelclass).removeClass('zoo-radio-img-selected');
    jQuery('label[for="' + relid + '"]').addClass('zoo-radio-img-selected');
}
