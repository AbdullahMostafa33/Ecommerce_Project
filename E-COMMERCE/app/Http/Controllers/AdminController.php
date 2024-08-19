<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    // Show dashboard
    private function Percent($Model,$column='id',$op='!=',$value='0'){
        $current=    $Model:: Where($column, $op,$value)
        ->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))->count();

        $last  = $Model::Where($column, $op, $value)
        ->whereMonth('created_at', date('m')-1)
        ->whereYear('created_at', date('Y'))->count();

        return $last > 0 ? (($current - $last) / $last) * 100 : $current * 100;   
    }
    public function dashboard()
    {
        $count_pending=Order::where('status_move','pending')->count();
        $count_processing = Order::where('status_move', 'processing')->count();
        $count_completed = Order::where('status_move', 'completed')->count();
        $count_cancelled = Order::where('status_move', 'cancelled')->count();

        $last_orders = Order::latest()->take(4)->get();
        $usersThisMonth = User::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->count();
        $count_order = Order::where('status_move','pending')
        ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->count();
       
        $percent_order= $this->Percent(Order::class);      
        $percent_user= $this->Percent((User::class)); 
        $percent_pending=$this->Percent(Order::class,'status_move','=','pending');

       
        $months=[];
          for($i=date('m')-1;$i>=0;$i--){
            $months[]
            = Order::where('status', 'paid')
            ->whereMonth('created_at', date('m')-$i)
            ->whereYear('created_at', date('Y'))->sum('total_price');
          }
        $total_current=$months[date('m')-1];
        $total_last = $months[date('m') - 2];
        $percent_total = $total_last > 0 ? round((($total_current - $total_last) / $total_last) * 100 ): $total_current * 100; 
        
        return view('admin.dashboard',compact([
            'count_pending', 'count_processing', 'count_completed', 'count_cancelled',
            'last_orders',
            'count_order',
            'percent_order',
            'percent_user',
            'percent_pending','months',
            'total_current',
            'percent_total',
            'usersThisMonth']));
    }
    // index for products
    public function indexProduct(Request $request)
    {
        if($request->search) $products = Product::Filter($request->search)->get();
        else $products = Product::all();
        return view('admin.products.index', ["products" => $products]);
    }
    // Show form to create a new product
    public function createProduct()
    {
        $sections = Section::all();
        return view('admin.products.form', ['sections' => $sections]);

    }

    // Store a new product
    public function storeProduct(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->file('image_file')) {
            $image = $request->file('image_file');
            $imageName =  time() . '.' . $image->extension();
            $image->move(public_path('images/products'), $imageName);

            $request['image']= 'images/products/'.$imageName;
        }
        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    // Show form to edit a product
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $sections = Section::all();
        return view('admin.products.edit', compact('product', 'sections'));
    }

    // Update a product
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
        ]);
        if ($request->file('image_file')) {
            $image = $request->file('image_file');
            $imageName =  time() . '.' . $image->extension();
            $image->move(public_path('images/products'), $imageName);

            $request['image'] = 'images/products/' . $imageName;
            $imagePath = public_path($product->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // Delete a product
    public function deleteProduct(Product $id)
    {
        $imagePath = public_path($id->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $id->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

   // index sections
    public function indexSection(Request $request)
    {

        if ($request->search) $sections = Section::Filter($request->search)->get();
        else $sections=Section::all();

        return view('admin.sections.index', ['sections' => $sections]);
    }
 // Show form to create a new section
    public function createSection()
    {
        return view('admin.sections.form');
    }

    // Store a new section
    public function storeSection(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Section::create($request->all());

        return redirect()->route('admin.sections.index')->with('success', 'Section created successfully !');
    }

    // Show form to edit a section
    public function editSection(Section $section)
    {        
        return view('admin.sections.edit', compact('section'));
    }

    // Update a section
    public function updateSection(Request $request, Section $section)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $section->update($request->all());

        return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully !');
    }

    // Delete a section
    public function deleteSection($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->route('admin.sections.index')->with('success', 'Section deleted successfully !');
    }

    // View and manage orders
    public function viewOrders(Request $request)
    {
        if($request->status_move)  $orders = Order::where('status_move', $request->status_move)->get();            
        elseif ($request->search) $orders=Order::Filter($request->search)->get();
        else $orders = Order::all();
      //  return $orders;
        return view('admin.orders.index', compact('orders'));
    }

    // show order
   public function showOrder($id){

        $order = Order::findOrFail($id);
        return view('admin.orders.show', compact('order'));
   }

    // Update order status
    public function updateOrderStatus(Request $request,   $id)
    {
        $order = Order::findOrFail($id);
        $order->status_move = $request->status_move;
        $order->save();
;

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
    public function deleteorder(Order $order)
    {
        if($order) $order->delete();

        return redirect()->back()->with('success', 'order deleted.');
    }


//Notifications
    public function showNotifications(){
        return view('admin.notification.notifications');
    }
    public function markAsRead($id, $order_id)
    {

        $notification = auth()->user()->notifications->findOrFail($id);
        if ($notification) {
            $notification->markAsRead();
        }
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->route('admin.orders.show',$order_id);
    }
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function deleteAllNotifications()
    {
        $notifications=  auth()->user()->notifications;
       foreach($notifications as $notification){
            $notification->delete();
       }

        return redirect()->back()->with('success', 'All notifications deleted.');
    }
}