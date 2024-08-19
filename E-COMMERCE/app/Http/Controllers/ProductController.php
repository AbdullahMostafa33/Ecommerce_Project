<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Show list of products in a section
    public function index($section_id, Request $request)
    {
        if ($request->search) {
            $products = Product::Filter($request->search)->get();
        } else $products = Product::where('section_id', $section_id)->get();
        return view('products.index', compact('products'));
    }

    // Show a specific product's details
    public function show($id)
    {
        $product = Product::with('comments.user')->findOrFail($id);
        $userComment = Comment::where([
            ['user_id', Auth::id()],
            ['product_id', $id]
        ])->first();
        $rate = round($product->comments()->avg('rating'));

        return view('products.show', compact('product', 'userComment', 'rate'));
    }
    public function showSections()
    {
        $sections = Section::all();
        return view('products.sections', compact('sections'));
    }

    public function storeComment(Request $request, $productId)
    {
        // return $request;
        $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'nullable|integer|between:1,5',
        ]);

        $comment = new Comment();
        $comment->product_id = $productId;
        $comment->user_id = Auth::id();
        $comment->comment = $request->input('comment');
        $comment->rating = $request->input('rating');
        $comment->save();

        return redirect()->route('product.show', $productId)->with('success', 'Comment added successfully.');
    }

    public function updateComment(Request $request, Comment $comment)
    {
        $validatedData = $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'nullable|integer|between:1,5',
        ]);

        $comment->update($validatedData);

        return redirect()->back()->with('success', 'Comment updated successfully.');
    }
}
