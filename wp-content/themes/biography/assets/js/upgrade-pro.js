!function (t) {
    parseInt(biography_misc_links.WP_version) < 4 && (t(".preview-notice").prepend('<span style="font-weight:bold;">' + biography_misc_links.old_version_message + "</span>"),
        jQuery("#customize-info .btn-upgrade, .misc_links").click(function (t) {
            t.stopPropagation()
        })), t(".preview-notice").prepend('<span id="biography_upgrade"><a target="_blank" class="button btn-upgrade" href="' + biography_misc_links.upgrade_link + '">' + biography_misc_links.upgrade_text + "</a></span>"), jQuery("#customize-info .btn-upgrade, .misc_links").click(function (t) {
        t.stopPropagation()
    })
}(jQuery);