<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $vehicleId;

    public function __construct($startDate, $endDate, $vehicleId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->vehicleId = $vehicleId;
    }

    public function collection()
    {
        $query = Booking::with(['vehicle', 'driver', 'requester', 'approverLevel1', 'approverLevel2'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);

        if ($this->vehicleId) {
            $query->where('vehicle_id', $this->vehicleId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No. Booking',
            'Tanggal Booking',
            'Kendaraan',
            'Driver',
            'Pemesan',
            'Tujuan',
            'Waktu Mulai',
            'Waktu Selesai',
            'Status',
            'Disetujui Level 1',
            'Disetujui Level 2',
            'BBM Digunakan',
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->booking_number,
            $booking->created_at->format('d/m/Y H:i'),
            $booking->vehicle->license_plate . ' - ' . $booking->vehicle->brand,
            $booking->driver->full_name,
            $booking->requester->full_name,
            $booking->purpose,
            $booking->start_date->format('d/m/Y H:i'),
            $booking->end_date->format('d/m/Y H:i'),
            $this->getStatusLabel($booking->status),
            $booking->approvalHistory()->where('approval_level', 1)->first()?->status ?? '-',
            $booking->approvalHistory()->where('approval_level', 2)->first()?->status ?? '-',
            $booking->fuel_used ? $booking->fuel_used . ' L' : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Pending',
            'approved_level_1' => 'Disetujui Level 1',
            'approved_level_2' => 'Disetujui Level 2',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'in_progress' => 'Dalam Perjalanan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        return $labels[$status] ?? $status;
    }
}