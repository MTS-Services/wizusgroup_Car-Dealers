$(document).ready(function () {
    const emailTemplateModal = document.getElementById('emailTemplateModal');
    emailTemplateModal.addEventListener('hidden.bs.modal', event => {
        destroyAllEditors();
    })
    $(".edit_et").on("click", function () {
        let id = $(this).data("id");
        let _url = details.edit_url;
        let __url = _url.replace("id", id);
        let textAreas = $("#emailTemplateForm").find("textarea");
        $.ajax({
            url: __url,
            method: "GET",
            dataType: "json",
            success: function (data) {
                var result = "";
                var variables = JSON.parse(data.email_template.variables);

                variables.forEach(function (variable) {
                    result += `
                                <tr>
                                    <td>{${variable.key}}</td>
                                    <td>{${variable.meaning}}</td>
                                </tr>
                            `;
                });
                $(".variables").html(result);

                $("#updateEmailTemplate").attr(
                    "data-id",
                    data.email_template.id
                );
                $("#subject").val(data.email_template.subject);
                $("#template").val(data.email_template.template);
                initializeCKEditor(textAreas);
                showModal("emailTemplateModal");
            },
            error: function (xhr, status, error) {
                console.error("Error fetching member data:", error);
            },
        });
    });
});

$(document).ready(function () {
    $("#updateEmailTemplate").click(function () {
        let template_value = editors[$('#template').attr('data-index')].getData();
        let form = $("#emailTemplateForm");
        let id = $(this).data("id");
        let _url = details.edit_url;
        let __url = _url.replace("id", id);
        $.ajax({
            type: "PUT",
            url: __url,
            data: form.serialize() +
                        `&template=${encodeURIComponent(template_value)}`,
            success: function (response) {
                hideModal("emailTemplateModal");
                window.location.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Handle validation errors
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        // Display validation errors
                        var errorHtml = "";
                        $.each(messages, function (index, message) {
                            errorHtml +=
                                '<span class="invalid-feedback d-block" role="alert">' +
                                message +
                                "</span>";
                        });
                        $('[name="' + field + '"]').after(errorHtml);
                    });
                } else {
                    // Handle other errors
                    console.log("An error occurred.");
                }
            },
        });
    });
});
