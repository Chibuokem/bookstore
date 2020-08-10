<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Interfaces\OrderRepositoryInterface;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            // $this->poll();
            // echo 'hi';
            $orders = $this->orderRepositoryInterface->getUnverifiedOrders();
            if ($orders) {
                foreach ($orders as $order) {
                    if ($order->transaction_flutterwave_id != "") {
                        $transaction_id = $order->transaction_flutterwave_id;
                        echo $transaction_id;
                        if ($transaction_id != "") {
                            $verify = $this->orderRepositoryInterface->verifyTransaction($order->reference);
                            if ($verify === true) {
                                //confirm transaction
                                $this->orderRepositoryInterface->updateStatus($order->id, 1);
                            }
                        }
                    }
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    public function poll()
    {
        //get all unverified transactions
        $orders = $this->orderRepositoryInterface->getUnverifiedOrders();
        if ($orders) {
            foreach ($orders as $order) {
                if ($order->transaction_flutterwave_id != "") {
                    $transaction_id = $order->transaction_flutterwave_id;
                    echo $transaction_id;
                    if ($transaction_id != "") {
                        $verify = $this->orderRepositoryInterface->verifyTransaction($order->reference);
                        if ($verify === true) {
                            //confirm transaction
                            $this->orderRepositoryInterface->updateStatus($order->id, 1);
                        }
                    }
                }
            }
        }
    }
}