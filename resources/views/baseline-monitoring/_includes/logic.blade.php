<script>

    $(document).ready(function () {
        $('input[name="method_crop_establishment"]').on('change', function () {
            const method = $('input[name="method_crop_establishment"]:checked').val();

            if (method === 'DWSR') {
                $('#v-pills-seedbed-prep-tab').hide();
                $('#v-pills-seedbed-fertilization-tab').hide();

                // Redirect if current tab is hidden
                const currentTab = $('.nav-link.active').attr('id');
                if (currentTab === 'v-pills-seedbed-prep-tab' || currentTab === 'v-pills-seedbed-fertilization-tab') {
                    $('#v-pills-dry-season-info-tab').click(); // or any other visible tab
                }
            } else {
                $('#v-pills-seedbed-prep-tab').show();
                $('#v-pills-seedbed-fertilization-tab').show();
            }
        });

        // Initial check on page load
        $('input[name="method_crop_establishment"]:checked').trigger('change');

            function calculateTotalYield() {
            const numberOfBags = parseFloat($('#number_of_bags').val()) || 0;
            const avgWeightPerBag = parseFloat($('#avg_weight_per_bag').val()) || 0;
            const totalYield = numberOfBags * avgWeightPerBag;

            $('#yield_tons_per_ha').val(totalYield.toFixed(2));
        }

        $('#number_of_bags, #avg_weight_per_bag').on('input', calculateTotalYield);

        $('.nexttab').on('click', function () {
            var nextTabId = $(this).data('nexttab');
            var nextTabTrigger = $('[data-bs-target="#' + nextTabId + '"]');

            if (nextTabTrigger.length) {
                nextTabTrigger.tab('show');
            }
        });

    });
    $(document).ready(function () {
        // Show/hide based on "Package" checkbox
        $('#land-prep-pakyaw').on('change', function () {
            if ($(this).is(':checked')) {
                $('#land-prep-pakyaw-total-cost').show();
                $('#land-prep-regular-fields').hide();
            } else {
                $('#land-prep-pakyaw-total-cost').hide();
                $('#land-prep-regular-fields').show();
            }
        });
        // Show/hide based on "Package" checkbox in Seeds Preparation
        $('#seeds-prep-pakyaw').on('change', function () {
            if ($(this).is(':checked')) {
                $('#seeds-prep-pakyaw-total-cost').show();
                $('#seeds-prep-regular-fields').hide();
            } else {
                $('#seeds-prep-pakyaw-total-cost').hide();
                $('#seeds-prep-regular-fields').show();
            }
        });
        // Show/hide based on "Package" checkbox in Seeds Preparation
        $('#seedbed-prep-pakyaw').on('change', function () {
            if ($(this).is(':checked')) {
                $('#seedbed-prep-pakyaw-total-cost').show();
                $('#seedbed-prep-regular-fields').hide();
            } else {
                $('#seedbed-prep-pakyaw-total-cost').hide();
                $('#seedbed-prep-regular-fields').show();
            }
        });

        // Show/hide based on "Package" checkbox in Seeds Preparation
        $('#crop-establishment-pakyaw').on('change', function () {
            if ($(this).is(':checked')) {
                $('#crop-establishment-pakyaw-total-cost').show();
                $('#crop-establishment-regular-fields').hide();
            } else {
                $('#crop-establishment-pakyaw-total-cost').hide();
                $('#crop-establishment-regular-fields').show();
            }
        });

        // Calculate total cost per block when quantity or unit cost changes
        $('#land-prep-regular-fields').on('input', '.product-quantity, .unit-cost', function () {
            const $row = $(this).closest('.row.bg-light');
            const qty = parseFloat($row.find('.product-quantity').val()) || 0;
            const unitCost = parseFloat($row.find('.unit-cost').val()) || 0;
            const totalCost = qty * unitCost;
            $row.find('.total-cost').val(totalCost.toFixed(2));
        });

        $('#seedbed-prep-regular-fields').on('input', '.product-quantity, .unit-cost', function () {
            const $row = $(this).closest('.row.bg-light');
            const qty = parseFloat($row.find('.product-quantity').val()) || 0;
            const unitCost = parseFloat($row.find('.unit-cost').val()) || 0;
            const totalCost = qty * unitCost;
            $row.find('.total-cost').val(totalCost.toFixed(2));
        });

        // Optional: Add click handlers for plus and minus buttons
        $('#seed-prep-regular-fields').on('click', '.plus, .minus', function () {
            const $input = $(this).siblings('input.product-quantity');
            let currentVal = parseInt($input.val()) || 0;
            if ($(this).hasClass('plus')) {
                currentVal++;
            } else if ($(this).hasClass('minus') && currentVal > 0) {
                currentVal--;
            }
            $input.val(currentVal).trigger('input');
        });

        $('#seedbed-fertilization-regular-fields').on('input', '.product-quantity, .unit-cost', function () {
            const $row = $(this).closest('.row.bg-light');
            const qty = parseFloat($row.find('.product-quantity').val()) || 0;
            const unitCost = parseFloat($row.find('.unit-cost').val()) || 0;
            const totalCost = qty * unitCost;
            $row.find('.total-cost').val(totalCost.toFixed(2));
        });
    });

    $(document).ready(function () {
        function calculateTotalCost($block) {
            const $qtyInput = $block.find('.quantity');
            const $unitCostInput = $block.find('.unit-cost');
            const $totalCostInput = $block.find('.total-cost');

            const qty = parseFloat($qtyInput.val()) || 0;
            const unitCost = parseFloat($unitCostInput.val()) || 0;
            const total = qty * unitCost;

            $totalCostInput.val(total.toFixed(2));
        }

        $('.block').each(function () {
            const $block = $(this);
            const $qtyInput = $block.find('.quantity');
            const $unitCostInput = $block.find('.unit-cost');

            function attachAndTriggerCalc($input) {
                $input.on('input change', function () {
                    calculateTotalCost($block);
                });
            }

            // Attach event handlers
            attachAndTriggerCalc($qtyInput);
            attachAndTriggerCalc($unitCostInput);

            // Plus button
            $block.find('.plus').on('click', function () {
                const $input = $(this).siblings('input.quantity');
                const currentVal = parseInt($input.val()) || 0;
                $input.val(currentVal + 1).trigger('input');
            });

            // Minus button
            $block.find('.minus').on('click', function () {
                const $input = $(this).siblings('input.quantity');
                const currentVal = parseInt($input.val()) || 0;
                const min = parseInt($input.attr('min')) || 0;
                $input.val(Math.max(min, currentVal - 1)).trigger('input');
            });

            // Initial calculation
            calculateTotalCost($block);
        });
    });

    $(document).ready(function () {
        // Choices.js might block native change event, so we handle DOM mutation
        const observer = new MutationObserver(() => {
            $('#variety-selector').trigger('choices-updated');
        });

        const selectorNode = document.getElementById('variety-selector');
        if (selectorNode) {
            observer.observe(selectorNode, { attributes: true, childList: true, subtree: true });
        }

        // Handle custom 'choices-updated' event

        $(document).ready(function () {
            const selectorNode = document.getElementById('variety-selector');

            // Choices.js compatibility
            const observer = new MutationObserver(() => {
                $('#variety-selector').trigger('choices-updated');
            });

            if (selectorNode) {
                observer.observe(selectorNode, { attributes: true, childList: true, subtree: true });
            }

            $(document).on('choices-updated', '#variety-selector', function () {
                const $container = $('#variety-container');
                $container.empty();

                $('#variety-selector option:selected').each(function (index) {
                    const varietyId = $(this).val();
                    const varietyName = $(this).data('name') || $(this).text();
                    const indexLabel = `${index + 1}${['st','nd','rd'][index] || 'th'}`;

                    const block = `
                        <div class="border rounded p-3 mb-3 variety-block" data-variety-id="${varietyId}">
                            <h6>${indexLabel} Variety: ${varietyName}</h6>
                             <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="soaking_type_${varietyId}"
                                    id="soaking_free_${varietyId}"
                                    value="free">
                                <label class="form-check-label" for="soaking_free_${varietyId}">Free</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="soaking_type_${varietyId}"
                                    id="soaking_purchase_${varietyId}"
                                    value="purchase" checked>
                                <label class="form-check-label" for="soaking_purchase_${varietyId}">Purchase</label>
                            </div>

                            <div class="row mt-2 bg-light p-3 rounded">
                                <div class="col-4">
                                    <label class="form-label text-muted">Qty</label>
                                    <div class="input-step step-primary full-width d-flex">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" class="product-quantity form-control text-center soaking-qty quantity" value="0" min="0" step="1">
                                        <button type="button" class="plus">+</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Unit Cost</label>
                                    <input type="number" name="unit_cost_${varietyId}" class="form-control unit-cost" placeholder="Unit Cost">
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Total Cost</label>
                                    <input type="number" name="total_cost_${varietyId}" class="form-control total-cost" placeholder="0.00" readonly>
                                </div>
                            </div>
                        </div>
                    `;

                    $container.append(block);

                });

                bindEvents();
            });

            $('#variety-selector').trigger('choices-updated');

            function bindEvents() {
                $('.minus').off('click').on('click', function () {
                    const $input = $(this).siblings('input.quantity');
                    const currentVal = parseInt($input.val()) || 0;
                    if (currentVal > 0) $input.val(currentVal - 1).trigger('input');
                });

                $('.plus').off('click').on('click', function () {
                    const $input = $(this).siblings('input.quantity');
                    const currentVal = parseInt($input.val()) || 0;
                    $input.val(currentVal + 1).trigger('input');
                });

                $('.quantity, .unit-cost').off('input').on('input', function () {
                    const $row = $(this).closest('.row');
                    const quantity = parseFloat($row.find('.quantity').val()) || 0;
                    const unitCost = parseFloat($row.find('.unit-cost').val()) || 0;
                    const total = (quantity * unitCost).toFixed(2);
                    $row.find('.total-cost').val(total);
                });

                // NEW: Handle Free/Purchase toggle
                $('input[type=radio][name^=soaking_type_]').off('change').on('change', function () {
                    const $block = $(this).closest('.variety-block');
                    const isFree = $(this).val() === 'free';

                    const $qtyInput = $block.find('.quantity');
                    const $unitCost = $block.find('.unit-cost');
                    const $totalCost = $block.find('.total-cost');
                    const $minus = $block.find('.minus');
                    const $plus = $block.find('.plus');

                    if (isFree) {
                        $qtyInput.val(0).prop('disabled', true);
                        $unitCost.val('').prop('disabled', true);
                        $totalCost.val('').prop('disabled', true);
                        $minus.prop('disabled', true);
                        $plus.prop('disabled', true);
                    } else {
                        $qtyInput.prop('disabled', false);
                        $unitCost.prop('disabled', false);
                        $totalCost.prop('disabled', false);
                        $minus.prop('disabled', false);
                        $plus.prop('disabled', false);
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        // Choices.js might block native change event, so we handle DOM mutation
        const observer = new MutationObserver(() => {
            $('#fertilizer-selector').trigger('choices-updated');
        });

        const selectorNode = document.getElementById('fertilizer-selector');
        if (selectorNode) {
            observer.observe(selectorNode, { attributes: true, childList: true, subtree: true });
        }

        // Handle custom 'choices-updated' event

        $(document).ready(function () {
            const selectorNode = document.getElementById('fertilizer-selector');

            // Choices.js compatibility
            const observer = new MutationObserver(() => {
                $('#fertilizer-selector').trigger('choices-updated');
            });

            if (selectorNode) {
                observer.observe(selectorNode, { attributes: true, childList: true, subtree: true });
            }

            $(document).on('choices-updated', '#fertilizer-selector', function () {
                const $container = $('#fertilizer-container');
                $container.empty();

                $('#fertilizer-selector option:selected').each(function (index) {
                    const fertilizerId = $(this).val();
                    const fertilizerName = $(this).data('name') || $(this).text();
                    const indexLabel = `${index + 1}${['st','nd','rd'][index] || 'th'}`;

                    const block = `
                        <div class="border rounded p-3 mb-3 fertilizer-block" data-fertilizer-id="${fertilizerId}">
                            <h6>${indexLabel} Fertilizer: ${fertilizerName}</h6>
                             <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="fertilizer_${fertilizerId}"
                                    id="soaking_free_${fertilizerId}"
                                    value="free">
                                <label class="form-check-label" for="soaking_free_${fertilizerId}">Free</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="fertilizer_${fertilizerId}"
                                    id="soaking_purchase_${fertilizerId}"
                                    value="purchase" checked>
                                <label class="form-check-label" for="soaking_purchase_${fertilizerId}">Purchase</label>
                            </div>

                            <div class="row mt-2 bg-light p-3 rounded">
                                <div class="col-4">
                                    <label class="form-label text-muted">Qty</label>
                                    <div class="input-step step-primary full-width d-flex">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" class="product-quantity form-control text-center soaking-qty quantity" value="0" min="0" step="1">
                                        <button type="button" class="plus">+</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Unit Cost</label>
                                    <input type="number" name="unit_cost_${fertilizerId}" class="form-control unit-cost" placeholder="Unit Cost">
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Total Cost</label>
                                    <input type="number" name="total_cost_${fertilizerId}" class="form-control total-cost" placeholder="0.00" readonly>
                                </div>
                            </div>
                        </div>
                    `;

                    $container.append(block);
                });

                bindEvents();
            });

            $('#fertilizer-selector').trigger('choices-updated');

            function bindEvents() {
                $('.minus').off('click').on('click', function () {
                    const $input = $(this).siblings('input.quantity');
                    const currentVal = parseInt($input.val()) || 0;
                    if (currentVal > 0) $input.val(currentVal - 1).trigger('input');
                });

                $('.plus').off('click').on('click', function () {
                    const $input = $(this).siblings('input.quantity');
                    const currentVal = parseInt($input.val()) || 0;
                    $input.val(currentVal + 1).trigger('input');
                });

                $('.quantity, .unit-cost').off('input').on('input', function () {
                    const $row = $(this).closest('.row');
                    const quantity = parseFloat($row.find('.quantity').val()) || 0;
                    const unitCost = parseFloat($row.find('.unit-cost').val()) || 0;
                    const total = (quantity * unitCost).toFixed(2);
                    $row.find('.total-cost').val(total);
                });

                // NEW: Handle Free/Purchase toggle
                $('input[type=radio][name^=fertilizer_]').off('change').on('change', function () {
                    const $block = $(this).closest('.fertilizer-block');
                    const isFree = $(this).val() === 'free';

                    const $qtyInput = $block.find('.quantity');
                    const $unitCost = $block.find('.unit-cost');
                    const $totalCost = $block.find('.total-cost');
                    const $minus = $block.find('.minus');
                    const $plus = $block.find('.plus');

                    if (isFree) {
                        $qtyInput.val(0).prop('disabled', true);
                        $unitCost.val('').prop('disabled', true);
                        $totalCost.val('').prop('disabled', true);
                        $minus.prop('disabled', true);
                        $plus.prop('disabled', true);
                    } else {
                        $qtyInput.prop('disabled', false);
                        $unitCost.prop('disabled', false);
                        $totalCost.prop('disabled', false);
                        $minus.prop('disabled', false);
                        $plus.prop('disabled', false);
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        // Choices.js might block native change event, so we handle DOM mutation
        const observer = new MutationObserver(() => {
            $('#fertilizer-application-selector').trigger('choices-updated');
        });

        const selectorNode = document.getElementById('fertilizer-application-selector');
        if (selectorNode) {
            observer.observe(selectorNode, { attributes: true, childList: true, subtree: true });
        }

        // Handle custom 'choices-updated' event

        $(document).ready(function () {
            const selectorNode = document.getElementById('fertilizer-application-selector');

            // Choices.js compatibility
            const observer = new MutationObserver(() => {
                $('#fertilizer-application-selector').trigger('choices-updated');
            });

            if (selectorNode) {
                observer.observe(selectorNode, { attributes: true, childList: true, subtree: true });
            }

            $(document).on('choices-updated', '#fertilizer-application-selector', function () {
                const $container = $('#fertilizer-application-container');
                $container.empty();

                $('#fertilizer-application-selector option:selected').each(function (index) {
                    const fertilizerId = $(this).val();
                    const fertilizerName = $(this).data('name') || $(this).text();
                    const indexLabel = `${index + 1}${['st','nd','rd'][index] || 'th'}`;

                    const block = `
                        <div class="border rounded p-3 mb-3 fertilizer-application-block" data-fertilizer-id="${fertilizerId}">
                            <h6>${indexLabel} Fertilizer: ${fertilizerName}</h6>
                             <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="fertilizer_application_${fertilizerId}"
                                    id="fertilizer_application__free_${fertilizerId}"
                                    value="free">
                                <label class="form-check-label" for="fertilizer_application__free_${fertilizerId}">Free</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="fertilizer_application_${fertilizerId}"
                                    id="fertilizer_application_purchase_${fertilizerId}"
                                    value="purchase" checked>
                                <label class="form-check-label" for="fertilizer_application_purchase_${fertilizerId}">Purchase</label>
                            </div>

                            <div class="row mt-2 bg-light p-3 rounded">
                                <div class="col-4">
                                    <label class="form-label text-muted">Qty</label>
                                    <div class="input-step step-primary full-width d-flex">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" class="product-quantity form-control text-center soaking-qty quantity" value="0" min="0" step="1">
                                        <button type="button" class="plus">+</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Unit Cost</label>
                                    <input type="number" name="unit_cost_${fertilizerId}" class="form-control unit-cost" placeholder="Unit Cost">
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Total Cost</label>
                                    <input type="number" name="total_cost_${fertilizerId}" class="form-control total-cost" placeholder="0.00" readonly>
                                </div>
                            </div>
                        </div>
                    `;

                    $container.append(block);
                });

                bindEvents();
            });

            $('#fertilizer-application-selector').trigger('choices-updated');

            function bindEvents() {
                $('.minus').off('click').on('click', function () {
                    const $input = $(this).siblings('input.quantity');
                    const currentVal = parseInt($input.val()) || 0;
                    if (currentVal > 0) $input.val(currentVal - 1).trigger('input');
                });

                $('.plus').off('click').on('click', function () {
                    const $input = $(this).siblings('input.quantity');
                    const currentVal = parseInt($input.val()) || 0;
                    $input.val(currentVal + 1).trigger('input');
                });

                $('.quantity, .unit-cost').off('input').on('input', function () {
                    const $row = $(this).closest('.row');
                    const quantity = parseFloat($row.find('.quantity').val()) || 0;
                    const unitCost = parseFloat($row.find('.unit-cost').val()) || 0;
                    const total = (quantity * unitCost).toFixed(2);
                    $row.find('.total-cost').val(total);
                });

                // NEW: Handle Free/Purchase toggle
                $('input[type=radio][name^=fertilizer_application_]').off('change').on('change', function () {
                    const $block = $(this).closest('.fertilizer-application-block');
                    const isFree = $(this).val() === 'free';

                    const $qtyInput = $block.find('.quantity');
                    const $unitCost = $block.find('.unit-cost');
                    const $totalCost = $block.find('.total-cost');
                    const $minus = $block.find('.minus');
                    const $plus = $block.find('.plus');

                    if (isFree) {
                        $qtyInput.val(0).prop('disabled', true);
                        $unitCost.val('').prop('disabled', true);
                        $totalCost.val('').prop('disabled', true);
                        $minus.prop('disabled', true);
                        $plus.prop('disabled', true);
                    } else {
                        $qtyInput.prop('disabled', false);
                        $unitCost.prop('disabled', false);
                        $totalCost.prop('disabled', false);
                        $minus.prop('disabled', false);
                        $plus.prop('disabled', false);
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        function toggleCropEstablishmentSection() {
            const method = $('input[name="method_crop_establishment"]:checked').val();
            if (method === 'DWSR') {
                $('#dwsr-section').show();
                $('#tpr-section').hide();
            } else if (method === 'TPR') {
                $('#tpr-section').show();
                $('#dwsr-section').hide();
            } else {
                $('#dwsr-section, #tpr-section').hide();
            }
        }

        // Run on page load
        toggleCropEstablishmentSection();

        // Run on change
        $('input[name="method_crop_establishment"]').on('change', function () {
            toggleCropEstablishmentSection();
        });

        function toggleTPRFields(establishmentType) {
            if (establishmentType === 'purchase') { // Mechanical
                $('[data-tpr-block="manual-only"]').hide();
            } else {
                $('[data-tpr-block="manual-only"]').show();
            }
        }

        $(document).on('change', 'input[name="soaking-type"]', function () {
            const value = $(this).val();
            toggleTPRFields(value);
        });
    });

    $(document).ready(function () {
        function initializeChoices(element) {
            const choiceData = {};
            const attrs = element.attributes;

            if (attrs["data-choices-groups"]) choiceData.placeholderValue = "This is a placeholder set in the config";
            if (attrs["data-choices-search-false"]) choiceData.searchEnabled = false;
            if (attrs["data-choices-search-true"]) choiceData.searchEnabled = true;
            if (attrs["data-choices-removeitem"]) choiceData.removeItemButton = true;
            if (attrs["data-choices-sorting-false"]) choiceData.shouldSort = false;
            if (attrs["data-choices-sorting-true"]) choiceData.shouldSort = true;
            if (attrs["data-choices-multiple-remove"]) choiceData.removeItemButton = true;
            if (attrs["data-choices-limit"]) choiceData.maxItemCount = attrs["data-choices-limit"].value.toString();
            if (attrs["data-choices-edititem-true"]) choiceData.editItems = true;
            if (attrs["data-choices-edititem-false"]) choiceData.editItems = false;
            if (attrs["data-choices-text-unique-true"]) choiceData.duplicateItemsAllowed = false;
            if (attrs["data-choices-text-disabled-true"]) choiceData.addItems = false;

            const instance = new Choices(element, choiceData);
            if (attrs["data-choices-text-disabled-true"]) instance.disable();

            return instance;
        }

        let applicationIndex = 1;

        function ordinal(n) {
            return n + (['st','nd','rd'][((n + 90) % 100 - 10) % 10 - 1] || 'th');
        }

        function bindEvents($container) {
            $container.find('.minus').off('click').on('click', function () {
                const $input = $(this).siblings('input.quantity');
                const currentVal = parseInt($input.val()) || 0;
                if (currentVal > 0) $input.val(currentVal - 1).trigger('input');
            });

            $container.find('.plus').off('click').on('click', function () {
                const $input = $(this).siblings('input.quantity');
                const currentVal = parseInt($input.val()) || 0;
                $input.val(currentVal + 1).trigger('input');
            });

            $container.find('.quantity, .unit-cost').off('input').on('input', function () {
                const $row = $(this).closest('.row');
                const quantity = parseFloat($row.find('.quantity').val()) || 0;
                const unitCost = parseFloat($row.find('.unit-cost').val()) || 0;
                const total = (quantity * unitCost).toFixed(2);
                $row.find('.total-cost').val(total);
            });

            $container.find('input[type=radio]').off('change').on('change', function () {
                const $block = $(this).closest('.fertilizer-application-block');
                const isFree = $(this).val() === 'free';

                const $qtyInput = $block.find('.quantity');
                const $unitCost = $block.find('.unit-cost');
                const $totalCost = $block.find('.total-cost');
                const $minus = $block.find('.minus');
                const $plus = $block.find('.plus');

                if (isFree) {
                    $qtyInput.val(0).prop('disabled', true);
                    $unitCost.val('').prop('disabled', true);
                    $totalCost.val('').prop('disabled', true);
                    $minus.prop('disabled', true);
                    $plus.prop('disabled', true);
                } else {
                    $qtyInput.prop('disabled', false);
                    $unitCost.prop('disabled', false);
                    $totalCost.prop('disabled', false);
                    $minus.prop('disabled', false);
                    $plus.prop('disabled', false);
                }
            });
        }

        function getLaborAndSnacksHTML(appIndex) {
            return `
                <div class="labor-snacks-block mt-3">
                    <div class="block">
                        <label class="form-label">Labor: Fertilizer application</label>
                        <div class="row p-3 mb-3 rounded bg-light">
                            <div class="col-4">
                                <label class="form-label text-muted">Qty</label>
                                <div class="input-step step-primary full-width d-flex">
                                    <button type="button" class="minus">–</button>
                                    <input type="number" class="quantity product-quantity form-control text-center" value="0" min="0" step="1">
                                    <button type="button" class="plus">+</button>
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">Unit Cost</label>
                                <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">Total Cost</label>
                                <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                            </div>
                        </div>
                    </div>
                    <div class="block">
                        <label class="form-label">Meals and Snacks</label>
                        <div class="row p-3 mb-3 rounded bg-light">
                            <div class="col-4">
                                <label class="form-label text-muted">Qty</label>
                                <div class="input-step step-primary full-width d-flex">
                                    <button type="button" class="minus">–</button>
                                    <input type="number" class="quantity product-quantity form-control text-center" value="0" min="0" step="1">
                                    <button type="button" class="plus">+</button>
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">Unit Cost</label>
                                <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">Total Cost</label>
                                <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                            </div>
                        </div>
                    </div>
                    <hr class="text-muted">
                </div>
            `;
        }

        function observeAndBind($select, $container, appIndex) {
            const observer = new MutationObserver(() => {
                $select.trigger('choices-updated');
            });

            const selectorNode = $select.get(0);
            if (selectorNode) {
                observer.observe(selectorNode, { attributes: true, childList: true, subtree: true });
            }

            $select.on('choices-updated', function () {
                $container.empty();

                $select.find('option:selected').each(function (index) {
                    const fertilizerId = $(this).val();
                    const fertilizerName = $(this).text();
                    const indexLabel = `${index + 1}${['st','nd','rd'][index] || 'th'}`;
                    const uniqueId = `${appIndex}_${Date.now()}_${Math.floor(Math.random() * 1000)}`;

                    const radioName = `fertilizer_application_${appIndex}_${index}_${uniqueId}`;
                    const freeId = `${radioName}_free`;
                    const purchaseId = `${radioName}_purchase`;

                    const block = `
                        <div class="border rounded p-3 mb-3 fertilizer-application-block" data-fertilizer-id="${fertilizerId}">
                            <h6>${indexLabel} Fertilizer: ${fertilizerName}</h6>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    id="${freeId}"
                                    name="${radioName}"
                                    value="free">
                                <label class="form-check-label" for="${freeId}">Free</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    id="${purchaseId}"
                                    name="${radioName}"
                                    value="purchase" checked>
                                <label class="form-check-label" for="${purchaseId}">Purchase</label>
                            </div>
                            <div class="row mt-2 bg-light p-3 rounded">
                                <div class="col-4">
                                    <label class="form-label text-muted">Qty</label>
                                    <div class="input-step step-primary full-width d-flex">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" class="product-quantity form-control text-center soaking-qty quantity" value="0" min="0" step="1">
                                        <button type="button" class="plus">+</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Unit Cost</label>
                                    <input type="number" class="form-control unit-cost" placeholder="Unit Cost">
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Total Cost</label>
                                    <input type="number" class="form-control total-cost" placeholder="0.00" readonly>
                                </div>
                            </div>
                        </div>
                    `;
                    $container.append(block);
                });

                bindEvents($container);
            });

            $select.trigger('choices-updated');
        }

        // Initial setup
        const $initialSelect = $('#fertilizer-application-selector');
        const $initialContainer = $('#fertilizer-application-container');
        observeAndBind($initialSelect, $initialContainer, applicationIndex);

        $('#add-application-btn').on('click', function () {
            applicationIndex++;

            const newSelectId = `fertilizer-application-selector-${applicationIndex}`;
            const newContainerId = `fertilizer-application-container-${applicationIndex}`;
            const fertilizerOptions = [
                "Complete (14-14-14-24S)",
                "Ammonium Phosphate (16-20-0)",
                "Ammonium Sulphate (21-0-0-24S)",
                "Muriate of Potash (0-0-60)",
                "Urea (46-0-0)"
            ];

            const $newGroup = $(`
                <div class="fertilizer-application-group mt-4" data-app-index="${applicationIndex}">
                   <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">${ordinal(applicationIndex)} Application</label>
                        <button type="button" class="btn btn-sm btn-danger remove-application-btn">
                            <i class="ri-delete-bin-line"></i> Remove
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label class="form-label">Select Fertilizer</label>
                            <select id="${newSelectId}" name="fertilizer-application-${applicationIndex}[]" class="form-control fertilizer-application-selector" multiple
                                data-choices data-choices-removeitem>
                                ${fertilizerOptions.map(f => `<option value="${f}">${f}</option>`).join('')}
                            </select>
                        </div>
                    </div>
                    <div id="${newContainerId}" class="mt-3 fertilizer-application-container"></div>
                    ${getLaborAndSnacksHTML(applicationIndex)}
                </div>
            `);

            $('#fertilizer-applications-wrapper').append($newGroup);

            const $newSelect = $(`#${newSelectId}`);
            const $newContainer = $(`#${newContainerId}`);

            initializeChoices($newSelect[0]);
            observeAndBind($newSelect, $newContainer, applicationIndex);
            bindEvents($newGroup);
        });

        $(document).on('click', '.remove-application-btn', function () {
            $(this).closest('.fertilizer-application-group').remove();
        });

    });

    // $(document).ready(function () {
    //     let fertilizerIndex = 0;

    //     function generateFertilizerBlock(index) {
    //         return `
    //         <div class="block fertilizer-block" data-index="${index}">
    //             <div class="row g-3 align-items-center">
    //                 <div class="col-12 mb-2">
    //                     <label class="form-label mb-0">Type of Fertilizer</label>
    //                     <select class="form-control select2 mt-2">
    //                         <option selected disabled hidden>-- SELECT TYPE OF FERTILIZER --</option>
    //                         <option value="Complete (14-14-14-24S)">Complete (14-14-14-24S)</option>
    //                         <option value="Ammonium Phosphate (16-20-0)">Ammonium Phosphate (16-20-0)</option>
    //                         <option value="Ammonium Sulphate (21-0-0-24S)">Ammonium Sulphate (21-0-0-24S)</option>
    //                         <option value="Muriate of Potash (0-0-60)">Muriate of Potash (0-0-60)</option>
    //                         <option value="Urea (46-0-0)">Urea (46-0-0)</option>
    //                     </select>
    //                 </div>
    //             </div>
    //             <div class="row g-3">
    //                 <div class="col-12 d-flex align-items-center gap-3">
    //                     <div class="form-check form-check-inline">
    //                         <input class="form-check-input labor-type" type="radio" name="soaking-type-${index}" value="free" id="free-${index}">
    //                         <label class="form-check-label" for="free-${index}">Free</label>
    //                     </div>
    //                     <div class="form-check form-check-inline">
    //                         <input class="form-check-input labor-type" type="radio" name="soaking-type-${index}" value="purchase" id="purchase-${index}" checked>
    //                         <label class="form-check-label" for="purchase-${index}">Purchase</label>
    //                     </div>
    //                 </div>
    //             </div>

    //             <div class="row p-3 mt-2 mb-3 rounded bg-light">
    //                 <div class="col-4">
    //                     <label class="form-label text-muted">Qty</label>
    //                     <div class="input-step step-primary full-width d-flex">
    //                         <button type="button" class="minus">–</button>
    //                         <input type="number" class="product-quantity form-control text-center qty" value="0" min="0" step="1">
    //                         <button type="button" class="plus">+</button>
    //                     </div>
    //                 </div>
    //                 <div class="col-4">
    //                     <label class="form-label text-muted">Unit Cost</label>
    //                     <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
    //                 </div>
    //                 <div class="col-4">
    //                     <label class="form-label text-muted">Total Cost</label>
    //                     <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
    //                 </div>
    //             </div>
    //             <div class="row g-3">
    //                 <div class="col-12 d-flex justify-content-end">
    //                     <button type="button" class="btn btn-danger remove-fertilizer">
    //                         <i class="ri ri-delete-bin-fill"></i> Remove
    //                     </button>
    //                 </div>
    //             </div>
    //             <hr class="text-muted">
    //         </div>`;
    //     }

    //     function bindEvents($context) {
    //         $context.find('.minus').click(function () {
    //             const $input = $(this).siblings('input');
    //             let val = parseInt($input.val()) || 0;
    //             if (val > 0) $input.val(val - 1).trigger('input');
    //         });

    //         $context.find('.plus').click(function () {
    //             const $input = $(this).siblings('input');
    //             let val = parseInt($input.val()) || 0;
    //             $input.val(val + 1).trigger('input');
    //         });

    //         $context.find('.qty, .unit-cost').on('input', function () {
    //             const $block = $(this).closest('.block');
    //             const qty = parseFloat($block.find('.qty').val()) || 0;
    //             const cost = parseFloat($block.find('.unit-cost').val()) || 0;
    //             $block.find('.total-cost').val((qty * cost).toFixed(2));
    //         });

    //         $context.find('input[type=radio][name^="soaking-type-"]').change(function () {
    //             const $block = $(this).closest('.block');
    //             const isFree = $(this).val() === 'free';

    //             $block.find('.qty, .unit-cost, .total-cost').prop('disabled', isFree);
    //             $block.find('.minus, .plus').prop('disabled', isFree);

    //             if (isFree) {
    //                 $block.find('.qty').val(0);
    //                 $block.find('.unit-cost').val('');
    //                 $block.find('.total-cost').val('');
    //             }
    //         });

    //         $context.find('.remove-fertilizer').click(function () {
    //             $(this).closest('.fertilizer-block').remove();
    //         });
    //     }

    //     // Add initial event for add button
    //     $('button:contains("Type of Fertilizer")').click(function (e) {
    //         e.preventDefault();
    //         const $newBlock = $(generateFertilizerBlock(fertilizerIndex++));
    //         $('#seedbed-fertilization-regular-fields').append($newBlock);
    //         bindEvents($newBlock);

    //         // Reinitialize select2
    //         $newBlock.find('select.select2').select2();
    //     });

    //     // Initial binding (if there's already a block)
    //     $('#seedbed-fertilization-regular-fields .fertilizer-block').each(function () {
    //         bindEvents($(this));
    //     });

    //     $('#add-fertilizer-btn').trigger('click');

    // });

</script>
