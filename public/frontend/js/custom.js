document.addEventListener('DOMContentLoaded', function () {
    $("select.select:not(.no-select)").select2(
        {
            tags: true,
            tokenSeparators: [',']
        }
    );
})