<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DesignationTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(BarcodeItems::class);
        $this->call(LocalizationSeeder::class);
        $this->call(WdataStatusSeeder::class);
        $this->call(WdataPicSeeder::class);
        $this->call(CarrierSeeder::class);
        $this->call(ShipperSeeder::class);
        $this->call(MovementConfirmationSeeder::class);
        $this->call(InboundStatusSeeder::class);
        $this->call(ForeignDeliveryClassification::class);
        $this->call(DeliverTableSeeder::class);
        $this->call(ItemCategorySeeder::class);
        $this->call(ItemLabelSeeder::class);
        $this->call(ProductTypesSeeder::class);
        $this->call(ContainerTableSeeder::class);
        $this->call(DeliveryPlaceTableSeeder::class);
        $this->call(IncompleteTableSeeder::class);
        $this->call(PicDirectionTableSeeder::class);
        $this->call(ReasonTableSeeder::class);
        $this->call(ShipmentTableSeeder::class);
        $this->call(TrackInputTableSeeder::class);
        $this->call(TransferTableSeeder::class);
        $this->call(WarehouseJobSeeder::class);
        $this->call(WdataCategorySeeder::class);

        // $this->call(Artisan::call('member:migrate'));
        // $this->call(Artisan::call('clientCat:migrate'));
        // $this->call(Artisan::call('amazon:migrate'));
        // $this->call(Artisan::call('delivery:migrate'));
        // $this->call(Artisan::call('brandMaster:migrate'));
        // $this->call(Artisan::call('clientMaster:migrate'));
        // $this->call(Artisan::call('itemMaster:migrate'));
        
        // $this->call(Artisan::call('sdata:migrate'));
        // $this->call(Artisan::call('wdata:migrate'));
        // $this->call(Artisan::call('customBrokers:migrate'));
    }
}
