<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;

class CreateCoaCustomerSupplier extends Controller
{
    public function index(){

        $suppliers = Supplier::all();

        foreach($suppliers as $supplier){

            $nomorterakhir = Coa::where('header_akun','210000')
                        ->orderBy('kode_akun', 'DESC')->get();
                
            if (count($nomorterakhir) == 0){
                $kodeakun = '210001';
            }else{
                $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                $kodeakun = '21'.substr('0000' . $noakhir, -4);
            }
        
            $coa = New Coa();
            $coa['kode_akun'] = $kodeakun;
            $coa['nama_akun'] = $supplier->nama_supplier;
            $coa['level'] = 5;
            $coa['tipe'] = 'Detail';
            $coa['posisi'] = 'Liability';
            $coa['header_akun'] = '210000';
            $coa->save();

            $supp = Supplier::find($supplier->id);
            $supp['coa_id'] = $coa->id;
            $supp->save();

        }

        $customers = Customer::all();

        foreach($customers as $customer){

            $nomorterakhir = Coa::where('header_akun','110000')
                        ->orderBy('kode_akun', 'DESC')->get();
                
            if (count($nomorterakhir) == 0){
                $kodeakun = '110001';
            }else{
                $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                $kodeakun = '11'.substr('0000' . $noakhir, -4);
            }
        
            $coa = New Coa();
            $coa['kode_akun'] = $kodeakun;
            $coa['nama_akun'] = $customer->nama_customer;
            $coa['level'] = 5;
            $coa['tipe'] = 'Detail';
            $coa['posisi'] = 'Asset';
            $coa['header_akun'] = '110000';
            $coa->save();

            $cust = Customer::find($customer->id);
            $cust['coa_id'] = $coa->id;
            $cust->save();

        }
    }
}
