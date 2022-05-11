<?php

namespace App\Observers;

use App\Models\BrandMaster;

class BrandMasterObserver
{
    /**
     * Handle the BrandMaster "creating" event.
     *
     * @param BrandMaster $brand
     * @return void
     */
    public function creating(BrandMaster $brand)
    {
        if($brand->ja_name != '' && $brand->en_name != ''){
            $name = $brand->en_name.'['.$brand->ja_name.']';
        }else if($brand->en_name != ''){
            $name = $brand->en_name;
        }else{
            $name = '['.$brand->ja_name.']';
        }

        $brand->name = $name;
    }

    /**
     * Handle the BrandMaster "updating" event.
     *
     * @param BrandMaster $brand
     * @return void
     */
    public function updating(BrandMaster $brand)
    {
        if($brand->ja_name != '' && $brand->en_name != ''){
            $name = $brand->en_name.'['.$brand->ja_name.']';
        }else if($brand->en_name != ''){
            $name = $brand->en_name;
        }else{
            $name = '['.$brand->ja_name.']';
        }
        
        $brand->name = $name;
    }
}
