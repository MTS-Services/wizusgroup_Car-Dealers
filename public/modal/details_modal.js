function fetchAndShowModal(detailsUrl, headers, modalWrapId, modalId) {
    let url = detailsUrl;
    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        success: function (data) {
            // Define your headers dynamically
            showModalWithData(headers, data, modalWrapId, modalId);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching admin data:", error);
        },
    });
}

function showModalWithData(headers, data, modalWrapId, modalId) {
    // Create the table header dynamically
    const commonHeaders = [
        { label: "Created Date", key: "created_at_formatted" },
        { label: "Created By", key: "creater_name" },
        { label: "Updated Date", key: "updated_at_formatted" },
        { label: "Updated By", key: "updater_name" },
    ];
    headers.push(...commonHeaders);
    const headerHtml = headers
        .map((header) => {
            if (header.color) {
                console.log(data);

                return `
                    <tr>
                        <th class="text-nowrap">${header.label}</th>
                        <th>:</th>
                        <td><span class="badge ${data[header.color]}">${
                    data[header.key]
                }</span></td>
                    </tr>
                `;
            } else if (header.type === "image") {
                return `
                    <tr>
                        <th class="text-nowrap">${header.label}</th>
                        <th>:</th>
                        <td>
                            <div class="imagePreviewDiv d-inline-block">
                                <div id="lightbox" class="lightbox">
                                    <div class="lightbox-content">
                                        <img src="${data[header.key]}"
                                            class="lightbox_image">
                                    </div>
                                    <div class="close_button fa-beat">X</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            } else if (header.type === "video") {
                return `
                <tr>
                    <th class="text-nowrap">${header.label}</th>
                    <th>:</th>
                    <td>
                        <div class="videoPreviewDiv d-inline-block">
                            <div class="video">
                                <video src="${data[header.key]}" class="video"></video>
                            </div>
                        </div>
                        <div class="videoView hide">
                            <div class="videoViewContent">
                                <video class="playVideo" controls>
                                    <source src="${data[header.key]}" type="video/mp4">
                                </video>
                            </div>
                            <div class="close_button fa-beat">X</div>
                        </div>
                    </td>
                </tr>
            `;
            } else {
                return `
                    <tr>
                        <th class="text-nowrap">${header.label}</th>
                        <th>:</th>
                        <td>${data[header.key]}</td>
                    </tr>
                `;
            }
        })
        .join("");

    // Construct the full table HTML
    const result = `
            <table class="table table-striped">
                <tbody>
                    ${headerHtml}
                </tbody>
            </table>
        `;

    $(modalWrapId).html(result);
    showModal(modalId);
}
