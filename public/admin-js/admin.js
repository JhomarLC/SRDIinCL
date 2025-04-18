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
function showLoader(message = "Loading...") {
    $('#loaderOverlay').removeClass('d-none').fadeIn(200);
}

function hideLoader() {
    $('#loaderOverlay').fadeOut(200, function () {
        $(this).addClass('d-none');
    });
}
addEventListener("DOMContentLoaded", (event) => {
    /**
     * Choices Select plugin
     */
    var choicesExamples = document.querySelectorAll("[data-choices]");
    Array.from(choicesExamples).forEach(function (item) {
        var choiceData = {};
        var isChoicesVal = item.attributes;
        if (isChoicesVal["data-choices-groups"]) {
            choiceData.placeholderValue = "This is a placeholder set in the config";
        }
        if (isChoicesVal["data-choices-search-false"]) {
            choiceData.searchEnabled = false;
        }
        if (isChoicesVal["data-choices-search-true"]) {
            choiceData.searchEnabled = true;
        }
        if (isChoicesVal["data-choices-removeItem"]) {
            choiceData.removeItemButton = true;
        }
        if (isChoicesVal["data-choices-sorting-false"]) {
            choiceData.shouldSort = false;
        }
        if (isChoicesVal["data-choices-sorting-true"]) {
            choiceData.shouldSort = true;
        }
        if (isChoicesVal["data-choices-multiple-remove"]) {
            choiceData.removeItemButton = true;
        }
        if (isChoicesVal["data-choices-limit"]) {
            choiceData.maxItemCount = isChoicesVal["data-choices-limit"].value.toString();
        }
        if (isChoicesVal["data-choices-limit"]) {
            choiceData.maxItemCount = isChoicesVal["data-choices-limit"].value.toString();
        }
        if (isChoicesVal["data-choices-editItem-true"]) {
            choiceData.maxItemCount = true;
        }
        if (isChoicesVal["data-choices-editItem-false"]) {
            choiceData.maxItemCount = false;
        }
        if (isChoicesVal["data-choices-text-unique-true"]) {
            choiceData.duplicateItemsAllowed = false;
        }
        if (isChoicesVal["data-choices-text-disabled-true"]) {
            choiceData.addItems = false;
        }
        isChoicesVal["data-choices-text-disabled-true"] ? new Choices(item, choiceData).disable() : new Choices(item, choiceData);
    });

});
