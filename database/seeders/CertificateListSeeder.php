<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certificate_list;

class CertificateListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Example data to seed
        $certificates = [
            [
                'certificate_list_id' => 1,
                'certificate_type' => 'Barangay Clearance',
                'certificate_name' => 'Clearance Certificate',
                'content_1' => 'Issued to the person for identification purposes.',
                'content_2' => 'Valid for local transactions.',
                'content_3' => 'Expires after 1 year.',
                'price' => 50,
            ],
            [
                'certificate_list_id' => 2,
                'certificate_type' => 'Indigency Certificate',
                'certificate_name' => 'Certificate of Indigency',
                'content_1' => 'Issued for low-income verification.',
                'content_2' => 'Required for assistance programs.',
                'content_3' => 'Valid for 6 months.',
                'price' => 0,
            ],
            [
                'certificate_list_id' => 3,
                'certificate_type' => 'Business Clearance',
                'certificate_name' => 'Business Clearance Certificate',
                'content_1' => 'Required for business operations.',
                'content_2' => 'Must be renewed annually.',
                'content_3' => 'Issued by Barangay Secretary.',
                'price' => 100,
            ],
        ];

        // Insert data into the database
        foreach ($certificates as $certificate) {
            Certificate_list::create($certificate);
        }
    }
}
