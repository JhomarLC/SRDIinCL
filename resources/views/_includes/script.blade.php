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

    function getGreenShade(percent) {
        // percent: 0 to 1
        if (percent > 0.9) return '#00441b';     // darkest green
        if (percent > 0.75) return '#006d2c';
        if (percent > 0.5) return '#238b45';
        if (percent > 0.25) return '#41ab5d';
        if (percent > 0.1) return '#74c476';
        if (percent > 0) return '#a1d99b';
        return '#e5f5e0';                        // very light green / no data
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
        return count > 500 ? '#084081' :
               count > 200 ? '#0868ac' :
               count > 100 ? '#2b8cbe' :
               count > 50  ? '#4eb3d3' :
               count > 1  ? '#7bccc4' :
               count > 0   ? '#bae4bc' :
                             '#f0f0f0';
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



    // var map = L.map('map').setView([12.8797, 121.7740], 6);

    // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // var regionData = {
    //     "Ilocos Region": 5000000,
    //     "Cagayan Valley": 3500000,
    //     "Central Luzon": 12000000
    //     // Continue for all regions
    // };

    // function getColor(d) {
    //     return d > 10000000 ? '#800026' :
    //         d > 7000000  ? '#BD0026' :
    //         d > 5000000  ? '#E31A1C' :
    //         d > 3000000  ? '#FC4E2A' :
    //         d > 1000000  ? '#FD8D3C' :
    //                         '#FEB24C';
    // }

    // function style(feature) {
    //     var value = regionData[feature.properties.NAME_1] || 0;  // Adjust property key if needed
    //     return {
    //         fillColor: getColor(value),
    //         weight: 2,
    //         opacity: 1,
    //         color: 'white',
    //         dashArray: '3',
    //         fillOpacity: 0.7
    //     };
    // }

    // function onEachFeature(feature, layer) {
    //     var value = regionData[feature.properties.NAME_1] || "No data";
    //     layer.bindPopup(feature.properties.NAME_1 + "<br>Value: " + value);
    // }

    // var geojsonLayer = new L.GeoJSON.AJAX("ph_regions.geojson", {
    //     style: style,
    //     onEachFeature: onEachFeature
    // }).addTo(map);


</script>
