<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <x-card title="Total Penjualan" value="{{ number_format($totalpenjualan,2,'.',',') }}" link="#">
                <svg class="h-8 w-8 text-green-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>                      
            </x-card>
            <x-card title="Total Kubikasi" value="{{ number_format($totalkubikasi,2,'.',',') }}" link="#">
                <svg class="h-8 w-8 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />  <polyline points="7.5 4.21 12 6.81 16.5 4.21" />  <polyline points="7.5 19.79 7.5 14.6 3 12" />  <polyline points="21 12 16.5 14.6 16.5 19.79" />  <polyline points="3.27 6.96 12 12.01 20.73 6.96" />  <line x1="12" y1="22.08" x2="12" y2="12" /></svg>                   
            </x-card>
            <x-card title="Total Ticket" value="{{ number_format($totalticket,2,'.',',') }}" link="#">
                <svg class="h-8 w-8 text-blue-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="1" y="3" width="15" height="13" />  <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />  <circle cx="5.5" cy="18.5" r="2.5" />  <circle cx="18.5" cy="18.5" r="2.5" /></svg>    
            </x-card>
            <x-card title="Sisa SO Belum Diproses" value="{{ number_format($sisaso,2,'.',',').' M3'.' ('.$jumlahso.' SO)' }}" link="#">
                <svg class="h-8 w-8 text-yellow-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="18" cy="18" r="3" />  <circle cx="6" cy="6" r="3" />  <path d="M13 6h3a2 2 0 0 1 2 2v7" />  <line x1="6" y1="9" x2="6" y2="21" /></svg>
            </x-card>
        </div>
    </h2>
</div>