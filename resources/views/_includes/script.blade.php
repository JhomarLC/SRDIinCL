<script>
    $(document).ready(function() {
        $('.select2').select2();

        function toggleMunicipality() {
            const provinceVal = $('#province').val();

            if (provinceVal === 'all' || provinceVal === '') {
                $('#municipality').prop('disabled', true).val('all').trigger('change.select2');
            } else {
                $('#municipality').prop('disabled', false).trigger('change.select2');
            }
        }

        // Trigger toggle on page load
        toggleMunicipality();

        // Update when province changes
        $('#province').on('change', function () {
            toggleMunicipality();
        });

    });

    const openrouterApiKey = "{{ $openrouterApiKey }}";
    /**
     * Generates a subtitle for any chart given labels, counts, and a target element ID.
     * @param {Array} labels - The labels (categories) for the data.
     * @param {Array} counts - The counts/values for each label.
     * @param {string} title - The title to prepend in the data summary.
     * @param {string} elementId - The ID of the DOM element where the subtitle will appear.
     */
    function generateChartSubtitle(labels, counts, title, elementId) {
        let dataSummary = `${title} - `;
        const parts = labels.map((label, index) => `${label}: ${counts[index]}`);
        dataSummary += parts.join(', ');

        const prompt = `
            You are a data analyst. Given the following chart data, write a concise summary in this style:
            "From this data, it can be observed that [key findings]. The distribution shows [overall trend or demographic insights]."

            Data:
            ${dataSummary}
        `;

        const requestData = {
            model: "mistralai/mistral-small-3.1-24b-instruct:free",
            messages: [
                {
                    role: "user",
                    content: prompt
                }
            ]
        };

        const subtitleElement = document.getElementById(elementId);
        if (subtitleElement) {
            subtitleElement.innerText = "Analyzing data...";
        }

        fetch('https://openrouter.ai/api/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${openrouterApiKey}`
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            const reply = data?.choices?.[0]?.message?.content?.trim();
            subtitleElement.innerText = reply || "Could not generate description.";
        })
        .catch(error => {
            console.error('Error:', error);
            subtitleElement.innerText = "Error generating description.";
        });
    }

    var genderLabels = {!! json_encode($genderDistribution->pluck('gender')) !!};
    var genderCounts = {!! json_encode($genderDistribution->pluck('total')) !!};
    // generateChartSubtitle(genderLabels, genderCounts, "Farmers by gender", "gender-subtitle");

    var chartPieBasicColors = getChartColorsArray("farmers_by_sex");

    if(chartPieBasicColors){
        var options = {
            series: genderCounts,
            chart: {
                height: 300,
                type: 'pie',
                toolbar: {
                    show: true, // 👈 show the toolbar
                    tools: {
                        download: true, // 👈 enable download
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                }
            },
            labels: genderLabels,
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                dropShadow: {
                    enabled: false,
                }
            },
            colors: chartPieBasicColors,
        };

        var chart = new ApexCharts(document.querySelector("#farmers_by_sex"), options);
        chart.render();
    }

    var ageGroupLabels = {!! json_encode(collect($ageGroupDistribution)->pluck('age_group')) !!};
    var ageGroupCounts = {!! json_encode(collect($ageGroupDistribution)->pluck('total')) !!};

    // Custom DataLabels Bar
    var chartDatalabelsBarColors = getChartColorsArray("custom_datalabels_bar");
    if(chartDatalabelsBarColors){
         // Precompute colors for each label (black for 0, white for others)
    var dataLabelColors = ageGroupCounts.map(function (val) {
        return val === 0 ? '#000' : '#fff';
    });
    var options = {
        series: [{
            data: ageGroupCounts
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: {
                show: true, // 👈 show the toolbar
                tools: {
                    download: true, // 👈 enable download
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false
                }
            }
        },
        plotOptions: {
            bar: {
                barHeight: '100%',
                distributed: true,
                horizontal: true,
                dataLabels: {
                    position: 'bottom'
                },
            }
        },
        colors: chartDatalabelsBarColors,
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: dataLabelColors
            },
            formatter: function (val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + ": " + val;
            },
            offsetX: 0,
            dropShadow: {
                enabled: false
            }
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        xaxis: {
            categories: ageGroupLabels,
        },
        yaxis: {
            labels: {
                show: false
            }
        },
        tooltip: {
            theme: 'dark',
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function () {
                        return ''
                    }
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#custom_datalabels_bar"), options);
    chart.render();
    }


    var civilStatusLabels = {!! json_encode($civilStatusDistribution->pluck('civil_status')) !!};
    var civilStatusCounts  = {!! json_encode($civilStatusDistribution->pluck('total')) !!};

    var civilStatusColors = getChartColorsArray("farmers_by_civil_status");

    if(civilStatusColors){
        var options = {
            series: civilStatusCounts,
            chart: {
                height: 300,
                type: 'pie',
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                }
            },
            labels: civilStatusLabels,
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                dropShadow: {
                    enabled: false
                }
            },
            colors: civilStatusColors,
        };

        var chart = new ApexCharts(document.querySelector("#farmers_by_civil_status"), options);
        chart.render();
    }


    var educationLabels = @json($educationLevelDistribution->pluck('education_level'));
    var educationCounts = @json($educationLevelDistribution->pluck('total'));

    var educationColors = getChartColorsArray("farmers_by_education");

    if(educationColors){
        var options = {
            series: educationCounts,
            chart: {
                height: 300,
                type: 'pie',
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                }
            },
            labels: educationLabels,
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                dropShadow: {
                    enabled: false
                }
            },
            colors: educationColors,
        };

        var chart = new ApexCharts(document.querySelector("#farmers_by_education"), options);
        chart.render();
    }

    var farmingLabels = @json(collect($farmingExperienceDistribution)->pluck('range'));
    var farmingCounts = @json(collect($farmingExperienceDistribution)->pluck('total'));

    var experienceColors = getChartColorsArray("farmers_by_experience");

    if (experienceColors) {
        var options = {
            series: farmingCounts,
            chart: {
                height: 300,
                type: 'pie',
                toolbar: {
                    show: true,
                    tools: {
                        download: true
                    }
                }
            },
            labels: farmingLabels,
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                dropShadow: {
                    enabled: false
                }
            },
            colors: experienceColors,
        };

        var chart = new ApexCharts(document.querySelector("#farmers_by_experience"), options);
        chart.render();
    }

    var ownershipLabels = @json(collect($farmOwnershipDistribution)->pluck('role'));
    var ownershipCounts = @json(collect($farmOwnershipDistribution)->pluck('total'));
    var ownershipPercentages = @json(collect($farmOwnershipDistribution)->pluck('percentage'));

    var ownershipColors = getChartColorsArray("farm_ownership_chart");

    if (ownershipColors) {
        var options = {
            series: ownershipCounts,
            chart: {
                height: 300,
                type: 'pie',
                toolbar: {
                    show: true,
                    tools: {
                        download: true
                    }
                }
            },
            labels: ownershipLabels,
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    return val.toFixed(2) + '%';
                }
            },
            colors: ownershipColors
        };

        var chart = new ApexCharts(document.querySelector("#farm_ownership_chart"), options);
        chart.render();
    }

    const philippinesBounds = L.latLngBounds(
        [4.5, 116.8],
        [21.5, 126.6]
    );
    const luzonBounds = L.latLngBounds(
        [11.5, 119.5],  // Southwest
        [19.0, 126.0]   // Northeast
    );

    const centralLuzonBounds = L.latLngBounds(
        [14.5, 119.5],  // Southwest
        [16.5, 122.5]   // Northeast
    );

    var map = L.map('provinceMap', {
        zoomControl: true,
        scrollWheelZoom: false,      // ❌ disable scroll zoom
        doubleClickZoom: false,
        dragging: true,
        boxZoom: false,
        maxBounds: philippinesBounds,
        maxBoundsViscosity: 1.0
    }).fitBounds(centralLuzonBounds);       // 🧭 initial zoom to Luzon

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png', {
        attribution: ''
    }).addTo(map);

    var provinceStats = @json($provinceData);

    console.log(provinceStats);

   // Normalize function to match names
    function normalize(name) {
        return name.toLowerCase().replace(/\s+/g, '').replace(/[^a-z]/g, '');
    }

    // Build province count lookup
    const provinceCounts = {};

    provinceStats.forEach(p => {
        provinceCounts[normalize(p.name)] = p.count;
    });

   function getColor(count) {
        return count > 20 ? '#00441b' :     // dark green
            count > 10 ? '#006d2c' :     // medium-dark green
            count > 5 ? '#238b45' :     // mid green
            count > 3  ? '#41ab5d' :     // light green
            count > 0   ? '#74c476' :     // very pale green
                            '#bae4b3';      // default grey for 0
    }

    fetch('/geojson/philippines-provinces.json')
        .then(res => res.json())
        .then(geojson => {
            L.geoJson(geojson, {
                style: function (feature) {
                    const name = feature.properties.NAME_1;
                    const key = normalize(name);
                    const count = provinceCounts[key] || 0;

                    if (count > 0) {
                        return {
                            fillColor: getColor(count),
                            weight: 1.5,
                            color: '#000',       // black border
                            opacity: 1,
                            fillOpacity: 0.8
                        };
                    } else {
                        return {
                            fillColor: 'transparent',
                            weight: 0,
                            color: 'transparent',
                            fillOpacity: 0
                        };
                    }
                },
                onEachFeature: function (feature, layer) {
                    const name = feature.properties.NAME_1;
                    const count = provinceCounts[name.toLowerCase()] || 0;
                    layer.bindPopup(`<strong>${name}</strong><br>Farmers: ${count}`);
                }
            }).addTo(map);
        });

    // 🧮 Load training data
    const trainingStats = @json($trainingProvinceData);
    const trainingCounts = {};
    trainingStats.forEach(p => {
        trainingCounts[normalize(p.name)] = p.count;
    });

    // 🗺️ Init Map
    const mapTrainings = L.map('trainingMap', {
        zoomControl: true,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        dragging: true,
        boxZoom: false,
        maxBounds: philippinesBounds,
        maxBoundsViscosity: 1.0
    });

    // 🗺️ Add tile layer
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png', {
        attribution: ''
    }).addTo(mapTrainings);

    // 🧭 Load and style GeoJSON
    fetch('/geojson/philippines-provinces.json')
        .then(res => res.json())
        .then(geojson => {
            L.geoJson(geojson, {
                style: function (feature) {
                    const name = feature.properties.NAME_1;
                    const key = normalize(name);
                    const count = trainingCounts[key] || 0;

                    return count > 0 ? {
                        fillColor: getColor(count),
                        weight: 1.5,
                        color: '#000',
                        opacity: 1,
                        fillOpacity: 0.8
                    } : {
                        fillColor: 'transparent',
                        weight: 0,
                        color: 'transparent',
                        fillOpacity: 0
                    };
                },
                onEachFeature: function (feature, layer) {
                    const name = feature.properties.NAME_1;
                    const count = trainingCounts[normalize(name)] || 0;
                    layer.bindPopup(`<strong>${name}</strong><br>Trainings: ${count}`);
                }
            }).addTo(mapTrainings);

            // Fix potential size bug if map is in hidden tab initially
            setTimeout(() => mapTrainings.invalidateSize(), 500);
        });

    $('a[data-bs-toggle="tab"][href="#training-evaluations"]').on('shown.bs.tab', function () {
        mapTrainings.invalidateSize();
        mapTrainings.fitBounds(centralLuzonBounds); // ⬅️ zoom to Central Luzon
    });
    var provinceLabelsChart = {!! json_encode(collect($provinceData)->pluck('name')) !!};
    var provinceCountsChart = {!! json_encode(collect($provinceData)->pluck('count')) !!};

    var chartProvinceBarColors = provinceCountsChart.map(getColor);

    if(chartProvinceBarColors){
        var dataLabelColors = provinceCountsChart.map(function (val) {
            return val === 0 ? '#000' : '#fff';
        });

        var chartColors = provinceCountsChart.map(getColor); // 🔁 map-based matching colors

        var options = {
            series: [{
                data: provinceCountsChart
            }],
            chart: {
                type: 'bar',
                height: 500,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: true,
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    }
                }
            },
            colors: chartColors, // ✅ use map-matched colors
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: dataLabelColors
                },
                formatter: function (val, opt) {
                    return opt.w.globals.labels[opt.dataPointIndex] + ": " + val;
                },
                offsetX: 0,
                dropShadow: {
                    enabled: false
                }
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: provinceLabelsChart
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            tooltip: {
                theme: 'dark',
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function () {
                            return ''
                        }
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#province_datalabels_bar"), options);
        chart.render();

    }

