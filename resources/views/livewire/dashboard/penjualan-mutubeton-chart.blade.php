<div class="w-full mt-5">
    <canvas class="bg-white w-full" id="penjualanChart2" height="100px"></canvas>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <script type="text/javascript">
        var labels =  {{ Illuminate\Support\Js::from($labels) }};
        var valuepenjualan =  {{ Illuminate\Support\Js::from($valuepenjualan) }};
        const datapenjualan2 = {
            labels: labels,
            datasets: [{
                label: 'Penjualan Mutubeton (m3)',
                backgroundColor: ['rgb(100, 116, 139)',
                                'rgb(120,113, 108)',
                                'rgb(239, 68, 68)',
                                'rgb(234, 179, 8)',
                                'rgb(132, 204, 22)',
                                'rgb(16, 185, 129)',
                                'rgb(14, 165, 233)',
                                'rgb(99, 102, 241)',
                                'rgb(217, 70, 239)',
                                'rgb(236, 72, 153)',
                                'rgb(244, 63, 94)'],
                                
                borderColor: 'rgb(220, 220, 220)',
                data: valuepenjualan,
            }]
        };
        const configs = {
            type: 'doughnut',
            data: datapenjualan2,
            options: {}
        };
        const myCharts = new Chart(
            document.getElementById('penjualanChart2'),
            configs
        );
    </script>
</div>
