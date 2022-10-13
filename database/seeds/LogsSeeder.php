<?php

use App\Models\ModCP\DuelLog;
use App\Models\ModCP\TradeLog;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LogsSeeder extends Seeder
{

    private $faker = null;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $acceptedItems = [
            '11830' => 'Armadyl Chainskirt',
            '11832' => 'Bandos Chestplate',
            '11834' => 'Bandos Tassets',
            '13239' => 'Primordial Boots',
            '11802' => 'Armadyl Godsword',
            '23267' => 'Gilded Legs',
            '20149' => 'Gilded Chainbody',
            '23264' => 'Gilded Body',
            '3481' => 'Gilded Platebody',
            '20184' => 'Guthix Platebody',
            '20187' => 'Guthix Platelegs',
            '20193' => 'Guthix Helmet',
            '20211' => 'Team 0 Cape',
        ];
        $this->faker = Faker::create();
        for($i = 0; $i < $this->faker->numberBetween(500, 1000); $i++) {
            $given = '';
            for($k = 0; $k < 4; $k++) {
                $id = array_rand($acceptedItems);
                if ($k === 0) {
                    $given .= '[';
                }
                $given .= '{"id":' . $id . ',"amount":' . $this->faker->numberBetween(1, 2144000000) . ',"name":"' . $acceptedItems[$id] .'"}';
                if($k !== 3) {
                    $given .= ',';
                } else {
                    $given .= ']';
                }
            }
            $received = '';
            for($j = 0; $j < 4; $j++) {
                $id = array_rand($acceptedItems);
                if ($j === 0) {
                    $received .= '[';
                }
                $received .= '{"id":' . $id . ',"amount":' . $this->faker->numberBetween(1, 2144000000) . ',"name":"' . $acceptedItems[$id] .'"}';
                if($j !== 3) {
                    $received .= ',';
                } else {
                    $received .= ']';
                }
            }
           $tradeLog = new TradeLog();
           $tradeLog->user = $this->faker->firstName;
           $tradeLog->user_ip = ($this->faker->boolean) ? $this->faker->ipv4 : $this->faker->ipv6;
           $tradeLog->given = $given;
           $tradeLog->partner = $this->faker->firstName;
            $tradeLog->partner_ip = ($this->faker->boolean) ? $this->faker->ipv4 : $this->faker->ipv6;
            $tradeLog->received = $received;
            $tradeLog->world = 1;
            $tradeLog->time_added = Carbon::now()->subDays($this->faker->numberBetween(0, 20));
            $tradeLog->save();
        }
        for($l = 0; $l < $this->faker->numberBetween(200000, 1000000); $l++) {
            $duelLog = new DuelLog();
            $duelLog->user = $this->faker->firstName;
            $duelLog->user_ip = ($this->faker->boolean) ? $this->faker->ipv4 : $this->faker->ipv6;
            $duelLog->user_staked_coins = $this->faker->numberBetween(0, 2147000);
            $duelLog->user_staked_tokens = $this->faker->numberBetween(0, 2147000);
            $duelLog->opponent = $this->faker->firstName;
            $duelLog->opponent_ip = ($this->faker->boolean) ? $this->faker->ipv4 : $this->faker->ipv6;
            $duelLog->opponent_staked_coins = $this->faker->numberBetween(0, 2147000);
            $duelLog->opponent_staked_tokens = $this->faker->numberBetween(0, 2147000);
            $duelLog->world = 1;
            $duelLog->time_added = Carbon::now()->subDays($this->faker->numberBetween(0, 20));
            $duelLog->save();
        }
    }
}
