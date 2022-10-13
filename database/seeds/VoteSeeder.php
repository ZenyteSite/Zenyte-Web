<?php

use App\Models\Vote\Vote;
use App\Models\Vote\VoteSite;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class VoteSeeder extends Seeder
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
        $runeLocus = new VoteSite();
        $runeLocus->title = 'Runelocus';
        $runeLocus->voteid = 1;
        $runeLocus->url = 'https://runelocus.com';
        $runeLocus->visible = 1;
        $runeLocus->ipAddress = $this->faker->ipv4;
        for($i = 0; $i < $this->faker->numberBetween(3000, 10000); $i++) {
            $vote = new Vote();
            $vote->user_id = $this->faker->numberBetween(1, 400);
            $vote->username = $this->faker->firstName;
            $vote->vote_key = Str::random();
            $vote->site_id = 1;
            $vote->voted_on = $startedOn = Carbon::now()->subDays($this->faker->numberBetween(0, 200));
            $vote->started_on = $startedOn;
            $vote->claimed = 1;
            $vote->claimed_at = Carbon::now();
            $vote->save();
        }
    }
}
