import Select2 from "select2";
import "select2/dist/css/select2.min.css";
window.Select2 = Select2;

document.addEventListener("DOMContentLoaded", function () {
    const selects = document.querySelectorAll("select.form-control:not(.no-select)");
    selects.forEach(select => {
        $(select).select2({
            tags: true,
            tokenSeparators: [',']
        });
    });
});
