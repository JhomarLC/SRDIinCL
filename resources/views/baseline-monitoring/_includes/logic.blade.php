<script>
    function updateActivityTotals() {
        const activityTotals = {};
        let grandTotal = 0;

        $('[data-activity]').each(function () {
            const $section = $(this);
            const activityKey = $section.data('activity');
            let activityTotal = 0;

            const hasPackage = $section.data('has-package') === true || $section.data('has-package') === 'true';
            let isPackage = false;

            const isCropEstablishment = activityKey === 'crop-establishment';
            const isWaterManagement = activityKey === 'water-management';

            const cropMethod = isCropEstablishment ? $('#crop-method').val() : null;
            const establishmentType = isCropEstablishment
                ? cropMethod === 'DWSR'
                    ? $('select[name="establishment_type"]', '#dwsr-section').val()
                    : $('input[name="tpr_establishment_type"]:checked').val()
                : null;

            // ✅ WATER MANAGEMENT logic
            if (isWaterManagement) {
                const irrigationType = $('input[name="water-management-type"]:checked').val();

                if (irrigationType === 'nia') {
                    // Just use the main NIA total cost input
                    const niaTotal = parseFloat($('#nia-total-cost-input').val()) || 0;
                    activityTotal = niaTotal;
                } else {
                    // Supplementary logic
                    isPackage = $('#water-management-pakyaw').is(':checked');

                    if (isPackage) {
                        const val = parseFloat($('#water-management-pakyaw-total-cost input').val()) || 0;
                        activityTotal = val;
                    } else {
                        $('#irrigation-blocks-container .irrigation-block').each(function () {
                            const $block = $(this);
                            const method = $block.find('input[type="radio"]:checked').val();

                            if (method === 'is_nia_both') {
                                const val = parseFloat($block.find('.nia-per-irrigation-cost').val()) || 0;
                                activityTotal += val;
                            } else {
                                $block.find('.supplementary-irrigation-details .block').each(function () {
                                    const val = parseFloat($(this).find('.total-cost').val()) || 0;
                                    activityTotal += val;
                                });
                            }
                        });
                    }
                }
            }

            // ✅ CROP ESTABLISHMENT logic
            else if (isCropEstablishment) {
                if (cropMethod === 'TPR') {
                    isPackage = $('#crop-establishment-pakyaw').is(':checked');
                }

                if (isPackage) {
                    const pakyawInput = $section.find('[id$="-pakyaw-total-cost"] input[type="number"]');
                    if (pakyawInput.length) {
                        const val = parseFloat(pakyawInput.val()) || 0;
                        activityTotal = val;
                    }
                } else {
                    let $blocks = cropMethod === 'DWSR'
                        ? $section.find('#dwsr-section .block')
                        : $section.find('#tpr-section .block');

                    $blocks.find('.total-cost').filter(':not(:disabled)').each(function () {
                        const $block = $(this).closest('.block');
                        const isManualOnly = $block.is('[data-tpr-block="manual-only"]');

                        if (cropMethod === 'TPR' && establishmentType === 'Mechanical' && isManualOnly) return;

                        const val = parseFloat($(this).val()) || 0;
                        activityTotal += val;
                    });
                }
            }

            // ✅ DEFAULT (all other activity tabs)
            else {
                isPackage = hasPackage && $section.find('[id$="-pakyaw"]').is(':checked');

                if (isPackage) {
                    const pakyawInput = $section.find('[id$="-pakyaw-total-cost"] input[type="number"]');
                    if (pakyawInput.length) {
                        const val = parseFloat(pakyawInput.val()) || 0;
                        activityTotal = val;
                    }
                } else {
                    $section.find('.block .total-cost').filter(':not(:disabled)').each(function () {
                        const val = parseFloat($(this).val()) || 0;
                        activityTotal += val;
                    });
                }
            }

            // ✅ Always include variety and fertilizer block totals
            $section.find('.variety-block .total-cost, .fertilizer-block .total-cost')
                .filter(':not(:disabled)')
                .each(function () {
                    const val = parseFloat($(this).val()) || 0;
                    activityTotal += val;
                });

            // ✅ Store and render total for each activity
            activityTotals[activityKey] = activityTotal;

            $(`#total-${activityKey}`).text(activityTotal.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

            grandTotal += activityTotal;
        });

        // ✅ Final grand total update
        $('#grand-total-expenses').text(grandTotal.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
    }
    // Reusable update trigger for all key interactions
    function bindWaterManagementEvents() {
        // When switching NIA/Supplementary type
        $(document).on('change', 'input[name="water-management-type"]', function () {
            const isNia = $(this).val() === 'nia';

            // Toggle visibility
            $('#water-management-nia-total-cost').toggle(isNia);
            $('#water-management-regular-fields').toggle(!isNia);

            updateActivityTotals();
        });

        // When typing in the main NIA total cost input (delegated for dynamic cases)
        $(document).on('input', '#nia-total-cost-input', function () {
            updateActivityTotals();
        });

        // When toggling package checkbox
        $(document).on('change', '#water-management-pakyaw', function () {
            updateActivityTotals();
        });

        // When changing per-irrigation radio (NIA/Supplementary)
        $(document).on('change', '.irrigation-methods input[type="radio"]', function () {
            const $block = $(this).closest('.irrigation-block');
            const selected = $(this).val();

            if (selected === 'is_nia_both') {
                $block.find('.nia-total-cost-irrigation').show();
                $block.find('.supplementary-irrigation-details').hide();
            } else {
                $block.find('.nia-total-cost-irrigation').hide();
                $block.find('.supplementary-irrigation-details').show();
            }

            updateActivityTotals();
        });

        // When typing in any NIA per-irrigation cost input
        $(document).on('input', '.nia-per-irrigation-cost', function () {
            updateActivityTotals();
        });
    }

    // Call once on DOM ready
    $(document).ready(function () {
        bindWaterManagementEvents();
    });

    $(document).ready(function () {
        // DWSR dynamic input listeners
        $(document).on('input', '#dwsr-section .quantity, #dwsr-section .unit-cost', function () {
            const $row = $(this).closest('.row');
            const qty = parseFloat($row.find('.quantity').val()) || 0;
            const unit = parseFloat($row.find('.unit-cost').val()) || 0;
            const total = qty * unit;

            $row.find('.total-cost').val(total.toFixed(2));
            updateActivityTotals();
        });

        $('select[name="establishment_type"]').on('change', function () {
            const selected = $(this).val();
            $('input[name="crop_est_particulars[0][activity]"]').val(selected || '');
        });

        $(document).on('wheel', 'input[type=number]', function (e) {
            $(this).blur(); // remove focus to prevent scroll change
        });


        updateActivityTotals();

        $(document).on('input', '[id$="-pakyaw-total-cost"] input[type="number"]', function () {
            updateActivityTotals();
        });

        $(document).off('click', '.minus').on('click', '.minus', function () {
            const $input = $(this).siblings('input.quantity');
            let current = parseInt($input.val()) || 0;
            if (current > 0) {
                $input.val(current - 1);
            } else {
                $input.val(0); // ensure it's 0
            }
            $input.trigger('input'); // ✅ always trigger input

            updateActivityTotals();
        });


        $(document).off('click', '.plus').on('click', '.plus', function () {
            const $input = $(this).siblings('input.quantity');
            let current = parseInt($input.val()) || 0;
            $input.val(current + 1).trigger('input');

            updateActivityTotals();
        });

        $(document).on('input', '.quantity, .unit-cost', function () {
            const $row = $(this).closest('.row');
            const qty = parseFloat($row.find('.quantity').val()) || 0;
            const unit = parseFloat($row.find('.unit-cost').val()) || 0;
            $row.find('.total-cost').val((qty * unit).toFixed(2));

            updateActivityTotals();
        });

        // General radio change for Free vs Purchase
        $(document).on('change', 'input[type=radio][name^="purchase_status_"], input[type=radio][name^="fertilizer_type_"], input[type=radio][name^="pesticide_type_"]', function () {
            const $block = $(this).closest('.variety-block, .fertilizer-block, .pesticide-block');
            const isFree = $(this).val() === 'free';

            const $qty = $block.find('.quantity');
            const $unit = $block.find('.unit-cost');
            const $total = $block.find('.total-cost');
            const $minus = $block.find('.minus');
            const $plus = $block.find('.plus');

            if (isFree) {
                $qty.val(0).prop('disabled', false);
                $unit.val('').prop('disabled', true);
                $total.val('').prop('disabled', true).trigger('input'); // <-- trigger update
            } else {
                $unit.prop('disabled', false);
                $total.val('').prop('disabled', true).trigger('input'); // <-- trigger update
            }

            $minus.prop('disabled', false);
            $plus.prop('disabled', false);

            updateActivityTotals();
        });

         // DWSR vs TPR toggle
        $('input[name="method_crop_establishment"]').on('change', function () {
            const method = $('input[name="method_crop_establishment"]:checked').val();
            $('#crop-method').val(method);

            if (method === 'DWSR') {
                // Hide/show
                $('#dwsr-section').show();
                $('#tpr-section').hide();

                // Hide Seedbed Prep and Fert tabs
                $('#v-pills-seedbed-prep-tab, #v-pills-seedbed-fertilization-tab').hide();

                // RESET TPR inputs
                $('#crop-establishment-pakyaw').prop('checked', false); // uncheck
                $('#crop-establishment-pakyaw-total-cost-input').val('');
                $('#tpr-section .total-cost').val('');

                 // Disable TPR inputs
                $('#tpr-section input, #tpr-section select').prop('disabled', true);
                // Enable DWSR inputs
                $('#dwsr-section input, #dwsr-section select').prop('disabled', false);
            } else {
                $('#dwsr-section').hide();
                $('#tpr-section').show();

                // Show Seedbed Prep and Fert tabs
                $('#v-pills-seedbed-prep-tab, #v-pills-seedbed-fertilization-tab').show();

                // RESET DWSR inputs
                $('#dwsr-section .total-cost').val('');

                 // Disable DWSR inputs
                $('#dwsr-section input, #dwsr-section select').prop('disabled', true);
                // Enable TPR inputs
                $('#tpr-section input, #tpr-section select').prop('disabled', false);

            }

            updateActivityTotals();
        });

        // Manual/Mechanical toggle
        $('input[name="establishment_type"]').on('change', function () {
            updateActivityTotals();
        });


        // Initial check on page load
        $('input[name="method_crop_establishment"]:checked').trigger('change');

            function calculateTotalYield() {
            const numberOfBags = parseFloat($('#number_of_bags').val()) || 0;
            const avgWeightPerBag = parseFloat($('#avg_weight_per_bag').val()) || 0;
            const totalYield = (numberOfBags * avgWeightPerBag) / 1000 ;

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

            // ✅ Update totals when toggling package mode
            updateActivityTotals();
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

            updateActivityTotals(); // ← important!
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

            updateActivityTotals(); // ← important!
        })

        $('#crop-establishment-pakyaw').on('change', function () {
            const isChecked = $(this).is(':checked');
            $('#crop-est-is-pakyaw').val(isChecked ? 1 : 0);
            $('#crop-establishment-pakyaw-total-cost').toggle(isChecked);
            $('#crop-establishment-regular-fields').toggle(!isChecked);
            updateActivityTotals();
        });

        $('#crop-establishment-pakyaw').on('change', function () {
            const isChecked = $(this).is(':checked');
            const $pakyawInput = $('#crop-establishment-pakyaw-total-cost-input');
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
                updateActivityTotals();
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
            updateActivityTotals();
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
                            name="purchase_status_${varietyId}" id="soaking_free_${varietyId}"
                            value="free">
                        <label class="form-check-label" for="soaking_free_${varietyId}">Free</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                            name="purchase_status_${varietyId}" id="soaking_purchase_${varietyId}"
                            value="purchase" checked>
                        <label class="form-check-label" for="soaking_purchase_${varietyId}">Purchase</label>
                    </div>
                    <div class="row mt-2 bg-light p-3 rounded">
                        <div class="col-4">
                            <label class="form-label text-muted">Qty</label>
                            <div class="input-step step-primary full-width d-flex">
                                <button type="button" class="minus">–</button>
                                <input type="number" class="quantity form-control text-center soaking-qty quantity" value="0" min="0" step="1">
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
            updateActivityTotals(); // <- add this here
        }

        // Renumber the variety blocks: 1st, 2nd, 3rd...
        function reindexVarietyBlocks() {
            const suffixes = ['st', 'nd', 'rd'];
            $varietyContainer.find('.variety-block').each(function (index) {
                const label = `${index + 1}${suffixes[index] || 'th'} Variety: ${$(this).data('variety-name')}`;
                $(this).find('.variety-label').text(label);
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
                        <input class="form-check-input purchase-toggle" type="radio"
                            name="fertilizer_type_${fertilizerId}" id="fertilizer_free_${fertilizerId}"
                            value="free">
                        <label class="form-check-label" for="fertilizer_free_${fertilizerId}">Free</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input purchase-toggle" type="radio"
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
            $('input[type=radio][name^=fertilizer_type_]').off('change').on('change', function () {
                const $block = $(this).closest('.fertilizer-block');
                const isFree = $(this).val() === 'free';

                const $qty = $block.find('.quantity');
                const $unit = $block.find('.unit-cost');
                const $total = $block.find('.total-cost');
                const $minus = $block.find('.minus');
                const $plus = $block.find('.plus');

                if (isFree) {
                    $qty.val(0).prop('disabled', false);
                    $unit.val('').prop('disabled', true);
                    $total.val('').prop('disabled', true);
                    $minus.prop('disabled', false);
                    $plus.prop('disabled', false);
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

    let appCounter = 1;

    $(document).ready(function () {
        // Initialize first static block
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
        $('#add-application-btn').on('click', function (e) {
            e.preventDefault();

            appCounter++; // Always increment to keep unique IDs/names
            const template = $('#fertilizer-application-template').html();
            const newHtml = template.replace(/{index}/g, appCounter);
            const $newBlock = $(newHtml);

            // Update name attributes with new counter
            $newBlock.find('[name]').each(function () {
                const oldName = $(this).attr('name');
                if (oldName && oldName.includes('fertilizer_management[')) {
                    const newName = oldName.replace(/fertilizer_management\[\d+\]/, `fertilizer_management[${appCounter}]`);
                    $(this).attr('name', newName);
                }
            });

            $('#fertilizer-applications-wrapper').append($newBlock);
            $newBlock.find('.quantity, .unit-cost').trigger('input');

            // Always reindex for correct 1st, 2nd, 3rd label
            reindexApplicationLabels();

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
            $(this).closest('.fertilizer-application-block').remove();
            reindexApplicationLabels();
            updateActivityTotals();
        });
    });

    // ✅ Always update visible labels based on DOM order, not appCounter
    function reindexApplicationLabels() {
        const suffixes = ['st', 'nd', 'rd'];
        $('.fertilizer-application-block').each(function (index) {
            let suffix = 'th';
            if (index === 0) suffix = 'st';
            else if (index === 1) suffix = 'nd';
            else if (index === 2) suffix = 'rd';

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
            updateActivityTotals();
        }

        // Run on page load
        toggleCropEstablishmentSection();

        // Run on change
        $('input[name="method_crop_establishment"]').on('change', function () {
            toggleCropEstablishmentSection();
        });

        function toggleTPRFields(establishmentType) {
            if (establishmentType === 'Manual') {
                $('[data-tpr-block="manual-only"]').show();
            } else {
                $('[data-tpr-block="manual-only"]').hide();
            }
        }

        $(document).on('change', 'input[name="establishment_type"]', function () {
            const value = $(this).val();
            toggleTPRFields(value);
            $('.total-cost', '#tpr-section').val('');
            updateActivityTotals();
        });

        // Trigger totals calculation for DWSR fields
        $('#dwsr-section').on('input', '.quantity, .unit-cost', function () {
            const $row = $(this).closest('.row');
            const qty = parseFloat($row.find('.quantity').val()) || 0;
            const unit = parseFloat($row.find('.unit-cost').val()) || 0;
            $row.find('.total-cost').val((qty * unit).toFixed(2));

            updateActivityTotals();
        });
    });

    $(document).ready(function () {
        let irrigationCount = 1;

        function toggleMainIrrigationType() {
            const selected = $('input[name="water-management-type"]:checked').val();
            if (selected === 'supplementary') {
                $('#water-management-regular-fields').show();
                $('#water-management-nia-total-cost').hide();
                togglePackageMode();
            } else {
                $('#water-management-regular-fields').hide();
                $('#water-management-nia-total-cost').show();
            }
        }

        function togglePackageMode() {
            if ($('#water-management-pakyaw').is(':checked')) {
                $('#water-management-pakyaw-total-cost').show();
                $('#irrigation-blocks-container').hide();
            } else {
                $('#water-management-pakyaw-total-cost').hide();
                $('#irrigation-blocks-container').show();
                $('.irrigation-block').each(function () {
                    toggleIrrigationBlockType($(this));
                });
            }
        }

        function toggleIrrigationBlockType($block) {
            const selected = $block.find('input[type="radio"]:checked').val();
            if (selected === 'is_suplementary_both') {
                $block.find('.supplementary-irrigation-details').show();
                $block.find('.nia-total-cost-irrigation').hide();
            } else {
                $block.find('.supplementary-irrigation-details').hide();
                $block.find('.nia-total-cost-irrigation').show();
            }
        }

        function ordinalSuffix(i) {
            const j = i % 10, k = i % 100;
            if (j === 1 && k !== 11) return i + "st";
            if (j === 2 && k !== 12) return i + "nd";
            if (j === 3 && k !== 13) return i + "rd";
            return i + "th";
        }

        $(document).on('click', '.remove-irrigation', function () {
            $(this).closest('.irrigation-block').remove();
            updateActivityTotals();
        });

        $('.add-irrigation').on('click', function (e) {
            e.preventDefault();
            irrigationCount++;

            const $firstBlock = $('.irrigation-block').first();
            const $newBlock = $firstBlock.clone();

            // Add remove button
            $newBlock.find('.irrigation-column').after(`
                <button type="button" class="btn btn-sm btn-danger ms-3 remove-irrigation">
                    <i class="ri-delete-bin-line"></i> Remove
                </button>
            `);

            // Reset values
            $newBlock.find('input[type="number"]').each(function () {
                const isDisabled = $(this).prop('disabled');
                if (!isDisabled) {
                    if ($(this).hasClass('quantity')) {
                        $(this).val(0);
                    } else {
                        $(this).val('');
                    }
                } else {
                    $(this).val('0.00');
                }
            });

            // Unique radio group
            const groupName = `is_both_type_${irrigationCount}`;
            $newBlock.find('input[type="radio"]').each(function (index) {
                const $radio = $(this);
                const val = $radio.val();

                // Create unique id
                const newId = `${val}_${irrigationCount}`;
                $radio.attr('name', groupName);
                $radio.attr('id', newId);

                // Also update label "for"
                $radio.next('label').attr('for', newId);

                // Default to supplementary
                $radio.prop('checked', val === 'is_suplementary_both');
            });
            // Update title
            $newBlock.find('.irrigation-title').text(`${ordinalSuffix(irrigationCount)} Irrigation`);

            // Reset state
            $newBlock.find('.nia-total-cost-irrigation').hide();
            $newBlock.find('.supplementary-irrigation-details').show();

            // Remove IDs to prevent conflicts
            $newBlock.removeAttr('id');

            // Append to container
            $('#irrigation-blocks-container').append($newBlock);
        });

        // Delegate radio change to handle cloned elements
        $(document).on('change', 'input[type="radio"][name^="is_both_type"]', function () {
            const $block = $(this).closest('.irrigation-block');
            toggleIrrigationBlockType($block);
        });

        // Initialize
        $('#water-management-supplementary').prop('checked', true);
        toggleMainIrrigationType();
        togglePackageMode();
        toggleIrrigationBlockType($('.irrigation-block').first());

        $('input[name="water-management-type"]').on('change', toggleMainIrrigationType);
        $('#water-management-pakyaw').on('change', togglePackageMode);
    });

    function togglePakyaw(sectionId) {
        const isChecked = $(`#${sectionId}-pakyaw`).is(':checked');
        $(`#${sectionId}-pakyaw-total-cost`).toggle(isChecked);
        $(`#${sectionId}-regular-fields`).toggle(!isChecked);
        updateActivityTotals();
    }
    $('#crop-establishment-pakyaw').on('change', () => togglePakyaw('crop-establishment'));

    let pestAppCounter = 1;

    $(document).ready(function () {
        // Initialize first static block
        new Choices(document.getElementById('pesticide-application-selector-1'), {
            removeItemButton: true
        });

        new Choices(document.getElementById('others-pesticide-application-1'), {
            removeItemButton: true
        });

        initPesticideSelector({
            selectorId: 'pesticide-application-selector-1',
            othersInputId: 'others-pesticide-application-1',
            containerId: 'pesticide-application-container-1',
            blockPrefix: 'pesticide',
            appIndex: 0
        });

        // Add Application
        $('#add-pesticide-application-btn').on('click', function (e) {
            e.preventDefault();

            pestAppCounter++;

            const template = $('#pesticide-application-template').html();
            const newHtml = template.replace(/{index}/g, pestAppCounter);
            const $newBlock = $(newHtml);

            // Update name attributes with new counter
            $newBlock.find('[name]').each(function () {
                const oldName = $(this).attr('name');
                if (oldName && oldName.includes('pest_management[')) {
                    const newName = oldName.replace(/pest_management\[\d+\]/, `pest_management[${appCounter}]`);
                    $(this).attr('name', newName);
                }
            });

            $('#pesticide-applications-wrapper').append($newBlock);
            $newBlock.find('.quantity, .unit-cost').trigger('input');

            reindexPesticideApplicationLabels();

            new Choices(document.getElementById(`pesticide-application-selector-${pestAppCounter}`), {
                removeItemButton: true
            });

            new Choices(document.getElementById(`others-pesticide-application-${pestAppCounter}`), {
                removeItemButton: true
            });

            initPesticideSelector({
                selectorId: `pesticide-application-selector-${pestAppCounter}`,
                othersInputId: `others-pesticide-application-${pestAppCounter}`,
                containerId: `pesticide-application-container-${pestAppCounter}`,
                blockPrefix: 'pesticide',
                appIndex: pestAppCounter - 1
            });
        });

        // Remove Application
        $(document).on('click', '.remove-application-btn', function () {
            $(this).closest('.pesticide-application-block').remove();
            reindexPesticideApplicationLabels();
            updateActivityTotals();
        });
    });

    function reindexPesticideApplicationLabels() {
        const suffixes = ['st', 'nd', 'rd'];
        $('.pesticide-application-block').each(function (index) {
            let suffix = 'th';
            if (index === 0) suffix = 'st';
            else if (index === 1) suffix = 'nd';
            else if (index === 2) suffix = 'rd';

            $(this).find('.application-label').text(`${index + 1}${suffix} Application`);
        });
    }

    $(document).ready(function () {
        const mechanicalBlock = $('#mechanical-block');
        const manualFields = $('#manual-fields');
        const packageCheckbox = $('#manual-package-checkbox');
        const packageTotal = $('#manual-package-total-cost');

        // Initial view
        updateHarvestView();

        // Change harvesting type
        $('.harvesting-type').on('change', updateHarvestView);

        // Toggle package total
        packageCheckbox.on('change', function () {
            if ($(this).is(':checked')) {
                manualFields.hide();
                packageTotal.show();
            } else {
                manualFields.show();
                packageTotal.hide();
            }
        });

        function updateHarvestView() {
            const type = $('input[name="harvesting-type"]:checked').val();

            if (type === 'Mechanical') {
                $('#mechanical-block').show();
                $('#manual-fields').hide();
                $('#manual-package-checkbox-container').hide();
                $('#manual-package-total-cost').hide();
                $('#manual-package-checkbox').prop('checked', false);
            } else {
                $('#mechanical-block').hide();
                $('#manual-fields').show();
                $('#manual-package-checkbox-container').show();
            }
        }
    });

    $(document).ready(function () {
        function computeMechanicalHarvestCost() {
            const $block = $('#mechanical-block');
            const bags = parseFloat($block.find('.bags').val()) || 0;
            const avgWeight = parseFloat($block.find('.avg-bag-weight').val()) || 0;
            const pricePerKilo = parseFloat($block.find('.price-per-kg').val()) || 0;

            const total = bags * avgWeight * pricePerKilo;
            $block.find('.total-mechanical-cost').val(total.toFixed(2));
        }
        // Trigger calculation on input
        $('#mechanical-block').on('input', '.bags, .avg-bag-weight, .price-per-kg', computeMechanicalHarvestCost);

        computeMechanicalHarvestCost(); // Initial run
    });

    $(document).ready(function () {
        function computePermanentLaborCost() {
            const $block = $('#permanent-block:has(.percent-share)');
            const bags = parseFloat($block.find('.bags').val()) || 0;
            const avgWeight = parseFloat($block.find('.avg-bag-weight').val()) || 0;
            const pricePerKilo = parseFloat($block.find('.price-per-kg').val()) || 0;
            const percent = parseFloat($block.find('.percent-share').val()) || 0;

            const shareFraction = percent / 100;
            const total = bags * shareFraction * avgWeight * pricePerKilo;

            $block.find('.total-permanent-cost').val(total.toFixed(2));
        }

        // Input triggers
        $('#permanent-block').on('input', '.bags, .avg-bag-weight, .price-per-kg, .percent-share', computePermanentLaborCost);

        // Initial calculation on load
        computePermanentLaborCost();
    });


// $(document).ready(function () {
//     updateHarvestView(); // initial
//     $('.harvesting-type').on('change', updateHarvestView);
// });
</script>
