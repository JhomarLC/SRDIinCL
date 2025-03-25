
if (document.querySelectorAll(".form-steps"))
    Array.from(document.querySelectorAll(".form-steps")).forEach(function (form) {
        // Next button logic
        // form.querySelectorAll(".nexttab").forEach(function (nextButton) {
        //     nextButton.addEventListener("click", function (e) {
        //         console.log('Next clicked');

        //         let form = nextButton.closest("form");
        //         let currentTabId = nextButton.closest(".tab-pane").id; // THIS is more accurate than .active.show
        //         let currentPane = document.getElementById(currentTabId);
        //         console.log('Current tab:', currentPane?.id);

        //         let formData = new FormData();

        //         // Reset all invalid feedback
        //         currentPane.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

        //         // Collect only inputs from the current pane
        //         currentPane.querySelectorAll("input, select, textarea").forEach((input) => {

        //             // Skip unchecked radios
        //             if (input.type === 'radio' && !input.checked) {
        //                 return;
        //             }

        //             if (input.name) {
        //                 let name = input.name.replace(/\[\d+\]$/, ''); // training_paid[0] → training_paid

        //                 console.log(name, input.value);
        //                 formData.append(name, input.value);
        //             }
        //         });
        //         // Append current step name
        //         formData.append("step", currentPane.id.replace("pills-", ""));

        //         fetch("admin/validate-step", {
        //             method: "POST",
        //             headers: {
        //                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        //             },
        //             body: formData
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.success) {
        //                 // move to next tab
        //                 document.getElementById(nextButton.getAttribute('data-nexttab')).click();
        //             }
        //         })
        //         .catch(async (error) => {
        //             if (error.status === 422) {
        //                 let res = await error.json();
        //                 Object.keys(res.errors).forEach(key => {
        //                     let input = form.querySelector(`[name="${key}"]`);
        //                     if (input) {
        //                         input.classList.add("is-invalid");
        //                         let feedback = input.parentNode.querySelector(".invalid-feedback");
        //                         if (feedback) feedback.innerText = res.errors[key][0];
        //                     }
        //                 });
        //             }
        //         });
        //     });
        // });

        // if (form.querySelectorAll(".nexttab")) {
        //     Array.from(form.querySelectorAll(".nexttab")).forEach(function (nextButton) {
        //         var tabEl = form.querySelectorAll('button[data-bs-toggle="pill"]');

        //         Array.from(tabEl).forEach(function (item) {
        //             item.addEventListener('show.bs.tab', function (event) {
        //                 event.target.classList.add('done');
        //             });
        //         });

        //         nextButton.addEventListener("click", function () {
        //             form.classList.add('was-validated');
        //             var isValid = true;

        //             // Validate inputs in the current step
        //             form.querySelectorAll(".tab-pane.show .form-control").forEach(function (elem) {
        //                 var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        //                 var inputType = elem.getAttribute("type");

        //                 if (inputType === "email") {
        //                     if (!elem.value.match(validRegex)) {
        //                         elem.classList.add("is-invalid");
        //                         elem.classList.remove("is-valid");
        //                         isValid = false;
        //                     } else {
        //                         elem.classList.remove("is-invalid");
        //                         elem.classList.add("is-valid");
        //                     }
        //                 } else if (inputType === "password") {
        //                     if (elem.value.length < 6) {
        //                         elem.classList.add("is-invalid");
        //                         elem.classList.remove("is-valid");
        //                         isValid = false;
        //                     } else {
        //                         elem.classList.remove("is-invalid");
        //                         elem.classList.add("is-valid");
        //                     }
        //                 } else if (inputType === "text") {
        //                     if (elem.value.trim().length < 1) {
        //                         elem.classList.add("is-invalid");
        //                         elem.classList.remove("is-valid");
        //                         isValid = false;
        //                     } else {
        //                         elem.classList.remove("is-invalid");
        //                         elem.classList.add("is-valid");
        //                     }
        //                 }

        //                 // Remove error when the user starts typing
        //                 elem.addEventListener("input", function () {
        //                     elem.classList.remove("is-invalid");
        //                 });
        //             });

        //             // Proceed to the next tab only if the fields are valid
        //             if (isValid) {
        //                 var nextTab = nextButton.getAttribute('data-nexttab');
        //                 document.getElementById(nextTab).click();
        //                 form.classList.remove('was-validated');

        //                 // Mark previous step as "done" only if valid
        //                 nextButton.closest("form").querySelector('button[data-bs-toggle="pill"].active').classList.add('done');
        //             }
        //         });
        //     });
        // }

        //Pervies tab
        if (form.querySelectorAll(".previestab"))
            Array.from(form.querySelectorAll(".previestab")).forEach(function (prevButton) {

                prevButton.addEventListener("click", function () {
                    var prevTab = prevButton.getAttribute('data-previous');
                    var totalDone = prevButton.closest("form").querySelectorAll(".custom-nav .done").length;
                    for (var i = totalDone - 1; i < totalDone; i++) {
                        (prevButton.closest("form").querySelectorAll(".custom-nav .done")[i]) ? prevButton.closest("form").querySelectorAll(".custom-nav .done")[i].classList.remove('done'): '';
                    }
                    document.getElementById(prevTab).click();
                });
            });

        // Step number click
        var tabButtons = form.querySelectorAll('button[data-bs-toggle="pill"]');
        if (tabButtons)
            Array.from(tabButtons).forEach(function (button, i) {
                button.setAttribute("data-position", i);
                button.addEventListener("click", function () {
                    form.classList.remove('was-validated');

                    var getProgressBar = button.getAttribute("data-progressbar");
                    if (getProgressBar) {
                        var totalLength = document.getElementById("custom-progress-bar").querySelectorAll("li").length - 1;
                        var current = i;
                        var percent = (current / totalLength) * 100;
                        document.getElementById("custom-progress-bar").querySelector('.progress-bar').style.width = percent + "%";
                    }
                    (form.querySelectorAll(".custom-nav .done").length > 0) ?
                    Array.from(form.querySelectorAll(".custom-nav .done")).forEach(function (doneTab) {
                        doneTab.classList.remove('done');
                    }): '';
                    for (var j = 0; j <= i; j++) {
                        tabButtons[j].classList.contains('active') ? tabButtons[j].classList.remove('done') : tabButtons[j].classList.add('done');
                    }
                });
            });
    });

    $(document).ready(function () {
        $('.select2').select2();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const birthDateInput = document.getElementById('birth_date');
        const ageInput = document.getElementById('age_label');
        const ageGroupInput = document.getElementById('age_group');
        const calculatedAgeInput = document.getElementById('age');

        const today = new Date().toISOString().split('T')[0];
        birthDateInput.setAttribute('max', today); // prevent future dates

        birthDateInput.addEventListener('change', function () {
            const birthDate = new Date(this.value);
            const now = new Date();

             // Reset class first
            birthDateInput.classList.remove('is-invalid');

            if (!this.value || birthDate > now || isNaN(birthDate)) {
                birthDateInput.classList.add('is-invalid');
                birthDateInput.value = '';
                ageInput.value = '';
                ageGroupInput.value = '';
                calculatedAgeInput.value = '';
                return;
            }

            let age = now.getFullYear() - birthDate.getFullYear();
            const monthDiff = now.getMonth() - birthDate.getMonth();
            const dayDiff = now.getDate() - birthDate.getDate();

            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                age--;
            }

            // Show age in disabled field
            ageInput.value = age + ' years old';
            calculatedAgeInput.value = age;

            // Determine age group
            let group = '';
            if (age <= 18) group = '18 below';
            else if (age <= 30) group = '18-30';
            else if (age <= 45) group = '31-45';
            else if (age <= 59) group = '46-59';
            else group = '60 and above';

            ageGroupInput.value = group;
        });
    });
