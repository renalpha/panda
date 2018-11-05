window.jQuery(document).ready(function () {
    window.jQuery('.copy-link').on('click', function () {
        window.jQuery('.copy-link-value').focus();
        window.jQuery('.copy-link-value').select();
        document.execCommand('copy');
    });
});