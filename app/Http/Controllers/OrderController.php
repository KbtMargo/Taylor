<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|numeric|min:0.1',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::findOrFail($request->input('product_id'));
        $quantity = $request->input('quantity');

        if ($product->stock_m < $quantity) {
            return back()->withErrors(['quantity' => 'На жаль, на складі недостатньо тканини.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $totalAmount = $product->price_per_m * $quantity;

            $order = Order::create([
                'customer_name' => $request->input('customer_name'),
                'customer_phone' => $request->input('customer_phone'),
                'total_amount' => $totalAmount,
                'status' => 'new',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->product_id,
                'quantity_m' => $quantity,
                'price_per_m' => $product->price_per_m,
            ]);

            $product->decrement('stock_m', $quantity);

            DB::commit();

            return redirect()->route('order.success');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['general' => 'Сталася помилка під час оформлення замовлення. Спробуйте ще раз.'])->withInput();
        }
    }

    public function success()
    {
        return view('order.success');
    }
}
