<div class="w-full mx-auto my-6 flex flex-col md:flex-row">
        <div class="px-3 lg:w-2/12">
        </div>
        <div class="lg:w-6/12">
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4 w-full">
                <x-card title="Total Penjualan" value="{{ number_format($totalpenjualan,0,'.',',') }}" link="/laporanpenjualanbetoncustomer/{{$tgl_awal}}/{{$tgl_akhir}}">
                    <svg class="h-8 w-8 text-green-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>                      
                </x-card>
                <x-card title="Total Kubikasi" value="{{ number_format($totalkubikasi,2,'.',',') }}" link="/laporanpenjualanbeton/{{$tgl_awal}}/{{$tgl_akhir}}">
                    <svg class="h-8 w-8 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />  <polyline points="7.5 4.21 12 6.81 16.5 4.21" />  <polyline points="7.5 19.79 7.5 14.6 3 12" />  <polyline points="21 12 16.5 14.6 16.5 19.79" />  <polyline points="3.27 6.96 12 12.01 20.73 6.96" />  <line x1="12" y1="22.08" x2="12" y2="12" /></svg>                   
                </x-card>
                <x-card title="Total Ticket" value="{{ number_format($totalticket,2,'.',',') }}" link="/laporanpenjualanbeton/{{$tgl_awal}}/{{$tgl_akhir}}">
                    <svg class="h-8 w-8 text-blue-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="1" y="3" width="15" height="13" />  <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />  <circle cx="5.5" cy="18.5" r="2.5" />  <circle cx="18.5" cy="18.5" r="2.5" /></svg>    
                </x-card>
                <x-card title="Sisa SO Belum Diproses" value="{{ number_format($sisaso,2,'.',',').' M3'.' ('.$jumlahso.' SO)' }}" link="#">
                    <svg class="h-8 w-8 text-yellow-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="18" cy="18" r="3" />  <circle cx="6" cy="6" r="3" />  <path d="M13 6h3a2 2 0 0 1 2 2v7" />  <line x1="6" y1="9" x2="6" y2="21" /></svg>
                </x-card>
            </div>
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4 w-full">
                <x-card title="Pengiriman hari ini" value="{{ number_format($totalpengiriman,2,'.',',') }} M3" link="/laporanpengirimanbeton/{{$tgl_akhir}}/{{$tgl_akhir}}">
                    <svg class="h-8 w-8 text-blue-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="1" y="3" width="15" height="13" />  <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />  <circle cx="5.5" cy="18.5" r="2.5" />  <circle cx="18.5" cy="18.5" r="2.5" /></svg>    
                </x-card>
                <x-card title="Ticket hari ini" value="{{ number_format($ticketpengiriman,0,'.',',') }}" link="/laporanpengirimanbeton/{{$tgl_akhir}}/{{$tgl_akhir}}">
                    <svg class="h-8 w-8 text-yellow-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="18" cy="18" r="3" />  <circle cx="6" cy="6" r="3" />  <path d="M13 6h3a2 2 0 0 1 2 2v7" />  <line x1="6" y1="9" x2="6" y2="21" /></svg>
                </x-card>
            </div>
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4 w-full">
                <x-card title="SIU Jatuh Tempo" value="{{ number_format($siu,0,'.',',') }}" link="laporanjtkendaraan/siu">
                    <svg class="h-8 w-8 text-brown-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="5" cy="17" r="2" />  <circle cx="17" cy="17" r="2" />  <path d="M7 18h8m4 0h2v-6a5 5 0 0 0 -5 -5h-1l1.5 5h4.5" />  <path d="M12 18v-11h3" />  <polyline points="3 17 3 12 12 12" />  <line x1="3" y1="9" x2="21" y2="3" />  <line x1="6" y1="12" x2="6" y2="8" /></svg>                     
                </x-card>
                <x-card title="KIR Jatuh Tempo" value="{{ number_format($kir,0,'.',',') }}" link="laporanjtkendaraan/kir">
                    <svg class="h-8 w-8 text-yellow-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="5" cy="17" r="2" />  <circle cx="17" cy="17" r="2" />  <path d="M7 18h8m4 0h2v-6a5 5 0 0 0 -5 -5h-1l1.5 5h4.5" />  <path d="M12 18v-11h3" />  <polyline points="3 17 3 12 12 12" />  <line x1="3" y1="9" x2="21" y2="3" />  <line x1="6" y1="12" x2="6" y2="8" /></svg>
                </x-card>
                <x-card title="STNK Jatuh Tempo" value="{{ number_format($stnk,0,'.',',') }}" link="laporanjtkendaraan/stnk">
                    <svg class="h-8 w-8 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="5" cy="17" r="2" />  <circle cx="17" cy="17" r="2" />  <path d="M7 18h8m4 0h2v-6a5 5 0 0 0 -5 -5h-1l1.5 5h4.5" />  <path d="M12 18v-11h3" />  <polyline points="3 17 3 12 12 12" />  <line x1="3" y1="9" x2="21" y2="3" />  <line x1="6" y1="12" x2="6" y2="8" /></svg>
                </x-card>
                <x-card title="Stok Minimum Material" value="{{ number_format($stokmaterial,0,'.',',') }}" link="stokmaterial">
                    <svg class="h-8 w-8 text-purple-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="3" />  <line x1="12" y1="5" x2="12" y2="5.01" />  <line x1="17" y1="7" x2="17" y2="7.01" />  <line x1="19" y1="12" x2="19" y2="12.01" />  <line x1="17" y1="17" x2="17" y2="17.01" />  <line x1="12" y1="19" x2="12" y2="19.01" />  <line x1="7" y1="17" x2="7" y2="17.01" />  <line x1="5" y1="12" x2="5" y2="12.01" />  <line x1="7" y1="7" x2="7" y2="7.01" /></svg>
                </x-card>
            </div>
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4 w-full">
                <x-card title="Hutang" value="{{ number_format($hutang,0,'.',',') }}" link="laporanhutangall/2023-01-01/{{date('Y-m-d')}}">
                    <svg class="h-8 w-8 text-red-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </x-card>
                <x-card title="Piutang" value="{{ number_format($piutang,0,'.',',') }}" link="laporanpiutangall/2023-01-01/{{date('Y-m-d')}}">
                    <svg class="h-8 w-8 text-yellow-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg></x-card>
                <x-card title="Warkat Masuk Belum Cair" value="{{ number_format($warkatmasuk,0,'.',',') }}" link="laporanwarkatmasuk/2023-01-01/{{date('Y-m-d')}}">
                    <svg class="h-8 w-8 text-blue-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M4 10v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1 -1v-3" /></svg>
                </x-card>
                <x-card title="Warkat Keluar Belum Cair" value="{{ number_format($warkatkeluar,0,'.',',') }}" link="laporanwarkatkeluar/2023-01-01/{{date('Y-m-d')}}">
                    <svg class="h-8 w-8 text-green-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M4 10v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1 -1v-3" /></svg>
                </x-card>
            </div>
        </div>
        <div class="lg:w-4/12 px-5">
            <livewire:dashboard.penjualan-bulanan-chart/>
            <livewire:dashboard.penjualan-mutubeton-chart/>
        </div>
        
</div>