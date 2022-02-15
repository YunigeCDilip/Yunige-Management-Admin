<?php

namespace App\Traits;

trait BreadCrumbs {

    public function getBreadCrumbDetails($menuData){
        if($menuData){
            if(isset($menuData['childMenu']) && $menuData['childMenu'] !=''){

                $breadCrumbs = array(
                    array('parent' => $menuData['menu'], 'child' => $menuData['subMenu'], 'url' => url()->current(), 'subChild' => $menuData['childMenu'], 'subChildUrl' => '')
                );
            }else{

                $breadCrumbs = array(
                    array('parent' => $menuData['menu'], 'child' => $menuData['subMenu'], 'url' => url()->current())
                );
            }

            return $breadCrumbs;
        }

    }
}