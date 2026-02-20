@props([
    'id' => 'barChart',
    'title' => '',
    'data' => [],
    'groups' => [],
    'xLabel' => '',
    'yLabel' => ''
])

<div
    x-init='
        () => {
            var chart = bb.generate({
                title: {
                    text: "{{ $title }}"
                },
                data: {
                    x: "x",
                    columns: @json($data),
                    type: "bar", 
                    groups: [
                        @json($groups)
                    ], 
                },
                axis: {
                    x: {
                        label: {
                            text: "{{ $xLabel }}",
                            position: "outer-end"
                        },
                        type: "category",
                        tick: {
                            rotate: 90,
                            multiline: false,
                            tooltip: true
                        },
                        height: 130
                    },
                    y: {
                        label: {
                            text: "{{ $yLabel }}",
                            position: "outer-center"
                        },
                    }
                },
                bindto: "#{{ $id }}"
            });
        }
    '
    >    

    <div id="{{ $id }}"></div>    
</div>