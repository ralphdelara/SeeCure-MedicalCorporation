<?php

namespace App\Console\Commands;

use App\Models\Icd10Code;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use SimpleXMLElement;
use XMLReader;

#[Signature('icd10:import')]
#[Description('Imports icd-10 code from xml file then save it to database')]
class ImportIcd10Xml extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filePath = base_path('database/data/icd102019en.xml');
        $icdCategoryCodes = $this->categoryCodes();

        if (! file_exists($filePath)) {
            $this->error("File not found at: {$filePath}");

            return self::FAILURE;
        }

        $this->info("Starting ICD-10 import from: {$filePath}");

        $reader = new XMLReader;
        if (! $reader->open($filePath)) {
            $this->error('Failed to open XML file.');

            return self::FAILURE;
        }

        $records = [];
        $chunkSize = 500;
        $totalImported = 0;

        $this->output->progressStart();

        while ($reader->read()) {
            // Target only <Class> nodes
            if ($reader->nodeType === XMLReader::ELEMENT && $reader->name === 'Class') {
                $xml = new SimpleXMLElement($reader->readOuterXml());

                $code = (string) $xml['code'];
                $kind = (string) $xml['kind'];

                // Filter out chapters, blocks/ranges, and ensure only specific categories are imported
                if ($kind !== 'category' || str_contains($code, '-')) {
                    continue;
                }

                // Extract preferred label description
                $description = '';
                foreach ($xml->Rubric as $rubric) {
                    if ((string) $rubric['kind'] === 'preferred') {
                        $description = trim(strip_tags($rubric->Label->asXML()));
                        break;
                    }
                }

                if (! empty($code) && ! empty($description)) {
                    if (in_array($code, $icdCategoryCodes)) {
                        continue;
                    }

                    $records[] = [
                        'code'        => $code,
                        'description' => $description,
                    ];

                    if (count($records) >= $chunkSize) {
                        Icd10Code::fillAndInsert($records);
                        $totalImported += count($records);
                        $records = [];
                        $this->output->progressAdvance($chunkSize);
                    }
                }
            }
        }

        // Insert remaining batch
        if (! empty($records)) {
            Icd10Code::fillAndInsert($records);
            $totalImported += count($records);
            $this->output->progressAdvance(count($records));
        }

        $reader->close();
        $this->output->progressFinish();

        // Remove category codes
        Icd10Code::whereIn('code', [1, 2, 3])->delete();

        $this->info("Import completed successfully! Total imported: {$totalImported} specific ICD-10 codes.");

        return self::SUCCESS;
    }

    public function categoryCodes(): array
    {
        // Array to store all generated ICD-10 category codes
        $icd10Categories = [];

        // Standard ICD-10 chapters use letters from A to Z
        $letters = range('A', 'Z');

        foreach ($letters as $letter) {
            // Loop through numbers 00 to 99 for each letter prefix
            for ($i = 0; $i <= 99; $i++) {
                // Pads single digits with a leading zero (e.g., 5 becomes '05')
                $number = str_pad((string) $i, 2, '0', STR_PAD_LEFT);

                // Combine the letter and formatted number (e.g., 'A00', 'M32')
                $code = $letter.$number;

                // Push the formatted string into the final array
                $icd10Categories[] = $code;
            }
        }

        return $icd10Categories;
    }
}
