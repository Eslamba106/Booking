<?php

namespace App\Exports;

use App\Models\CustFile;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientFileReportExport implements FromArray
{
    protected $customerId;

    public function __construct($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
    * @return array
    */
    public function array(): array
    {
        $files = CustFile::with(['customer', 'cust_file_items'])
            ->where('customer_id', $this->customerId)
            ->get();

        $files->loadMorph('cust_file_items.related', [
            \App\Models\Booking::class => ['hotel', 'broker', 'booking_details', 'booking_unit.unit_type'],
            \App\Models\Car::class => ['category', 'tour.from', 'tour.to'],
        ]);

        // $data = [];

        // 1. رأس جدول الحجزات
        $data[] = [
            '--- HOTEL BOOKINGS ---'
        ];
        $data[] = [
            'File ID', 'Customer Name', 'File Name', 'Total', 'Paid', 'Balance', 'Currency', 'Created',
            'Booking ID', 'Agent', 'Hotel', 'Room Type', 'Check-in', 'Check-out', 'Nights', 'Rooms',
            'Room Cost', 'Total Cost', 'Selling Price', 'Total Price', 'Revenue', 'Commission Type', 'Commission'
        ];

        foreach ($files as $file) {
            foreach ($file->cust_file_items as $item) {
                if ($item->related_type === 'App\\Models\\Booking' && $item->related) {
                    $b = $item->related;

                    $nights = $b->arrival_date && $b->check_out_date
                        ? \Carbon\Carbon::parse($b->check_out_date)->diffInDays($b->arrival_date)
                        : 0;

                    $roomCost = $b->buy_price ?? 0;
                    $sellingPrice = $b->price ?? 0;
                    $totalCost = $roomCost * ($b->booking_details->units_count ?? 1) * ($b->days_count ?? 1);
                    $totalPrice = $sellingPrice * ($b->booking_details->units_count ?? 1) * ($b->days_count ?? 1);
                    $revenue = $totalPrice - $totalCost;

                    $commissionAmount = $b->commission_amount ?? 0;
                    if ($b->commission_type == 'percentage') {
                        $commissionAmount = $totalCost * ($b->commission_percentage / 100);
                    } elseif ($b->commission_type == 'night') {
                        $commissionAmount = $b->commission_night * ($b->days_count ?? 1) * ($b->booking_details->units_count ?? 1);
                    }

                    $data[] = [
                        $file->id,
                        $file->customer->name ?? '',
                        $file->name,
                        $file->total,
                        $file->paid,
                        $file->total - $file->paid,
                        $file->currency,
                        optional($file->created_at)->format('Y-m-d'),

                        $b->id,
                        $b->broker->name ?? 'N/A',
                        $b->hotel->name ?? 'N/A',
                        $b->booking_unit->unit_type->name ?? 'N/A',
                        $b->arrival_date,
                        $b->check_out_date,
                        $nights,
                        $b->booking_details->units_count ?? 0,
                        $roomCost,
                        $totalCost,
                        $sellingPrice,
                        $totalPrice,
                        $revenue,
                        $b->commission_type,
                        $commissionAmount,
                    ];
                }
            }
        }


        // 2. فاصل أو سطر فارغ

        $data[] = ['--- CAR RENTALS ---'];

        // 3. رأس جدول السيارات
        $data[] = [
            'File ID', 'Customer Name', 'File Name',
            'Car ID', 'Car Type', 'Pickup Date', 'Return Date', 'Pickup Time', 'Return Time',
            'From', 'To', 'Days', 'Daily Price', 'Total Amount', 'Status', 'Notes'
        ];

        foreach ($files as $file) {
            foreach ($file->cust_file_items as $item) {
                if ($item->related_type === 'App\\Models\\Car' && $item->related) {
                    $c = $item->related;

                    $data[] = [
                        $file->id,
                        $file->customer->name ?? '',
                        $file->name,


                        $c->id,
                        $c->category->category ?? 'N/A',
                        $c->arrival_date,
                        $c->leave_date,
                        $c->arrival_time,
                        $c->leave_time,
                        $c->from_location ?? 'N/A',
                        $c->to_location ?? 'N/A',
                        $c->days_count ?? 0,
                        $c->category->price_per_day ?? 0,
                        $c->total ?? 0,
                        $c->status ?? 'N/A',
                        $c->note ?? 'N/A',
                    ];
                }
            }
        }

        return $data;
    }


}
