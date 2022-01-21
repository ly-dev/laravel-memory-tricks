<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderItem;
use Database\Factories\OrderFactory;
use Illuminate\Console\Command;

class MockOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mock:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create 10000 mock orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach(Order::factory()->count(10000)->create() as $order) {
            OrderItem::factory()->count(rand(5,10))->for($order)->create();
        }
    }
}
