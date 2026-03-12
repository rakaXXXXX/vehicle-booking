<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $dateFrom;
    protected $dateTo;

    public function __construct($dateFrom = null, $dateTo = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function collection()
    {
        $query = Booking::with(['requester', 'vehicle', 'driver']);
        
        if ($this->dateFrom) {
            $query->whereDate('start_date', '>=', $this->dateFrom);
        }
        
        if ($this->dateTo) {
            $query->whereDate('end_date', '<=', $this->dateTo);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Start Date',
            'End Date',
            'Vehicle',
            'Requester',
            'Driver',
            'Purpose',
            'Status',
            'Created At',
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->start_date->format('d/m/Y'),
            $booking->end_date->format('d/m/Y'),
            $booking->vehicle->license_plate ?? 'N/A',
            $booking->requester->full_name ?? 'N/A',
            $booking->driver->full_name ?? 'Not Assigned',
            $booking->purpose ?? 'N/A',
            ucfirst(str_replace('_', ' ', $booking->status)),
            $booking->created_at->format('d/m/Y H:i'),
        ];
    }
}

