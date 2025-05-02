<script>
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
    generateChartSubtitle(genderLabels, genderCounts, "Farmers by gender", "gender-subtitle");


    // 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
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
    generateChartSubtitle(ageGroupLabels, ageGroupCounts, "Farmers by age group", "subtitle");

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


    var map = L.map('map').setView([12.8797, 121.7740], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var regionData = {
        "Ilocos Region": 5000000,
        "Cagayan Valley": 3500000,
        "Central Luzon": 12000000
        // Continue for all regions
    };

    function getColor(d) {
        return d > 10000000 ? '#800026' :
            d > 7000000  ? '#BD0026' :
            d > 5000000  ? '#E31A1C' :
            d > 3000000  ? '#FC4E2A' :
            d > 1000000  ? '#FD8D3C' :
                            '#FEB24C';
    }

    function style(feature) {
        var value = regionData[feature.properties.NAME_1] || 0;  // Adjust property key if needed
        return {
            fillColor: getColor(value),
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7
        };
    }

    function onEachFeature(feature, layer) {
        var value = regionData[feature.properties.NAME_1] || "No data";
        layer.bindPopup(feature.properties.NAME_1 + "<br>Value: " + value);
    }

    var geojsonLayer = new L.GeoJSON.AJAX("ph_regions.geojson", {
        style: style,
        onEachFeature: onEachFeature
    }).addTo(map);


</script>
