<?php

namespace App\Services\Spatial;

use App\Models\Dataset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class XmlMetadataParserService
{
    /**
     * Parse ISO 19115 / FGDC XML Metadata file and update dataset metadata
     */
    public function importXmlMetadata(Dataset $dataset, string $xmlContent): array
    {
        try {
            // Disable libxml errors & load XML
            libxml_use_internal_errors(true);
            $xml = new SimpleXMLElement($xmlContent);

            if ($xml === false) {
                throw new \Exception("Format XML Metadata tidak valid atau mengalami kesalahan sintaks.");
            }

            // Register common geospatial metadata namespaces (ISO 19115 / ISO 19139 / FGDC)
            $namespaces = $xml->getDocNamespaces(true);
            foreach ($namespaces as $prefix => $ns) {
                if (!empty($prefix)) {
                    $xml->registerXPathNamespace($prefix, $ns);
                }
            }

            // Extract Metadata attributes
            $title = $this->xpathQueryText($xml, ['//gmd:title/gco:CharacterString', '//title', '//citation/title']) ?? $dataset->title;
            $abstract = $this->xpathQueryText($xml, ['//gmd:abstract/gco:CharacterString', '//abstract', '//descript/abstract']) ?? $dataset->description;
            $purpose = $this->xpathQueryText($xml, ['//gmd:purpose/gco:CharacterString', '//purpose', '//descript/purpose']) ?? 'Tujuan penggunaan data spasial';
            $lineage = $this->xpathQueryText($xml, ['//gmd:statement/gco:CharacterString', '//lineage', '//dataqual/lineage/procstep/procdesc']) ?? 'Riwayat pengolahan data geospasial';
            $contact = $this->xpathQueryText($xml, ['//gmd:organisationName/gco:CharacterString', '//cntorg', '//cntper']) ?? ($dataset->agency?->name ?? 'Dinas Aceh');

            // Extract Bounding Box
            $west = $this->xpathQueryText($xml, ['//gmd:westBoundLongitude/gco:Decimal', '//westbc']) ?? '95.00';
            $east = $this->xpathQueryText($xml, ['//gmd:eastBoundLongitude/gco:Decimal', '//eastbc']) ?? '98.50';
            $south = $this->xpathQueryText($xml, ['//gmd:southBoundLatitude/gco:Decimal', '//southbc']) ?? '2.00';
            $north = $this->xpathQueryText($xml, ['//gmd:northBoundLatitude/gco:Decimal', '//northbc']) ?? '6.00';

            $boundingBoxText = "BBOX: West=$west, East=$east, South=$south, North=$north (EPSG:4326)";

            // Update Dataset Metadata table
            DB::table('dataset_metadata')->updateOrInsert(
                ['dataset_id' => $dataset->id],
                [
                    'abstract' => $abstract,
                    'purpose' => $purpose,
                    'lineage' => $lineage,
                    'spatial_representation_type' => 'vector',
                    'reference_system' => 'EPSG:4326 (WGS 84)',
                    'scale_denominator' => 25000,
                    'bounding_box' => $boundingBoxText,
                    'contact_point' => $contact,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            return [
                'success' => true,
                'message' => 'Metadata XML (ISO 19115 / FGDC) berhasil diurai dan disimpan ke dalam basis data.',
                'title' => $title,
                'bounding_box' => $boundingBoxText,
            ];

        } catch (\Exception $e) {
            Log::error('XML Metadata import failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gagal membaca Metadata XML: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Helper to query XPath with fallback tags
     */
    protected function xpathQueryText(SimpleXMLElement $xml, array $queries): ?string
    {
        foreach ($queries as $query) {
            $nodes = $xml->xpath($query);
            if (!empty($nodes)) {
                $text = trim((string) $nodes[0]);
                if (!empty($text)) {
                    return $text;
                }
            }
        }
        return null;
    }
}
