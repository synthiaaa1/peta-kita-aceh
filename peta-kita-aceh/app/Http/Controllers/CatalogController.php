<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dataset;
use App\Models\Agency;
use App\Models\Category;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Dataset::with(['agency', 'category'])->accessibleBy(auth()->user());

        if ($request->filled('q')) {
            $searchTerm = '%' . strtolower($request->q) . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->whereRaw('LOWER(title) like ?', [$searchTerm])
                  ->orWhereRaw('LOWER(description) like ?', [$searchTerm])
                  ->orWhereHas('metadata', function($mq) use ($searchTerm) {
                      $mq->whereRaw('LOWER(keywords::text) like ?', [$searchTerm])
                         ->orWhereRaw('LOWER(topic_category) like ?', [$searchTerm])
                         ->orWhereRaw('LOWER(abstract) like ?', [$searchTerm]);
                  });
            });
        }

        if ($request->filled('agency')) {
            $query->where('agency_id', $request->agency);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $datasets = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        $agencies = Agency::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();

        return view('catalog', compact('datasets', 'agencies', 'categories'));
    }

    public function show($slug)
    {
        $dataset = Dataset::with(['agency', 'category', 'layers', 'metadata'])
            ->accessibleBy(auth()->user())
            ->where('slug', $slug)
            ->firstOrFail();

        return view('catalog-detail', compact('dataset'));
    }

    public function exportXml($slug)
    {
        $dataset = Dataset::with(['agency', 'category', 'metadata'])
            ->accessibleBy(auth()->user())
            ->where('slug', $slug)
            ->firstOrFail();

        $title = htmlspecialchars($dataset->title ?? 'Dataset Geospasial Aceh', ENT_XML1);
        $abstract = htmlspecialchars($dataset->metadata?->abstract ?? $dataset->description ?? '-', ENT_XML1);
        $purpose = htmlspecialchars($dataset->metadata?->purpose ?? 'Perencanaan dan Analisis Spasial Kebijakan Satu Peta Aceh', ENT_XML1);
        $contact = htmlspecialchars($dataset->agency?->name ?? 'Pemerintah Provinsi Aceh', ENT_XML1);
        $lineage = htmlspecialchars($dataset->metadata?->data_quality_statement ?? $dataset->metadata?->lineage ?? 'Validasi spasial resmi node data Pemerintah Provinsi Aceh', ENT_XML1);
        
        $west = '95.00';
        $east = '98.50';
        $south = '2.00';
        $north = '6.00';

        if ($dataset->metadata && is_array($dataset->metadata->bounding_box) && count($dataset->metadata->bounding_box) === 4) {
            $west = (string)$dataset->metadata->bounding_box[0];
            $south = (string)$dataset->metadata->bounding_box[1];
            $east = (string)$dataset->metadata->bounding_box[2];
            $north = (string)$dataset->metadata->bounding_box[3];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<gmd:MD_Metadata xmlns:gmd="http://www.isotc211.org/2005/gmd"
                 xmlns:gco="http://www.isotc211.org/2005/gco"
                 xmlns:gml="http://www.opengis.net/gml">
    <gmd:fileIdentifier>
        <gco:CharacterString>' . htmlspecialchars($dataset->slug, ENT_XML1) . '</gco:CharacterString>
    </gmd:fileIdentifier>
    <gmd:language>
        <gco:CharacterString>ind</gco:CharacterString>
    </gmd:language>
    <gmd:dateStamp>
        <gco:Date>' . now()->toDateString() . '</gco:Date>
    </gmd:dateStamp>
    <gmd:contact>
        <gmd:CI_ResponsibleParty>
            <gmd:organisationName>
                <gco:CharacterString>' . $contact . '</gco:CharacterString>
            </gmd:organisationName>
            <gmd:role>
                <gmd:CI_RoleCode codeList="http://standards.iso.org/ittf/PubliclyAvailableStandards/ISO_19139_Schemas/resources/codelist/gmxCodelists.xml#CI_RoleCode" codeListValue="pointOfContact">pointOfContact</gmd:CI_RoleCode>
            </gmd:role>
        </gmd:CI_ResponsibleParty>
    </gmd:contact>
    <gmd:identificationInfo>
        <gmd:MD_DataIdentification>
            <gmd:citation>
                <gmd:CI_Citation>
                    <gmd:title>
                        <gco:CharacterString>' . $title . '</gco:CharacterString>
                    </gmd:title>
                    <gmd:date>
                        <gmd:CI_Date>
                            <gmd:date><gco:Date>' . ($dataset->year ? $dataset->year . '-01-01' : now()->toDateString()) . '</gco:Date></gmd:date>
                            <gmd:dateType><gmd:CI_DateTypeCode codeListValue="publication"/></gmd:dateType>
                        </gmd:CI_Date>
                    </gmd:date>
                </gmd:CI_Citation>
            </gmd:citation>
            <gmd:abstract>
                <gco:CharacterString>' . $abstract . '</gco:CharacterString>
            </gmd:abstract>
            <gmd:purpose>
                <gco:CharacterString>' . $purpose . '</gco:CharacterString>
            </gmd:purpose>
            <gmd:extent>
                <gmd:EX_Extent>
                    <gmd:geographicElement>
                        <gmd:EX_GeographicBoundingBox>
                            <gmd:westBoundLongitude><gco:Decimal>' . $west . '</gco:Decimal></gmd:westBoundLongitude>
                            <gmd:eastBoundLongitude><gco:Decimal>' . $east . '</gco:Decimal></gmd:eastBoundLongitude>
                            <gmd:southBoundLatitude><gco:Decimal>' . $south . '</gco:Decimal></gmd:southBoundLatitude>
                            <gmd:northBoundLatitude><gco:Decimal>' . $north . '</gco:Decimal></gmd:northBoundLatitude>
                        </gmd:EX_GeographicBoundingBox>
                    </gmd:geographicElement>
                </gmd:EX_Extent>
            </gmd:extent>
        </gmd:MD_DataIdentification>
    </gmd:identificationInfo>
    <gmd:dataQualityInfo>
        <gmd:DQ_DataQuality>
            <gmd:lineage>
                <gmd:LI_Lineage>
                    <gmd:statement>
                        <gco:CharacterString>' . $lineage . '</gco:CharacterString>
                    </gmd:statement>
                </gmd:LI_Lineage>
            </gmd:lineage>
        </gmd:DQ_DataQuality>
    </gmd:dataQualityInfo>
</gmd:MD_Metadata>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="metadata-' . $dataset->slug . '-sni-iso19115.xml"',
        ]);
    }
}
