<?php

namespace App\Services\Inventory;

use App\Constants\StateInventoryRequest;
use App\Models\Inventory;
use App\Models\InventoryRequest;
use App\Models\InventoryRequestDetail;
use Illuminate\Support\Facades\DB;

class InventoryRequestService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $requests = InventoryRequest::all();
        return $requests;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        return InventoryRequest::leftJoin('users', 'users.id', '=', 'inventory_requests.user_id')
            ->select('inventory_requests.*', 'users.nombre as name_user', 'users.apellido as lastname_user')
            ->where('users.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('users.apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('inventory_requests.fecha', $order)
            ->paginate($paginate);
    }

    static public function getAllPaginateForUser($userId, $attribute, $paginate, $order = "desc")
    {
        $requests = InventoryRequest::leftJoin('users', 'users.id', '=', 'inventory_requests.user_id')
            ->select('inventory_requests.*', 'users.nombre as name_user', 'users.apellido as lastname_user')
            ->where(function ($query) use ($attribute) {
                $query->where('users.apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
                    ->orWhere('users.nombre', 'ILIKE', '%' . strtolower($attribute) . '%');
            })->orderBy('inventory_requests.fecha', $order)
            ->paginate($paginate);
        return $requests;
    }

    static  public function getOne($id)
    {
        $request = InventoryRequest::find($id);
        return $request;
    }

    static public function getOneAll($id)
    {
        $request = InventoryRequest::leftJoin('users', 'users.id', '=', 'inventory_requests.user_id')
            ->select('inventory_requests.*', 'users.nombre as name_user', 'users.apellido as lastname_user')
            ->where('inventory_requests.id', $id)
            ->first();

        return $request;
    }

    static public function create($note, $detail)
    {
        try {
            DB::transaction(function () use ($note, $detail) {
                $new = InventoryRequest::create($note);
                foreach ($detail as $item) {
                    $product = Inventory::find($item['inventario_id']);
                    if ($product->total_unidades < $item['cantidad']) {
                        throw new \Exception('La cantidad solicitada es mayor al stock');
                    }
                    $detail = InventoryRequestDetail::create([
                        'cantidad' => $item['cantidad'],
                        'inventario_solicitud_id' => $new->id,
                        'inventario_id' => $item['inventario_id'],
                        'estado' => StateInventoryRequest::PENDIENTE
                    ]);
                }
            });
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($note, $detail)
    {
        try {
            DB::transaction(function () use ($note, $detail) {
                $note = InventoryRequest::find($note['id']);
                $note->update($note);

                if ($note->estado != StateInventoryRequest::APROBADO)  return true;

                foreach ($detail as $item) {
                    $detailDB = InventoryRequestDetail::findOne($item['id']);
                    $detailDB->update($item);
                    if ($detailDB->estado != StateInventoryRequest::APROBADO) continue;

                    $product = Inventory::find($item['inventario_id']);
                    if ($product->total_unidades < $item['cantidad']) {
                        throw new \Exception('La cantidad solicitada es mayor al stock');
                    }

                    $product->total_unidades -= $item['cantidad'];
                    $containers = $product->total_unidades / ($product->unidades_contenedor);
                    $product->cantidad_contenedor = ceil($containers);
                    $product->save();
                }
            });
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $request = InventoryRequest::find($id);
            $request->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
