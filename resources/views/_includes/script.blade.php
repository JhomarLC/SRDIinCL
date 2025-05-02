<script>

    var genderLabels = {!! json_encode($genderDistribution->pluck('gender')) !!};
    var genderCounts = {!! json_encode($genderDistribution->pluck('total')) !!};

    function generateGenderSubtitle() {
        const apiKey = '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'; // Replace with your actual key

        let genderData = "Farmers by gender - ";
        const genderParts = genderLabels.map((label, index) => {
            return `${label}: ${genderCounts[index]}`;
        });
        genderData += genderParts.join(', ');

        const prompt = `
            You are a data analyst. Given the following chart data, write a concise summary in this style:
            "From this data, it can be observed that [key findings]. The distribution shows [overall trend or demographic insights]."

            Data:
            ${genderData}
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

        // Optional: set a different subtitle element for gender if needed
        document.getElementById('gender-subtitle').innerText = "Analyzing data...";

        fetch('https://openrouter.ai/api/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${apiKey}`
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            const subtitleElement = document.getElementById('gender-subtitle');
            const reply = data?.choices?.[0]?.message?.content?.trim();
            if (reply) {
                subtitleElement.innerText = reply;
            } else {
                subtitleElement.innerText = "Could not generate description.";
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('gender-subtitle').innerText = "Error generating description.";
        });
    }

    generateGenderSubtitle();

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
    function generateSubtitle() {
        const apiKey = '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'; // Replace with your actual key

         // Combine labels and counts into the same format as the static example:
        let ageData = "Farmers by age group - ";
        const ageParts = ageGroupLabels.map((label, index) => {
            return `${label}: ${ageGroupCounts[index]}`;
        });
        ageData += ageParts.join(', ');

        const prompt = `
            You are a data analyst. Given the following chart data, write a concise summary in this style:
            "From this data, it can be observed that [key findings]. The distribution shows [overall trend or demographic insights]."

            Data:
            ${ageData}
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

        fetch('https://openrouter.ai/api/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${apiKey}`
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            const subtitleElement = document.getElementById('subtitle');
            const reply = data?.choices?.[0]?.message?.content;
            if (reply) {
                subtitleElement.innerText = reply;
            } else {
                subtitleElement.innerText = "Could not generate description.";
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('subtitle').innerText = "Error generating description.";
        });
    }

    generateSubtitle();


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