var topicLabels = {!! json_encode($topicScores->pluck('label')) !!};
var topicAverages = {!! json_encode($topicScores->pluck('average_score')->map(fn($v) => $v ?? 0)) !!};

var chartColors = getChartColorsArray("speaker_topic_scores");

if (chartColors) {
    var options = {
        series: [{
            name: "Average Score",
            data: topicAverages
        }],
        chart: {
            type: 'bar',
            height: 500,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false
                }
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                distributed: true,
                barHeight: '70%',
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ['#fff']
            }
        },
        xaxis: {
            categories: topicLabels,
            max: 5,
            title: {
                text: "Score (0 - 5)"
            }
        },
        yaxis: {
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        colors: chartColors,
        tooltip: {
            enabled: true
        },
        legend: {
            show: false
        }
    };

    var chart = new ApexCharts(document.querySelector("#speaker_topic_scores"), options);
    chart.render();
}


var topicLabels1 = {!! json_encode($topicScores->pluck('label')) !!};
var topicAverages1 = {!! json_encode($topicScores->pluck('average_score')->map(fn($v) => $v ?? 0)) !!};

var chartColors1 = getChartColorsArray("speaker_topic_scores_1");

if (chartColors1) {
    var options = {
        series: [{
            name: "Average Score",
            data: topicAverages
        }],
        chart: {
            type: 'bar',
            height: 500,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false
                }
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                distributed: true,
                barHeight: '70%',
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ['#fff']
            }
        },
        xaxis: {
            categories: topicLabels1,
            max: 5,
            title: {
                text: "Score (0 - 5)"
            }
        },
        yaxis: {
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        colors: chartColors1,
        tooltip: {
            enabled: true
        },
        legend: {
            show: false
        }
    };

    var chart = new ApexCharts(document.querySelector("#speaker_topic_scores_1"), options);
    chart.render();
}
    var topicLabels = {!! json_encode($topicQuestionAverages->pluck('topic')) !!};

    var seriesData = [
        {
            name: "Knowledge",
            data: {!! json_encode($topicQuestionAverages->pluck('scores.knowledge_score')->map(fn($v) => $v ?? 0)) !!}
        },
        {
            name: "Teaching Method",
            data: {!! json_encode($topicQuestionAverages->pluck('scores.teaching_method_score')->map(fn($v) => $v ?? 0)) !!}
        },
        {
            name: "Audio/Visual",
            data: {!! json_encode($topicQuestionAverages->pluck('scores.audiovisual_score')->map(fn($v) => $v ?? 0)) !!}
        },
        {
            name: "Clarity",
            data: {!! json_encode($topicQuestionAverages->pluck('scores.clarity_score')->map(fn($v) => $v ?? 0)) !!}
        },
        {
            name: "Q&A",
            data: {!! json_encode($topicQuestionAverages->pluck('scores.question_handling_score')->map(fn($v) => $v ?? 0)) !!}
        },
        {
            name: "Audience Connection",
            data: {!! json_encode($topicQuestionAverages->pluck('scores.audience_connection_score')->map(fn($v) => $v ?? 0)) !!}
        },
        {
            name: "Relevance",
            data: {!! json_encode($topicQuestionAverages->pluck('scores.content_relevance_score')->map(fn($v) => $v ?? 0)) !!}
        },
        {
            name: "Goal Achievement",
            data: {!! json_encode($topicQuestionAverages->pluck('scores.goal_achievement_score')->map(fn($v) => $v ?? 0)) !!}
        }
    ];

    var chartColors = getChartColorsArray("speaker_question_scores");

    if (chartColors) {
        var options = {
            series: seriesData,
            chart: {
                type: 'bar',
                height: topicLabels.length * 45 + 200,
                stacked: false,
                toolbar: {
                    show: true
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '70%',
                    distributed: false // 👈 Required for multi-series
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '11px',
                    colors: ['#fff']
                }
            },
            xaxis: {
                categories: topicLabels,
                max: 5,
                title: {
                    text: "Score (0 - 5)"
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center'
            },
            colors: chartColors, // 👈 This maps colors to each series
            tooltip: {
                shared: true,
                intersect: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#speaker_question_scores"), options);
        chart.render();
    }

    var goalLabels = {!! json_encode($goalAchievementChart->pluck('goal_achievement')) !!};
    var goalCounts = {!! json_encode($goalAchievementChart->pluck('total')) !!};
    var goalColors = getChartColorsArray("training_goal_achievement");

    if (goalColors) {
        var options = {
            series: goalCounts,
            chart: {
                type: 'pie',
                height: 300,
                toolbar: { show: true }
            },
            labels: goalLabels,
            legend: { position: 'bottom' },
            dataLabels: {
                enabled: true
            },
            colors: goalColors,
        };

        var chart = new ApexCharts(document.querySelector("#training_goal_achievement"), options);
        chart.render();
    }

    var qualityLabels = {!! json_encode($overallQualityChart->pluck('overall_quality')) !!};
    var qualityCounts = {!! json_encode($overallQualityChart->pluck('total')) !!};
    var qualityColors = getChartColorsArray("training_overall_quality");

    if (qualityColors) {
        var options = {
            series: qualityCounts,
            chart: {
                type: 'pie',
                height: 300,
                toolbar: { show: true }
            },
            labels: qualityLabels,
            legend: { position: 'bottom' },
            dataLabels: {
                enabled: true
            },
            colors: qualityColors,
        };

        var chart = new ApexCharts(document.querySelector("#training_overall_quality"), options);
        chart.render();
    }

    var eventLabels = {!! json_encode($trainingEventEvalStats->pluck('title')) !!};
    var avgContentScores = {!! json_encode($trainingEventEvalStats->pluck('avg_content_score')->map(fn($v) => $v ?? 0)) !!};
    var avgCourseScores = {!! json_encode($trainingEventEvalStats->pluck('avg_course_score')->map(fn($v) => $v ?? 0)) !!};

    var barColors = getChartColorsArray("training_scores_bar");

    if (barColors) {
        var options = {
            series: [
                { name: 'Content Score', data: avgContentScores },
                { name: 'Course Management Score', data: avgCourseScores }
            ],
            chart: {
                type: 'bar',
                height: 500,
                stacked: false,
                toolbar: { show: true }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '60%',
                }
            },
            colors: barColors,
            dataLabels: {
                enabled: true
            },
            xaxis: {
                categories: eventLabels,
                max: 5
            },
            legend: { position: 'top' }
        };

        var chart = new ApexCharts(document.querySelector("#training_scores_bar"), options);
        chart.render();
    }

    // --- Content Evaluation Chart ---
    var contentLabels = {!! json_encode(array_keys($contentQuestionAverages)) !!};
    var contentValues = {!! json_encode(array_values($contentQuestionAverages)) !!};
    var contentColors = getChartColorsArray("content_question_scores");

    if (contentColors) {
        var options = {
            series: [{
                name: "Average Score",
                data: contentValues
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: { show: true }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    distributed: true,
                    barHeight: '70%',
                }
            },
            xaxis: {
                categories: contentLabels,
                max: 5,
                title: { text: "Score (0-5)" }
            },
            colors: contentColors,
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#fff']
                }
            },
            legend: { show: false }
        };

        var chart = new ApexCharts(document.querySelector("#content_question_scores"), options);
        chart.render();
    }

    // --- Course Management Chart ---
    var courseLabels = {!! json_encode(array_keys($courseQuestionAverages)) !!};
    var courseValues = {!! json_encode(array_values($courseQuestionAverages)) !!};
    var courseColors = getChartColorsArray("course_question_scores");

    if (courseColors) {
        var options = {
            series: [{
                name: "Average Score",
                data: courseValues
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: { show: true }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    distributed: true,
                    barHeight: '70%',
                }
            },
            xaxis: {
                categories: courseLabels,
                max: 5,
                title: { text: "Score (0-5)" }
            },
            colors: courseColors,
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#fff']
                }
            },
            legend: { show: false }
        };

        var chart = new ApexCharts(document.querySelector("#course_question_scores"), options);
        chart.render();
    }

    var trainingLabels = {!! json_encode(collect($trainingProvinceData)->pluck('name')) !!};
    var trainingCounts1 = {!! json_encode(collect($trainingProvinceData)->pluck('count')) !!};
    var trainingColors = trainingCounts1.map(getColor);
    var trainingDataLabelColors = trainingCounts1.map(val => val === 0 ? '#000' : '#fff');

    var options = {
        series: [{ data: trainingCounts1 }],
        chart: {
            type: 'bar',
            height: 500,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false
                }
            }
        },
        plotOptions: {
            bar: {
                barHeight: '100%',
                distributed: true,
                horizontal: true,
                dataLabels: { position: 'bottom' }
            }
        },
        colors: trainingColors,
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: { colors: trainingDataLabelColors },
            formatter: function (val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + ": " + val;
            },
            offsetX: 0,
            dropShadow: {
                enabled: false
            }
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        xaxis: {
            categories: trainingLabels
        },
        yaxis: {
            labels: { show: false }
        },
        tooltip: {
            theme: 'dark',
            x: { show: false },
            y: {
                title: {
                    formatter: function () {
                        return '';
                    }
                }
            }
        }
    };


    var chart = new ApexCharts(document.querySelector("#training_datalabels_bar"), options);
    chart.render();

</script>
