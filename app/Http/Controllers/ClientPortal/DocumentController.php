<?php

/**
 * Invoice Ninja (https://invoiceninja.com).
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2020. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientPortal\Documents\ShowDocumentRequest;
use App\Http\Requests\Document\DownloadMultipleDocumentsRequest;
use App\Models\Document;
use App\Utils\TempFile;
use App\Utils\Traits\MakesHash;
use Illuminate\Support\Facades\Storage;
use ZipStream\Option\Archive;
use ZipStream\ZipStream;

class DocumentController extends Controller
{
    use MakesHash;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return render('documents.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(ShowDocumentRequest $request, Document $document)
    {
        return render('documents.show', [
            'document' => $document,
        ]);
    }

    public function download(ShowDocumentRequest $request, Document $document)
    {
        return Storage::disk($document->disk)->download($document->url, $document->name);
    }

    public function downloadMultiple(DownloadMultipleDocumentsRequest $request)
    {
        $documents = Document::whereIn('id', $this->transformKeys($request->file_hash))
            ->where('company_id', auth('contact')->user()->company->id)
            ->get();

        $documents->map(function ($document) {
            if (auth()->user('contact')->client->id != $document->documentable->id) {
                abort(401);
            }
        });

        $options = new Archive();

        $options->setSendHttpHeaders(true);

        $zip = new ZipStream('files.zip', $options);

        foreach ($documents as $document) {
            $zip->addFileFromPath(basename($document->filePath()), TempFile::path($document->filePath()));
        }

        $zip->finish();
    }
}
