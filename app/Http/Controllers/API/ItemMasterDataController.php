<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Application\Services\ItemLabelService;
use App\Application\Services\BrandMasterService;
use App\Application\Services\ProductTypeService;
use App\Application\Services\ItemCategoryService;

class ItemMasterDataController extends Controller
{
    /**
     * @var ItemCategoryService $category
     * @var BrandMasterService $brand
     * @var ItemLabelService $label
     * @var ProductTypeService $type
     */
    protected $category;
    protected $categoryService;
    protected $label;
    protected $type;

    public function __construct( 
        ItemCategoryService $category,
        BrandMasterService $brand,
        ItemLabelService $label,
        ProductTypeService $type
    )
    {
        $this->category = $category;
        $this->brand = $brand;
        $this->label = $label;
        $this->type = $type;
    }

    /**
     * List Item categories
     * @return Response
     */
    public function categories()
    {
        $data = $this->category->index();

        return $data;
    }

    /**
     * List Item Labels
     * @return Response
     */
    public function labels()
    {
        $data = $this->label->index();

        return $data;
    }

    /**
     * List All brands
     * @return Response
     */
    public function brands()
    {
        $data = $this->brand->index();

        return $data;
    }

    /**
     * List all product types
     * @return Response
     */
    public function types()
    {
        $data = $this->type->index();

        return $data;
    }
}
