<?php $attributes = $attributes->exceptProps([
    'id' => 'donutChart',
    'title' => '',
    'allChartData' => [],
]); ?>
<?php foreach (array_filter(([
    'id' => 'donutChart',
    'title' => '',
    'allChartData' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div
    x-init='
        () => {
            const data = {
                labels: <?php echo json_encode($allChartData["labels"], 15, 512) ?>,
                datasets: [{
                    label: "My First Dataset",
                    data: <?php echo json_encode($allChartData["data"], 15, 512) ?>,
                    backgroundColor: <?php echo json_encode($allChartData["colours"], 15, 512) ?>,
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
                document.getElementById("<?php echo e($id); ?>"),
                config
            );

            

            
        }
    '
    >
    <canvas id="<?php echo e($id); ?>"></canvas>
</div><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/charts/donut.blade.php ENDPATH**/ ?>