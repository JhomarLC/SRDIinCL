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

function initFertilizerSelector({
    selectorId,
    othersInputId,
    containerId,
    blockPrefix = 'fertilizer'
}) {
    const $selector = $(`#${selectorId}`);
    const $othersInput = $(`#${othersInputId}`);
    const $container = $(`#${containerId}`);
    let otherCounter = 0;

    console.log(blockPrefix);

    const observer = new MutationObserver(() => {
        $selector.trigger(`${blockPrefix}-choices-updated`);
    });

    const node = document.getElementById(selectorId);
    if (node) {
        observer.observe(node, { attributes: true, childList: true, subtree: true });
    }

    // Listen for removeItem events for others
    document.addEventListener('removeItem', function (event) {
        if (event.detail?.value && event.target.id === othersInputId) {
            const removedValue = event.detail.value.trim().toLowerCase();
            $container.find(`.${blockPrefix}-block`).filter(function () {
                const id = $(this).data(`${blockPrefix}-id`);
                const name = $(this).data(`${blockPrefix}-name`)?.toString().toLowerCase();
                return id?.toString().startsWith('other_') && name === removedValue;
            }).remove();

            reindexBlocks();
        }
    });

    // Handle selection changes
    $(document).on(`${blockPrefix}-choices-updated`, `#${selectorId}`, function () {
        // Remove non-other blocks
        $container.find(`.${blockPrefix}-block`).filter(function () {
            return !$(this).data(`${blockPrefix}-id`)?.toString().startsWith('other_');
        }).remove();

        $selector.find('option:selected').each(function () {
            const id = $(this).val();
            const name = $(this).text();

            const exists = $container.find(`.${blockPrefix}-block`).filter(function () {
                return $(this).data(`${blockPrefix}-id`) === id;
            }).length > 0;

            if (!exists) {
                createBlock(id, name, false);
            }
        });

        reindexBlocks();
    });

    // Handle "Others" input
    $othersInput.on('change', function () {
        const val = $(this).val().trim();
        if (!val) return;

        const id = `other_${++otherCounter}`;
        const name = val;
        createBlock(id, name, true);
        $(this).val('');
        reindexBlocks();
    });

    // Create block
    function createBlock(id, name, isOther) {
        const safeId = id.replace(/\s+/g, '_'); // Remove spaces for radio safety

        const block = `
            <div class="border rounded p-3 mb-3 ${blockPrefix}-block"
                data-${blockPrefix}-id="${id}"
                data-${blockPrefix}-name="${name}">

                <h6 class="${blockPrefix}-label"></h6>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio"
                        name="${blockPrefix}_type_${safeId}"
                        id="${blockPrefix}_free_${safeId}"
                        value="free">
                    <label class="form-check-label" for="${blockPrefix}_free_${safeId}">Free</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio"
                        name="${blockPrefix}_type_${safeId}"
                        id="${blockPrefix}_purchase_${safeId}"
                        value="purchase" checked>
                    <label class="form-check-label" for="${blockPrefix}_purchase_${safeId}">Purchase</label>
                </div>

                <div class="row mt-2 bg-light p-3 rounded">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" class="form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="unit_cost_${safeId}" class="form-control unit-cost" placeholder="Unit Cost">
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="total_cost_${safeId}" class="form-control total-cost" placeholder="0.00" readonly>
                    </div>
                </div>
            </div>
        `;

        $container.append(block);
        bindEvents(); // Rebind after adding
        updateActivityTotals();
    }


    // Reindex block labels
    function reindexBlocks() {
        const suffixes = ['st', 'nd', 'rd'];
        $container.find(`.${blockPrefix}-block`).each(function (index) {
            const label = `${index + 1}${suffixes[index] || 'th'} Fertilizer: ${$(this).data(`${blockPrefix}-name`)}`;
            $(this).find(`.${blockPrefix}-label`).text(label);
        });
    }

    // Bind quantity and cost logic
    function bindEvents() {
        $(`input[type=radio][name^=${blockPrefix}_type_]`).off('change').on('change', function () {
            const $block = $(this).closest(`.${blockPrefix}-block`);
            const isFree = $(this).val() === 'free';

            const $qty = $block.find('.quantity');
            const $unit = $block.find('.unit-cost');
            const $total = $block.find('.total-cost');
            const $minus = $block.find('.minus');
            const $plus = $block.find('.plus');

            if (isFree) {
                $qty.val(0).prop('disabled', true);
                $unit.val('').prop('disabled', true);
                $total.val('').prop('disabled', true);
                $minus.prop('disabled', true);
                $plus.prop('disabled', true);
            } else {
                $qty.prop('disabled', false);
                $unit.prop('disabled', false);
                $total.prop('disabled', false);
                $minus.prop('disabled', false);
                $plus.prop('disabled', false);
            }
        });
    }

    // Initial trigger
    $selector.trigger(`${blockPrefix}-choices-updated`);
}

// Init Selector Logic
function initPesticideSelector({ selectorId, othersInputId, containerId, blockPrefix = 'pesticide' }) {
    const $selector = $(`#${selectorId}`);
    const $othersInput = $(`#${othersInputId}`);
    const $container = $(`#${containerId}`);
    let otherCounter = 0;

    const observer = new MutationObserver(() => {
        $selector.trigger(`${blockPrefix}-choices-updated`);
    });
    const node = document.getElementById(selectorId);
    if (node) observer.observe(node, { attributes: true, childList: true, subtree: true });

    document.addEventListener('removeItem', function (event) {
        if (event.detail?.value && event.target.id === othersInputId) {
            const removedValue = event.detail.value.trim().toLowerCase();
            $container.find(`.${blockPrefix}-block`).filter(function () {
                const name = $(this).data(`${blockPrefix}-name`)?.toString().toLowerCase();
                return name === removedValue;
            }).remove();
            reindexBlocks();
        }
    });

    $(document).on(`${blockPrefix}-choices-updated`, `#${selectorId}`, function () {
        $container.find(`.${blockPrefix}-block`).filter(function () {
            return !$(this).data(`${blockPrefix}-id`)?.toString().startsWith('other_');
        }).remove();

        $selector.find('option:selected').each(function () {
            const id = $(this).val();
            const name = $(this).text();

            const exists = $container.find(`.${blockPrefix}-block`).filter(function () {
                return $(this).data(`${blockPrefix}-id`) === id;
            }).length > 0;

            if (!exists) createBlock(id, name);
        });

        reindexBlocks();
    });

    $othersInput.on('change', function () {
        const val = $(this).val().trim();
        if (!val) return;

        const id = `other_${++otherCounter}`;
        const name = val;
        createBlock(id, name);
        $(this).val('');
        reindexBlocks();
    });

    function createBlock(id, name) {
        const block = `
            <div class="${blockPrefix}-block border rounded p-3 mb-3" data-${blockPrefix}-id="${id}" data-${blockPrefix}-name="${name}">
                <label class="form-label"><strong>${name}</strong>: Input Brand Name</label>
                <input type="text" name="brand_name_${id}" class="form-control" placeholder="Enter Brand Name">
            </div>
        `;
        $container.append(block);
    }

    function reindexBlocks() {
        // Optional: numbering or other logic
    }

    $selector.trigger(`${blockPrefix}-choices-updated`);
}
