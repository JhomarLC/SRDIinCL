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
        const $varietyContainer = $('#variety-container');
        let otherCounter = 0;

        // MutationObserver for Choices.js dropdown changes
        const selectorNode = document.getElementById('variety-selector');
        if (selectorNode) {
            const observer = new MutationObserver(() => {
                $('#variety-selector').trigger('choices-updated');
            });
            observer.observe(selectorNode, { attributes: true, childList: true, subtree: true });
        }

        // Remove "Others" block when item is removed from Choices
        document.addEventListener('removeItem', function (event) {
            if (event.detail && event.detail.value && event.target.id === 'others') {
                const removedValue = event.detail.value.trim().toLowerCase();
                $varietyContainer.find('.variety-block').filter(function () {
                    const id = $(this).data('variety-id');
                    const blockName = $(this).data('variety-name')?.toString().toLowerCase();
                    return id && id.toString().startsWith('other_') && blockName === removedValue;
                }).remove();

                reindexVarietyBlocks();
            }
        });

        // Handle changes in selected dropdown
        $(document).on('choices-updated', '#variety-selector', function () {
            // Remove blocks added from dropdown (not "others")
            $varietyContainer.find('.variety-block').filter(function () {
                return !$(this).data('variety-id')?.toString().startsWith('other_');
            }).remove();

            $('#variety-selector option:selected').each(function () {
                const varietyId = $(this).val();
                const varietyName = $(this).data('name') || $(this).text();

                createVarietyBlock(varietyId, varietyName, false);
            });

            reindexVarietyBlocks();
        });

        // Add from Others input
        $('#others').on('change', function () {
            const inputVal = $(this).val().trim();
            if (!inputVal) return;

            const varietyId = `other_${++otherCounter}`;
            const varietyName = inputVal;

            createVarietyBlock(varietyId, varietyName, true);
            $(this).val('');
            reindexVarietyBlocks();
        });

        // Function to create a new variety block
        function createVarietyBlock(varietyId, varietyName, isOther) {
            const block = `
                <div class="border rounded p-3 mb-3 variety-block" data-variety-id="${varietyId}" data-variety-name="${varietyName}">
                    <h6 class="variety-label"></h6>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                            name="soaking_type_${varietyId}" id="soaking_free_${varietyId}"
                            value="free">
                        <label class="form-check-label" for="soaking_free_${varietyId}">Free</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                            name="soaking_type_${varietyId}" id="soaking_purchase_${varietyId}"
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

            $varietyContainer.append(block);
            bindEvents();
        }

        // Renumber the variety blocks: 1st, 2nd, 3rd...
        function reindexVarietyBlocks() {
            const suffixes = ['st', 'nd', 'rd'];
            $varietyContainer.find('.variety-block').each(function (index) {
                const label = `${index + 1}${suffixes[index] || 'th'} Variety: ${$(this).data('variety-name')}`;
                $(this).find('.variety-label').text(label);
            });
        }

        // Bind all input/button events
        function bindEvents() {
            $('.minus').off('click').on('click', function () {
                const $input = $(this).siblings('input.quantity');
                let current = parseInt($input.val()) || 0;
                if (current > 0) $input.val(current - 1).trigger('input');
            });

            $('.plus').off('click').on('click', function () {
                const $input = $(this).siblings('input.quantity');
                let current = parseInt($input.val()) || 0;
                $input.val(current + 1).trigger('input');
            });

            $('.quantity, .unit-cost').off('input').on('input', function () {
                const $row = $(this).closest('.row');
                const qty = parseFloat($row.find('.quantity').val()) || 0;
                const unit = parseFloat($row.find('.unit-cost').val()) || 0;
                $row.find('.total-cost').val((qty * unit).toFixed(2));
            });

            $('input[type=radio][name^=soaking_type_]').off('change').on('change', function () {
                const $block = $(this).closest('.variety-block');
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

        // Initial trigger to build selected varieties
        $('#variety-selector').trigger('choices-updated');
    });

    // Seedbed Fertilizations
    $(document).ready(function () {
        const $fertilizerContainer = $('#fertilizer-container');
        let otherFertilizerCounter = 0;

        // MutationObserver for fertilizer dropdown
        const fertilizerSelectorNode = document.getElementById('fertilizer-selector');
        if (fertilizerSelectorNode) {
            const observer = new MutationObserver(() => {
                $('#fertilizer-selector').trigger('choices-updated');
            });
            observer.observe(fertilizerSelectorNode, { attributes: true, childList: true, subtree: true });
        }

        // Handle removal from "Others"
        document.addEventListener('removeItem', function (event) {
            if (event.detail && event.detail.value && event.target.id === 'others-fertilizer') {
                const removedValue = event.detail.value.trim().toLowerCase();
                $fertilizerContainer.find('.fertilizer-block').filter(function () {
                    const id = $(this).data('fertilizer-id');
                    const blockName = $(this).data('fertilizer-name')?.toString().toLowerCase();
                    return id && id.toString().startsWith('other_') && blockName === removedValue;
                }).remove();

                reindexFertilizerBlocks();
            }
        });

        // Handle select dropdown changes
        $(document).on('choices-updated', '#fertilizer-selector', function () {
            $fertilizerContainer.find('.fertilizer-block').filter(function () {
                return !$(this).data('fertilizer-id')?.toString().startsWith('other_');
            }).remove();

            $('#fertilizer-selector option:selected').each(function () {
                const fertilizerId = $(this).val();
                const fertilizerName = $(this).text();
                createFertilizerBlock(fertilizerId, fertilizerName, false);
            });

            reindexFertilizerBlocks();
        });

        // Handle "Others" input
        $('#others-fertilizer').on('change', function () {
            const inputVal = $(this).val().trim();
            if (!inputVal) return;

            const fertilizerId = `other_${++otherFertilizerCounter}`;
            const fertilizerName = inputVal;

            createFertilizerBlock(fertilizerId, fertilizerName, true);
            $(this).val('');
            reindexFertilizerBlocks();
        });

        // Create a fertilizer block
        function createFertilizerBlock(fertilizerId, fertilizerName, isOther) {
            const block = `
                <div class="border rounded p-3 mb-3 fertilizer-block" data-fertilizer-id="${fertilizerId}" data-fertilizer-name="${fertilizerName}">
                    <h6 class="fertilizer-label"></h6>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                            name="fertilizer_type_${fertilizerId}" id="fertilizer_free_${fertilizerId}"
                            value="free">
                        <label class="form-check-label" for="fertilizer_free_${fertilizerId}">Free</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                            name="fertilizer_type_${fertilizerId}" id="fertilizer_purchase_${fertilizerId}"
                            value="purchase" checked>
                        <label class="form-check-label" for="fertilizer_purchase_${fertilizerId}">Purchase</label>
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
                            <input type="number" name="unit_cost_${fertilizerId}" class="form-control unit-cost" placeholder="Unit Cost">
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Total Cost</label>
                            <input type="number" name="total_cost_${fertilizerId}" class="form-control total-cost" placeholder="0.00" readonly>
                        </div>
                    </div>
                </div>
            `;

            $fertilizerContainer.append(block);
            bindFertilizerEvents();
        }

        // Reindex fertilizer blocks
        function reindexFertilizerBlocks() {
            const suffixes = ['st', 'nd', 'rd'];
            $fertilizerContainer.find('.fertilizer-block').each(function (index) {
                const label = `${index + 1}${suffixes[index] || 'th'} Fertilizer: ${$(this).data('fertilizer-name')}`;
                $(this).find('.fertilizer-label').text(label);
            });
        }

        // Bind quantity, cost, and toggle logic
        function bindFertilizerEvents() {
            $('.minus').off('click').on('click', function () {
                const $input = $(this).siblings('input.quantity');
                let current = parseInt($input.val()) || 0;
                if (current > 0) $input.val(current - 1).trigger('input');
            });

            $('.plus').off('click').on('click', function () {
                const $input = $(this).siblings('input.quantity');
                let current = parseInt($input.val()) || 0;
                $input.val(current + 1).trigger('input');
            });

            $('.quantity, .unit-cost').off('input').on('input', function () {
                const $row = $(this).closest('.row');
                const qty = parseFloat($row.find('.quantity').val()) || 0;
                const unit = parseFloat($row.find('.unit-cost').val()) || 0;
                $row.find('.total-cost').val((qty * unit).toFixed(2));
            });

            $('input[type=radio][name^=fertilizer_type_]').off('change').on('change', function () {
                const $block = $(this).closest('.fertilizer-block');
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
        $('#fertilizer-selector').trigger('choices-updated');
    });

    $(document).ready(function () {
        initFertilizerSelector({
            selectorId: 'fertilizer-application-selector',
            othersInputId: 'others-fertilizer-application',
            containerId: 'fertilizer-application-container',
            blockPrefix: 'fertilizer'
        });

    });

    let appCounter = 1;

    $(document).ready(function () {
        // Initialize Choices and selectors for the first block
        new Choices(document.getElementById('fertilizer-application-selector-1'), {
            removeItemButton: true
        });

        new Choices(document.getElementById('others-fertilizer-application-1'), {
            removeItemButton: true
        });

        initFertilizerSelector({
            selectorId: 'fertilizer-application-selector-1',
            othersInputId: 'others-fertilizer-application-1',
            containerId: 'fertilizer-application-container-1',
            blockPrefix: 'fertilizer'
        });

        // Add new application
        $('#add-application-btn').on('click', function () {
            appCounter++;
            const template = $('#fertilizer-application-template').html();
            const newHtml = template.replace(/{index}/g, appCounter);
            $('#fertilizer-applications-wrapper').append(newHtml);

            const suffixes = ['st', 'nd', 'rd'];
            const suffix = suffixes[appCounter - 1] || 'th';
            $(`.fertilizer-application-block`).last().find('.application-label')
                .text(`${appCounter}${suffix} Application`);

            // Init Choices
            new Choices(document.getElementById(`fertilizer-application-selector-${appCounter}`), {
                removeItemButton: true
            });

            new Choices(document.getElementById(`others-fertilizer-application-${appCounter}`), {
                removeItemButton: true
            });

            // Init selector logic
            initFertilizerSelector({
                selectorId: `fertilizer-application-selector-${appCounter}`,
                othersInputId: `others-fertilizer-application-${appCounter}`,
                containerId: `fertilizer-application-container-${appCounter}`,
                blockPrefix: 'fertilizer'
            });
        });

        // Remove application block
        $(document).on('click', '.remove-application-btn', function () {
            if ($('.fertilizer-application-block').length === 1) {
                alert("At least one application is required.");
                return;
            }

            $(this).closest('.fertilizer-application-block').remove();
            reindexApplicationLabels();
        });
    });

    // Helper to reindex application block labels
    function reindexApplicationLabels() {
        const suffixes = ['st', 'nd', 'rd'];
        $('.fertilizer-application-block').each(function (index) {
            const suffix = suffixes[index] || 'th';
            $(this).find('.application-label').text(`${index + 1}${suffix} Application`);
        });
    }

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

</script>
