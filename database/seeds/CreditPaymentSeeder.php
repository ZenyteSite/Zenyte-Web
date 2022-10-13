<?php

use App\Models\CreditPayment;
use App\Models\ModCP\DuelLog;
use App\Models\ModCP\TradeLog;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CreditPaymentSeeder extends Seeder
{

    private $faker = null;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        $paymentTypes = [
            '1' => 'osrs',
            '2' => 'paypal',
            '3' => 'coinbase',
            '4' => 'HOLIDAY osrs',
        ];
        for($i = 0; $i < $this->faker->numberBetween(3000, 10000); $i++) {
            $paymentType = $paymentTypes[array_rand($paymentTypes)];
            $newPayment = new CreditPayment();
            $newPayment->username = $this->faker->firstName;
            $newPayment->email = $this->faker->email;
            if($paymentType == 'osrs' || $paymentType == 'HOLIDAY osrs') {
                $newPayment->item_name = $this->faker->numberBetween(10,500) . 'M';
            } else {
                $newPayment->item_name = $this->faker->numberBetween(100,5000) . ' Credits';
            }
            $newPayment->paid = $paid =$this->faker->numberBetween(10, 400);
            $newPayment->credit_amount = $paid / 10;
            $newPayment->status = 'Accepted';
            $newPayment->client_ip = $this->faker->ipv4;
            $newPayment->cvc_pass = $this->faker->firstName;
            $newPayment->zip_pass = $paymentType;
            $newPayment->address_pass = $paymentType;
            $newPayment->live_mode = 1;
            $newPayment->paid_on = Carbon::now()->subDays($this->faker->numberBetween(0, 500));
            $newPayment->save();
        }
    }
}
