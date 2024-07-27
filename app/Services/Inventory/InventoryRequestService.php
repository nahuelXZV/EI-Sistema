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

    static public function getAllPaginate($attribute, $paginate, $filter, $order = "desc")
    {
        return InventoryRequest::leftJoin('users', 'users.id', '=', 'inventory_requests.user_id')
            ->select('inventory_requests.*', 'users.nombre as name_user', 'users.apellido as lastname_user')
            ->where(function ($query) use ($filter) {
                if ($filter != null) $query->where('inventory_requests.estado', $filter);
            })
            ->where(function ($query) use ($attribute) {
                $query->where('users.apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
                    ->orWhere('users.nombre', 'ILIKE', '%' . strtolower($attribute) . '%');
            })
            ->orderBy('inventory_requests.fecha', $order)
            ->orderBy('inventory_requests.hora', $order)
            ->paginate($paginate);
    }

    static public function getAllPaginateForUser($userId, $attribute, $paginate, $filter, $order = "desc")
    {
        $requests = InventoryRequest::leftJoin('users', 'users.id', '=', 'inventory_requests.user_id')
            ->select('inventory_requests.*', 'users.nombre as name_user', 'users.apellido as lastname_user')
            ->where('users.id', $userId)
            ->where(function ($query) use ($filter) {
                if ($filter != null) $query->where('inventory_requests.estado', $filter);
            })
            ->where(function ($query) use ($attribute) {
                $query->where('users.apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
                    ->orWhere('users.nombre', 'ILIKE', '%' . strtolower($attribute) . '%');
            })->orderBy('inventory_requests.fecha', $order)
            ->orderBy('inventory_requests.hora', $order)
            ->paginate($paginate);
        return $requests;
    }

    static  public function getOne($id)
    {
        $request = InventoryRequest::leftJoin('users', 'users.id', '=', 'inventory_requests.user_id')
            ->select('inventory_requests.*', 'users.nombre as name_user', 'users.apellido as lastname_user')
            ->where('inventory_requests.id', $id)
            ->first();
        return $request;
    }

    static public function getDetail($request)
    {
        $detail = InventoryRequestDetail::leftJoin('inventories', 'inventories.id', '=', 'inventory_request_details.inventario_id')
            ->select('inventory_request_details.*', 'inventories.nombre as name_product', 'inventories.codigo_partida as codigo_partida', 'inventories.foto as foto')
            ->where('inventory_request_details.inventario_solicitud_id', $request)
            ->get();
        return $detail;
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

    static public function update($note)
    {
        try {
            DB::transaction(function () use ($note) {
                $request = InventoryRequest::find($note['id']);
                $request->estado = $note['estado'];
                if ($note['motivo_rechazo'] != "")
                    $request->motivo_rechazo = $note['motivo_rechazo'];
                $request->save();
                if ($request->estado != StateInventoryRequest::APROBADO) return true;
                $detail = InventoryRequestDetail::where('inventario_solicitud_id', $request->id)->get();
                foreach ($detail as $item) {
                    $item->estado = StateInventoryRequest::APROBADO;
                    $item->save();
                    $product = Inventory::find($item->inventario_id);
                    if ($product->total_unidades < $item->cantidad) {
                        throw new \Exception('La cantidad solicitada es mayor al stock');
                    }

                    $product->total_unidades -= $item->cantidad;
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

    static public function deleteDetail($id)
    {
        try {
            $detail = InventoryRequestDetail::find($id);
            $detail->delete();
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
