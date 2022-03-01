<?php

namespace Database\Seeders;

use App\Models\BarcodeItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarcodeItems extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $open = fopen(public_path('uploads/barcodeitems.csv'), "r");
        $data = fgetcsv($open, 100, ',');
        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
        {        
            $array[] = $data; 
        }
  
        fclose($open);
        foreach($array as $key => $value){
            BarcodeItem::create([
                'barcode'       => $value[0],
                'item_name'     => $value[1],
                'print_barcode' => $value[2]
            ]);
        }
    }
}
