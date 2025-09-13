<?php

namespace App\Http\Controllers;

abstract class Controller
{ 
    protected $perPage = 50;

    public function convert2english($string)
    {
        $newNumbers     = range(0, 9);
        $persianDecimal = ['&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;'];
        $arabicDecimal  = ['&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;'];
        $arabic         = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $persian        = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $string         = str_replace($persianDecimal, $newNumbers, $string);
        $string         = str_replace($arabicDecimal, $newNumbers, $string);
        $string         = str_replace($arabic, $newNumbers, $string);
        return str_replace($persian, $newNumbers, $string);
    } 

    function buildTree($elements, $parentId = 0, $childName = 'children')
    {
        $categories = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id'], $childName);
                if ($children) {
                    $element[$childName] = $children;
                }
                $categories[$element['id']] = $element;
                unset($elements[$element['id']]);
            }
        }
        usort($categories, function($a, $b){
            return $a["orders"] > $b["orders"];
        });
        return $categories;
    }


}

