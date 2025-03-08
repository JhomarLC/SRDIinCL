function showAlertModal(status, message) {
    let iconUrl =
        status === "success"
            ? "https://cdn.lordicon.com/lupuorrc.json"
            : "https://cdn.lordicon.com/lltgvngb.json";

    let buttonClass = status === "success" ? "btn-success" : "btn-danger";
    let title = status === "success" ? "Success!" : "Error!";

    let modalHtml = `
        <div id="alertModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <lord-icon src="${iconUrl}" trigger="loop" style="width:120px;height:120px"></lord-icon>
                        <div class="mt-4">
                            <h4 class="mb-3">${title}</h4>
                            <p class="text-muted mb-4">${message}</p>
                            <button type="button" class="btn ${buttonClass}" data-bs-dismiss="modal">Got it!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    $("body").append(modalHtml);
    var alertModal = new bootstrap.Modal(document.getElementById("alertModal"));
    alertModal.show();

    // Remove modal from DOM when closed
    $("#alertModal").on("hidden.bs.modal", function () {
        $(this).remove();
    });
}
