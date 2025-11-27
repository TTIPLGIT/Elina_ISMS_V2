<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;


class refundjob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $client = new Client();

        $rows = DB::select("SELECT a.active_flag , a.receipt_num,b.enrollment_child_num,a.payment_status_id,b.child_id,b.child_name,a.payment_for FROM payment_status_details AS a
        INNER JOIN enrollment_details AS b ON a.enrollment_child_num =b.enrollment_child_num ORDER BY payment_status_id DESC");

        foreach ($rows as $key => $value) {
            $order_id = $value->receipt_num;
            // LOG::info($order_id);
            if ($order_id != '' && $value->active_flag != 1) {

                $headers = [
                    'accept' => 'application/json',
                    'x-api-version' => '2022-09-01',
                    'x-client-id' => config('setting.cashfree_client_id'),
                    'x-client-secret' => config('setting.cashfree_client_secret')
                ];


                $refund = 'https://sandbox.cashfree.com/pg/orders/' . $order_id . '/refunds';
                // LOG::info($refund);

                $response = $client->request('GET', $refund, [
                    'headers' => $headers
                ]);
                $body = $response->getBody()->getContents();
                // log::info($body);
                $parant_data = json_decode($body);
                // log::info($parant_data);

                if (!empty($parant_data)) {


                    $refund_details = DB::table('refund_details')->updateOrInsert(
                        ['order_id' => $value->receipt_num,],
                        [
                            'refund_details' => json_encode($parant_data),
                            'order_id' => $value->receipt_num,
                            'enrollment_id' => $value->enrollment_child_num,
                            'payment_id' => $value->payment_status_id,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]
                    );
                    $receipt_num = $parant_data[0]->cf_payment_id;
                    $payment_status = 'REFUND ' . $parant_data[0]->refund_status;
                    $refund_update = DB::table('payment_status_details')
                        ->where('enrollment_child_num', $value->enrollment_child_num)
                        ->update([
                            'payment_status' => $payment_status,
                        ]);

                    $refund_data = DB::select("SELECT * FROM payment_process_details WHERE transaction_id = '$receipt_num' AND payment_status='$payment_status'");

                    if (empty($refund_data)) {
                        $refund_log = DB::table('payment_process_details')->insertGetId([
                            'enrollment_child_num' => $value->enrollment_child_num,
                            'child_id' => $value->child_id,
                            'child_name' => $value->child_name,
                            'payment_status' => 'REFUND ' . $parant_data[0]->refund_status,
                            'transaction_id' => $parant_data[0]->cf_payment_id,
                            'receipt_num' =>  $order_id,
                            'payment_completion_time' => $parant_data[0]->processed_at,
                            'payment_currency' => $parant_data[0]->refund_amount,
                            'refund_flag' => '1',
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    }
                }
            }
        }
    }
}
