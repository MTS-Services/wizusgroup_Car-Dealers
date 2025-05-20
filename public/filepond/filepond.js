
// fileTypes = [
//     "application/pdf",
//     "application/msword",
//     "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
//     "application/vnd.ms-excel",
//     "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
//     "image/jpeg",
//     "image/png",
//     "image/gif",
// ];

function file_upload(
    selectors,
    existingFiles = [],
    fileTypes = ["image/*"],
    multipleFile = false,

) {
    $.each(selectors.reverse(), function (index, selector) {
        const inputElement = document.querySelector(selector);
        const fileUrl = existingFiles[selector];

        const pondOptions = {
            acceptedFileTypes: fileTypes,
            allowMultiple: multipleFile,
            storeAsFile: true,
        };

        if (fileUrl && fileUrl.trim() !== "") {
            pondOptions.files = [
                {
                    source: fileUrl,
                    options: {
                        type: "remote", // ✅ try this instead of "local"
                    },
                },
            ];
        }

        FilePond.create(inputElement, pondOptions);
    });
}



