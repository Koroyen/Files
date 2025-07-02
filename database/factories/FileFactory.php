<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition(): array
    {
        $types = [
            '2023 Procurement', '2024 Procurement', 'Access Pass', 'Accounts Payable', 'Admin Internal Doc',
            'AOM COA', 'BP 202 Form', 'BTR Certification', 'Change Order', 'CIC', 'CIDOS', 'CIIMD', 'CMT Docs',
            'COC-FAC', 'Contract Renewal', 'Contract Termination', 'Contract Termination 2022', 'CSR',
            'CTC DOCUMENTS', 'Discontinuance 2023', 'Download of Funds to ROs', 'DV / FUND TRANSFER',
            'DV / ORS / FUND TRANSFER', 'DV / ORS / SARO', 'End of Sevice', 'Endorsement', 'Endorsement/Request letter',
            'FAC-COC', 'FACC', 'FUND TRANSFER', 'LED', 'Letter', 'Letter Request', 'Liquidated Damages', 'MEMO',
            'MEMO / ORS / DV', 'Memo and Letter', 'Memo Endorsement', 'Mintues of the Meeting', 'MIS 2019 / FUND TRANSFER',
            'MOA', 'MOM', 'ORS / DV', 'Payment', 'PCV', 'Perfomance Bond', 'PITC', 'PO/Contract & ORS', 'Policy', 'PR',
            'Regional Concern', 'Reply letter', 'Salary', 'Site Replacement', 'SOA Service Reports',
            'Termination by Convenience', 'UNDP'
        ];

        return [
            'type' => $this->faker->randomElement($types),
            'document_number' => strtoupper(Str::random(8)),
            'title' => $this->faker->sentence(3),
            'remarks' => $this->faker->sentence(6),
            'file_path' => 'uploads/' . $this->faker->uuid . '.pdf',
            'updated_by' => null,
            'is_deleted' => false,
        ];
    }
}