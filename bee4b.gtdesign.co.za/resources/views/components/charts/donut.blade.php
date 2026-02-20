@props([
    'id' => 'donutChart',
    'title' => '',
    'allChartData' => [],
])

<div
    x-init='
        () => {
            const data = {
                labels: @json($allChartData["labels"]),
                datasets: [{
                    label: "My First Dataset",
                    data: @json($allChartData["data"]),
                    backgroundColor: @json($allChartData["colours"]),
                    hoverOffset: 4
                }]
            };

            const config = {
                type: "doughnut",
                data: data,
                options: {
                    onClick: (e, items) => {
                        let datasetIndex = items[0].datasetIndex;
                        let dataIndex = items[0].index;
                        let datasetLabel = e.chart.data.datasets[datasetIndex].label;
                        let value = e.chart.data.datasets[datasetIndex].data[dataIndex];
                        let label = e.chart.data.labels[dataIndex];
                        console.log("In click", datasetLabel, label, value);
                    },
                    {{-- responsive: false, --}}
                    {{-- maintainAspectRatio: false, --}}
                    layout: {
                        autoPadding: false,
                    },
                    plugins: {
                        legend: {
                            position: "right",
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => context.label.slice(1) + ": " + context.parsed,
                            },
                        },
                    },
                },
            };

            const myChart = new Chart(
                document.getElementById("{{ $id }}"),
                config
            );

            {{-- const centerConfig = myChart.config.options.elements.center;
            con --}}

            {{-- myChart.canvas.parentNode.style.height = "300px";
            myChart.canvas.parentNode.style.width = "300px"; --}}
        }
    '
    >
    <canvas id="{{ $id }}"></canvas>
</div>