import "pc-bootstrap4-datetimepicker";

/*! jQuery datetimepicker */
(function ($) {
    $.extend(true, $.fn.datetimepicker.defaults, {
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'fas fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'far fa-times-circle'
        },
        locale: "zh-cn",
        showClear: true,
        showTodayButton: true,
        minDate: '2000-01-01'
    });

    $(".datetimepicker").datetimepicker({
        format: "YYYY-MM-DD HH:mm:ss",
        // sideBySide: true,
        maxDate: new Date((new Date).getFullYear() + 5, 12, 31, 23, 59, 59)
    });

    $(".datepicker").datetimepicker({
        format: "YYYY-MM-DD"
    });
})(jQuery);
