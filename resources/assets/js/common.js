(function ($) {
    $(function () {
        $('#answer-form .answer-item').change(function () {
            $('#answer-form').submit();
            return false;
        });
    });
})(jQuery);
