namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOrderJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        // Process the order: send confirmation emails, generate invoice, etc.
        // For example:
        \Log::info("Processing order ID: " . $this->order->id);
        // Mail::to($this->order->user)->send(new OrderConfirmation($this->order));
    }
}
