<div class="w-full mt-5">
    <canvas class="bg-white w-full" id="penjualanChart2" height="200px"></canvas>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <script type="text/javascript">
        var labels =  {{ Illuminate\Support\Js::from($labels) }};
        var valuepenjualan =  {{ Illuminate\Support\Js::from($valuepenjualan) }};
        const datapenjualan2 = {
            labels: labels,
            datasets: [{
                label: 'Penjualan Mutubeton (m3)',
                backgroundColor: ['rgb(0, 128, 0)',
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)',
                                'rgb(60, 106, 210)'],
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
