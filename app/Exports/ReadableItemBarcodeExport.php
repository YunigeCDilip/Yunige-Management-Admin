<?php

namespace App\Exports;

use App\Models\ItemMasterStore;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class ReadableItemBarcodeExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    /**
     * @return \Illuminate\Support\Collection
     */
    private $request;

    public function __construct($request){
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        $items = ItemMasterStore::WithQuery()->whereIn('id', $this->request->ids);

        $itemss = array();

        foreach($items->get() as $data){

            $nestedData = array();
            $nestedData['id'] = $data->id;
            $nestedData['name'] = $data->item->product_name;
            $nestedData['barcode'] = $data->item->product_barcode;
            $nestedData['qty'] = $data->quantity;
            $nestedData['created_at'] = $data->created_at->toDateTimeString();
            $itemss[] = $nestedData;
        }

        return collect($itemss);

    }

    public function headings(): array
    {
        return [
            'ID',
            'Item Name',
            'Barcode',
            'Quantity',
            'Created Date',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:F1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

}
