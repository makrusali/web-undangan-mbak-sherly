<?php

namespace App\Excel;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class GuestsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors, Importable;

    protected $skipDuplicates;
    protected $updateExisting;
    protected $stats = [
        'created' => 0,
        'updated' => 0,
        'skipped' => 0,
    ];

    public function __construct($skipDuplicates = false, $updateExisting = false)
    {
        $this->skipDuplicates = $skipDuplicates;
        $this->updateExisting = $updateExisting;
    }

    public function model(array $row)
    {
        $phone = $this->formatPhoneNumber($row['phone'] ?? '');

        $existingGuest = Guest::where('phone', $phone)->first();

        if ($existingGuest) {
            if ($this->updateExisting) {
                $existingGuest->update([
                    'name' => $row['name'] ?? $existingGuest->name,
                    'address' => $row['address'] ?? $existingGuest->address,
                ]);
                $this->stats['updated']++;
                return null;
            } elseif ($this->skipDuplicates) {
                $this->stats['skipped']++;
                return null;
            }
        }

        $this->stats['created']++;

        $guest = new Guest([
            'name' => $row['name'] ?? null,
            'phone' => $phone,
            'address' => $row['address'] ?? null,
        ]);

        $guest->save();

        $guest;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ];
    }

    protected function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        if (substr($phone, 0, 1) !== '+') {
            $phone = '+' . $phone;
        }

        return $phone;
    }

    public function getStats()
    {
        return $this->stats;
    }
}
