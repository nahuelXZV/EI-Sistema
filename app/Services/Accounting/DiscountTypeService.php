<?php

namespace App\Services\Accounting;

use App\Models\DiscountType;

class DiscountTypeService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $discount_types = DiscountType::all();
        return $discount_types;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $discount_types = DiscountType::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $discount_types;
    }
    static  public function getOne($id)
    {
        $discount_type = DiscountType::find($id);
        return $discount_type;
    }

    static public function create($data)
    {
        try {
            $new = DiscountType::create($data);
            return $new;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $discount_type = DiscountType::find($data['id']);
            $discount_type->nombre = $data['nombre'];
            $discount_type->porcentaje = $data['porcentaje'] ?? $discount_type->porcentaje;
            $discount_type->documento = $data['documento'] ?? $discount_type->documento;
            $discount_type->save();
            return $discount_type;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $discount_type = DiscountType::find($id);
            $discount_type->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
