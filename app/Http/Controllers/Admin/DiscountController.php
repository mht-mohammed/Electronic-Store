<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::with('product')->latest()->paginate(10);
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.discounts.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|numeric|min:0',
            'starts_at'  => 'nullable|date',
            'ends_at'    => 'nullable|date|after_or_equal:starts_at',
        ]);

        $data['is_active'] = $request->has('is_active');

        Discount::create($data);
        return redirect()->route('admin.discounts.index')
                         ->with('success', 'تم إضافة الخصم بنجاح');
    }

    public function edit(Discount $discount)
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.discounts.edit', compact('discount', 'products'));
    }

    public function update(Request $request, Discount $discount)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|numeric|min:0',
            'starts_at'  => 'nullable|date',
            'ends_at'    => 'nullable|date|after_or_equal:starts_at',
        ]);

        $data['is_active'] = $request->has('is_active');

        $discount->update($data);
        return redirect()->route('admin.discounts.index')
                         ->with('success', 'تم تحديث الخصم');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discounts.index')
                         ->with('success', 'تم حذف الخصم');
    }
}
