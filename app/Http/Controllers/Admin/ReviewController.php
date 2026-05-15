<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('user', 'product')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $reviews = $query->paginate(5)->withQueryString();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateStatus(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $review->update(['status' => $request->status]);
        return back()->with('success', 'تم تحديث حالة التقييم');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'تم حذف التقييم');
    }
}
