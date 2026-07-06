<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExecuteLaporanPerhitunganHpp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'procedure:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laporan Perhitungan HPP';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $tgl_berlaku = now()->addDay()->format('Y-m-d');

        DB::beginTransaction();

        try {

            DB::statement('Set nocount on; EXEC SP_CreateHpp ?', [
                $tgl_berlaku
            ]);

            DB::statement('Set nocount on; EXEC SP_CreateHpp_Kendaraan ?', [
                $tgl_berlaku
            ]);

            Log::info('Perhitungan HPP berhasil dijalankan', [
                'tanggal' => $tgl_berlaku
            ]);

            DB::commit();

            $this->info('Stored procedure executed successfully.');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Perhitungan HPP gagal', [
                'error' => $e->getMessage()
            ]);

            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
