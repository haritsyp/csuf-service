<?php
namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;


class ServiceExport implements FromQuery
{
	use Exportable;

    public function query()
    {
        return DB::select("SELECT * FROM ServiceS");
    }
}