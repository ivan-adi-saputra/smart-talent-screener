<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory;

class CvParsingService
{
    public function parse(UploadedFile $file): array
    {
        $extension = $file->getClientOriginalExtension();
        $path = $file->getRealPath();

        try {
            $text = match (strtolower($extension)) {
                'pdf' => $this->extractPdf($path),
                'doc', 'docx' => $this->extractDocx($path),
                default => throw new Exception("Unsupported file format: {$extension}"),
            };
        } catch (Exception $e) {
            // Fallback for MVP: use filename or empty string if parsing fails
            $text = "Extraction failed for " . $file->getClientOriginalName() . ". Error: " . $e->getMessage();
        }

        return array_merge(
            $this->extractBasicInfo($text),
            ['raw_text' => $text]
        );
    }

    protected function extractPdf(string $path): string
    {
        $parser = new PdfParser();
        $pdf = $parser->parseFile($path);
        return $pdf->getText();
    }

    protected function extractDocx(string $path): string
    {
        $phpWord = IOFactory::load($path);
        $text = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= $element->getText() . "\n";
                }
            }
        }
        return $text;
    }

    protected function extractBasicInfo(string $text): array
    {
        $data = [
            'name' => null,
            'email' => null,
            'phone' => null,
        ];

        // Email extraction
        if (preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/i', $text, $matches)) {
            $data['email'] = $matches[0];
        }

        // Phone extraction (basic)
        if (preg_match('/(\+?62|0)[0-9\- \(\)]{8,15}/', $text, $matches)) {
            $data['phone'] = trim($matches[0]);
        }

        // Name extraction (Naive: First line or based on common patterns)
        $lines = explode("\n", trim($text));
        if (isset($lines[0])) {
            $data['name'] = trim($lines[0]);
        }

        return $data;
    }
}
