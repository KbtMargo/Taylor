<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        Log::info('OrderController@store method called.');

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,product_id',
            'quantity_m' => 'required|numeric|min:0.1', 
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'delivery_service' => 'nullable|string|max:255',
            'delivery_address' => 'nullable|string|max:255',
            'customer_comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Log::warning('Order validation failed.', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Log::info('Order validation successful.');

        $product = Product::findOrFail($request->product_id);

        if ($product->stock_m < $request->quantity_m) {
            Log::warning('Not enough stock for product ID: ' . $product->product_id);
            return redirect()->back()->withErrors(['quantity_m' => 'Вибачте, на складі недостатньо товару.'])->withInput();
        }

        $totalAmount = $product->price_per_m * $request->quantity_m;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'total_amount' => $totalAmount,
                'delivery_service' => $request->delivery_service,
                'delivery_address' => $request->delivery_address,
                'customer_comment' => $request->customer_comment,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->product_id,
                'quantity_m' => $request->quantity_m,
                'price_per_m' => $product->price_per_m,
            ]);

            $product->decrement('stock_m', $request->quantity_m);

            DB::commit();

            Log::info('Order created successfully. Order ID: ' . $order->id);
            return redirect()->back()->with('success', 'Ваше замовлення успішно оформлено! Наш менеджер скоро з вами зв\'яжеться.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing order: ' . $e->getMessage());
            return redirect()->back()->withErrors(['msg' => 'Виникла помилка при оформленні замовлення. Спробуйте ще раз.'])->withInput();
        }
    }
}

