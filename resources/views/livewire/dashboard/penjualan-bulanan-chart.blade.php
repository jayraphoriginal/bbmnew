<div class="w-full">
    <canvas class="bg-white w-full" id="penjualanChart" height="350px"></canvas>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <script type="text/javascript">
        var labels =  {{ Illuminate\Support\Js::from($labels) }};
        var valuepenjualan =  {{ Illuminate\Support\Js::from($valuepenjualan) }};
        const datapenjualan = {
            labels: labels,
            datasets: [{
                label: 'Penjualan Per Bulan (m3)',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: valuepenjualan,
            }]
        };
        const config = {
            type: 'line',
            data: datapenjualan,
            options: {}
        };
        const myChart = new Chart(
            document.getElementById('penjualanChart'),
            config
        );
    </script>
</div>
