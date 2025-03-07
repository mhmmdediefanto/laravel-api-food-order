<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class OrderController extends Controller
{

    public function index()
    {
        try {
            $orders = Order::select('id', 'customer_name', 'table_no', 'order_date', 'order_time', 'status', 'total_amount', 'cashier_id', 'waiters_id')->latest()->get();
            if (!$orders) {
                return response()->json([
                    'message' => 'Data orders not found',
                    'status' => 404
                ]);
            }
            return response()->json([
                'message' => 'Data orders',
                'data' => $orders,
                'status' => 200,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function showDetail($id)
    {
        try {
            // DB::enableQueryLog();
            $order = Order::with([
                'orderDetails' => function ($query) {
                    $query->select('id', 'order_id', 'item_id', 'qty'); // Kolom dari orderDetails
                },
                'orderDetails.item' => function ($query) {
                    $query->select('id', 'name', 'price', 'image', 'category'); // Kolom dari item
                },
                'waiters' => function ($query) {
                    $query->select('id', 'name');
                },
                'cashier' => function ($query) {
                    $query->select('id', 'name');
                },
            ])->select('id', 'customer_name', 'table_no', 'order_date', 'order_time', 'status', 'total_amount', 'cashier_id', 'waiters_id')->find($id);

            // Print ke console
            // dump(DB::getQueryLog());
            if (!$order) {
                return response()->json([
                    'message' => 'Data order not found',
                    'status' => 404
                ]);
            }
            return response()->json([
                'message' => 'Data order detail',
                'data' => $order,
                'status' => 200,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'customer_name' => 'required|max:255',
            'table_no' => 'required',
            'cahsier_id' => 'nullable',
            'items' => 'required|array', // Validasi untuk memastikan items berupa array
            'items.*.id' => 'required|exists:items,id', // Validasi ID item harus valid di tabel items
            'items.*.qty' => 'nullable|integer|min:1', // Validasi qty harus integer minimal 1
        ]);


        try {

            DB::beginTransaction(); //start transaction

            $validatedData = $request->only(['customer_name', 'table_no', 'items',]);
            $validatedData['order_date'] = date('Y-m-d');
            $validatedData['order_time'] = date('H:i:s');
            $validatedData['status'] = 'ordered';
            $validatedData['total_amount'] = 0;
            $validatedData['waiters_id'] = Auth::user()->id;

            // dd($validatedData);
            $order = Order::create($validatedData);
            collect($validatedData['items'])->each(function ($item) use ($order) {
                $ordered = Item::find($item['id']);
               
                $item['qty'] = $item['qty'] ?? 1;
                if ($ordered) {

                    // create order detail
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'item_id' => $item['id'],
                        'price' => $ordered->price,
                        'qty' => $item['qty']
                    ]);
                } else {
                    return response()->json([
                        'message' => 'Item not found.',
                        'status' => 404
                    ], 404);
                }
            });

            // ubah total amount
            $totalAmount = $order->sumPriceOrder();
            $order->total_amount = $totalAmount;
            $order->save();
            DB::commit(); //commit transaction

            return response()->json([
                'message' => 'Order created successfully.',
                'data' => $validatedData,
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            DB::rollBack(); //rollback transaction
            return response()->json([
                'message' => 'An error occurred while creating the order.',
                'error' => $th->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    public function setAsDone($id)
    {
        try {
            $order = Order::find($id);
            if ($order->status != 'ordered') {
                return response()->json([
                    'message' => 'Order is not ordered.',
                    'status' => 400
                ], 400);
            }
            $order->status = 'done';
            $order->save();
            return response()->json([
                'message' => 'Order updated successfully.',
                'data' => $order,
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred while updating the order.',
                'error' => $th->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    public function setAsPaid(Request $request, $id)
    {
        try {
            $order = Order::find($id);
            $authUser = Auth::user();
            if ($order->status != 'done' && $order->status != 'ordered') {
                return response()->json([
                    'message' => 'Order is not done or ordered.',
                    'status' => 400
                ], 400);
            } elseif ($order->status == 'paid') {
                return response()->json([
                    'message' => 'Order is already paid.',
                    'status' => 400
                ], 400);
            } else {

                $validatedData = $request->validate([
                    'total_amount' => 'required|numeric',
                ]);

                if ($validatedData['total_amount'] <= $order->total_amount) {
                    return response()->json([
                        'message' => 'Total amount is not enough.',
                        'status' => 400
                    ]);
                }

                $order->cashier_id = $authUser->id;
                $order->status = 'paid';
                $order->save();
                return response()->json([
                    'message' => 'Order updated successfully.',
                    'data' => $order,
                    'status' => 200
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred while updating the order.',
                'error' => $th->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
