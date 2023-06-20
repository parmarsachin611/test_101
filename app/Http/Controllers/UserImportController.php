<?php

namespace App\Http\Controllers;


use App\Imports\UserImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class UserImportController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv'
        ]);

        $spreadsheet = IOFactory::load($request->file('file'));

        // Get the active worksheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Loop through the rows
        foreach ($worksheet->getRowIterator() as $row) {
            // Get the drawing collection from the cell
            $drawingCollection = $worksheet->getDrawingCollection();

            // Loop through the drawing collection
            foreach ($drawingCollection as $drawing) {
                // Check if the drawing is in the current row
                if ($drawing->getCoordinates() == 'C' . $row->getRowIndex()) {
                    // Get the image resource from the drawing
                    $imageResource = $drawing->getImageResource();

                    // Get the mime type of the image
                    $mimeType = $drawing->getMimeType();

                    // Get the file extension based on the mime type
                    $extension = image_type_to_extension(exif_imagetype('data://' . $mimeType . ';base64,' . base64_encode($imageData)));


                    // Save the image to a file
                    $imagePath = 'Product/' . $row->getRowIndex() . '.' . $extension;
                    file_put_contents($imagePath, $imageData->getData());
                }
            }
        }

        return redirect()->back()->with('success', 'Users imported successfully.');
    }
}


?>