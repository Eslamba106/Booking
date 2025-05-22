<?php

namespace App\Http\Controllers;

use App\Exports\AccountingExport;
use App\Exports\BrokergExport;
use App\Exports\ComingSoonExport;
use App\Exports\ComissionExport;
use App\Exports\InvoicesExport;
use App\Exports\MonthlyHouse;
use App\Exports\PaymentExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function export()
{
    return Excel::download(new InvoicesExport, 'monthly.xlsx');
}
    public function MonthlyHouse()
{
    return Excel::download(new MonthlyHouse, 'monthly_house.xlsx');
}
    public function ComissionExport()
{
    return Excel::download(new ComissionExport, 'Comission.xlsx');
}
    public function AccountingExport()
{
    return Excel::download(new AccountingExport, 'Accounting.xlsx');
}
    public function BrokergExport()
{
    return Excel::download(new BrokergExport, 'broker.xlsx');
}
    public function ComingSoonExport()
{
    return Excel::download(new ComingSoonExport, 'comingsoon.xlsx');
}
    public function PaymentExport()
{
    return Excel::download(new PaymentExport, 'Payment.xlsx');
}

}
