<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    public function index(){

        $sql = "backup database bbmpalembang to disk='/var/www/bbmnew/backup/".date("Y-m-d").".bak'";

        DB::statement($sql);
        return $sql;
    }
}
