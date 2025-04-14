<div class="modal fade" id="addnewtopicmodal" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Add Speaker Topics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createTopicForm">
                    @csrf  <!-- CSRF Token for security -->
                    <div class="row g-3">
                        <div class="col-xxl-12">
                            <label for="topic_discussed" class="form-label">Training Topic <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="topic_discussed" name="topic_discussed" aria-label="Select session topic">
                                <option selected disabled hidden>-- SELECT TOPIC DISCUSSED --</option>

                                <optgroup label="A. Overview of the PalayCheck System">
                                    <option value="Overview of the PalayCheck System">1. Overview of the PalayCheck System</option>
                                </optgroup>

                                <optgroup label="C. Integrated Pest Management">
                                    <option value="IPM concepts and principles">1. IPM concepts and principles</option>
                                    <option value="Insect Pests and Natural Enemies">2. Identification and Management of Insect Pests of Rice and their Natural Enemies</option>
                                    <option value="Ecological Engineering">3. Ecological Engineering</option>
                                    <option value="AESA concepts and procedures">4. Agroecosystems Analysis (AESA) concepts and procedures</option>
                                    <option value="Other Pests Management">5. Other Pests (Weeds, GAS, Rodents) and their management</option>
                                    <option value="Rice Disease Management">6. Identification and Management of Major Diseases of Rice</option>
                                    <option value="PalayCheck Key Check 7">7. PalayCheck System Key check 7: No significant yield loss due to pests</option>
                                </optgroup>

                                <optgroup label="B. Integrated Nutrient Management">
                                    <option value="INM Concepts and Fertilizer Management">1. INM Concept and Principles; Nutrient Facts and Management (Organic and Inorganic Fertilizer Materials; Fertilizer Computation)</option>
                                    <option value="MOET App">2. The MOET and the Use of MOET App</option>
                                    <option value="LCC App">3. The Use of LCC App</option>
                                    <option value="RCMAS">4. The use of RCMAS</option>
                                    <option value="Abonong Swak">5. Abonong Swak</option>
                                    <option value="PalayCheck Key Check 5">6. PalayCheck System Key Check 5: Sufficient nutrients from tillering to early panicle initiation and flowering</option>
                                </optgroup>

                            </select>
                            <span class="invalid-feedback" id="topic_discussed_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-12">
                            <label for="topic_date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="topic_date" name="topic_date">
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-secondary"> <i class="ri-add-circle-fill"></i> Add speaker topic</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
