<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Transaction;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function exportTransactions(Request $request)
    {
        // Validar los datos del formulario si es necesario
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Obtener transacciones en el rango de fechas especificado
        $transactions = Transaction::whereBetween('created_at', [
            Carbon::parse($request->start_date)->startOfDay(),
            Carbon::parse($request->end_date)->endOfDay(),
        ])->where('user_id', auth()->id())->get();

        // Crear un nuevo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Escribir encabezados
        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'Descripción');
        $sheet->setCellValue('C1', 'Monto');
        $sheet->setCellValue('D1', 'Tipo');
        $sheet->setCellValue('E1', 'Categoría');
        $sheet->setCellValue('F1', 'Fecha');

        $translations = [
            'income' => 'ingreso',
            'expense' => 'gasto'
        ];

        // Escribir datos de transacciones
        $row = 2;
        foreach ($transactions as $transaction) {
            $sheet->setCellValue('A' . $row, ($row-1));
            $sheet->setCellValue('B' . $row, $transaction->description);
            $sheet->setCellValue('C' . $row, $transaction->amount);
            $type = $transaction->type;
            $translatedType = isset($translations[$type]) ? $translations[$type] : $type;
            $sheet->setCellValue('D' . $row, ucfirst($translatedType));
            $sheet->setCellValue('E' . $row, $transaction->category->name ?? '-');
            $sheet->setCellValue('F' . $row, $transaction->created_at->format('Y-m-d H:i:s'));
            $row++;
        }

        // Crear el escritor (Writer) para Excel
        $writer = new Xlsx($spreadsheet);

        // Guardar el archivo en storage/app/public
        $fileName = 'transactions_' . now()->format('Ymd_His') . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        // Devolver una respuesta de descarga
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
