<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->latest();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name',  'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'blocked') {
            $query->where('is_active', false);
        }

        $customers = $query->withCount('orders')->paginate(15)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $orders = $customer->orders()->latest()->take(5)->get();
        return view('admin.customers.show', compact('customer', 'orders'));
    }

    public function toggle(User $customer)
    {
        $customer->update(['is_active' => !$customer->is_active]);
        $msg = $customer->is_active ? 'تم تفعيل العميل' : 'تم حظر العميل';
        return back()->with('success', $msg);
    }

    public function destroy(User $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')
                         ->with('success', 'تم حذف العميل');
    }
}
