<?php

namespace App\Services\Accounting;

use App\Models\PaymentType;

class PaymentTypeService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $payment_types = PaymentType::all();
        return $payment_types;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $payment_types = PaymentType::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $payment_types;
    }
    static  public function getOne($id)
    {
        $payment_type = PaymentType::find($id);
        return $payment_type;
    }

    static public function create($data)
    {
        try {
            $new = PaymentType::create([
                'nombre' => $data['nombre'],
            ]);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $payment_type = PaymentType::find($data['id']);
            $payment_type->nombre = $data['nombre'];
            $payment_type->save();
            return $payment_type;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $payment_type = PaymentType::find($id);
            $payment_type->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
