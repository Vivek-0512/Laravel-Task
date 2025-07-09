use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Jobs\ProcessOrderJob;

public function placeOrder(Request $request)
{
    DB::beginTransaction();

    try {
        // Step 1: Validate and create the order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $request->input('total'),
            'status' => 'pending',
        ]);

        // Step 2: Create order items (assuming you have order_items table)
        foreach ($request->input('items') as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Step 3: Commit the transaction
        DB::commit();

        // Step 4: Dispatch job for further processing
        ProcessOrderJob::dispatch($order);

        return response()->json(['message' => 'Order placed successfully.'], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error("Order failed: " . $e->getMessage());

        return response()->json(['error' => 'Failed to place order.'], 500);
    }
}
