/*global $, jQuery, document, tabid:true, zoo_opts, confirm, relid:true*/

jQuery(document).ready(function () {

    if (jQuery('#last_tab').val() === '') {
        jQuery('.zoo-opts-group-tab:first').slideDown('fast');
        jQuery('#zoo-opts-group-menu li:first').addClass('active');
    } else {
        tabid = jQuery('#last_tab').val();
        jQuery('#' + tabid + '_section_group').slideDown('fast');
        jQuery('#' + tabid + '_section_group_li').addClass('active');
    }

    jQuery('input[name="' + zoo_opts.opt_name + '[defaults]"]').click(function () {
        if (!confirm(zoo_opts.reset_confirm)) {
            return false;
        }
    });

    jQuery('.zoo-opts-group-tab-link-a').click(function () {
        relid = jQuery(this).attr('data-rel');

        jQuery('#last_tab').val(relid);

        jQuery('.zoo-opts-group-tab').each(function () {
            if (jQuery(this).attr('id') === relid + '_section_group') {
                jQuery(this).delay(400).fadeIn(1200);
            } else {
                jQuery(this).fadeOut('fast');
            }
        });

        jQuery('.zoo-opts-group-tab-link-li').each(function () {
            if (jQuery(this).attr('id') !== relid + '_section_group_li' && jQuery(this).hasClass('active')) {
                jQuery(this).removeClass('active');
            }
            if (jQuery(this).attr('id') === relid + '_section_group_li') {
                jQuery(this).addClass('active');
            }
        });
    });

    if (jQuery('#zoo-opts-save').is(':visible')) {
        jQuery('#zoo-opts-save').delay(4000).slideUp('slow');
    }

    if (jQuery('#zoo-opts-imported').is(':visible')) {
        jQuery('#zoo-opts-imported').delay(4000).slideUp('slow');
    }

    jQuery('#zoo-opts-form-wrapper').on('change', 'input, textarea, select', function () {
        if(this.id === 'google_webfonts' && this.value === '') return;
        jQuery('#zoo-opts-save-warn').slideDown('slow');
    });

    jQuery('#zoo-opts-import-code-button').click(function () {
        if (jQuery('#zoo-opts-import-link-wrapper').is(':visible')) {
            jQuery('#zoo-opts-import-link-wrapper').fadeOut('fast');
            jQuery('#import-link-value').val('');
        }
        jQuery('#zoo-opts-import-code-wrapper').fadeIn('slow');
    });

    jQuery('#zoo-opts-import-link-button').click(function () {
        if (jQuery('#zoo-opts-import-code-wrapper').is(':visible')) {
            jQuery('#zoo-opts-import-code-wrapper').fadeOut('fast');
            jQuery('#import-code-value').val('');
        }
        jQuery('#zoo-opts-import-link-wrapper').fadeIn('slow');
    });

    jQuery('#zoo-opts-export-code-copy').click(function () {
        if (jQuery('#zoo-opts-export-link-value').is(':visible')) {jQuery('#zoo-opts-export-link-value').fadeOut('slow'); }
        jQuery('#zoo-opts-export-code').toggle('fade');
    });

    jQuery('#zoo-opts-export-link').click(function () {
        if (jQuery('#zoo-opts-export-code').is(':visible')) {jQuery('#zoo-opts-export-code').fadeOut('slow'); }
        jQuery('#zoo-opts-export-link-value').toggle('fade');
    });
});
