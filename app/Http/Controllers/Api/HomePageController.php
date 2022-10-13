<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiClient;
use App\Helpers\Discord;
use App\Http\Controllers\Controller;
use App\Models\PlayersOnline;

class HomePageController extends Controller
{
    public function getPlayerCount()
    {
        $serverApi = new ApiClient;
        $multipleWorlds = [];
        if (config('homepage.showMultipleWorlds')) {
            $multipleWorlds = [
                'main' => [
                    'worldNumber' => '1',
                    'worldName' => 'ECO Server',
                    'count' => $serverApi->getPlayerCount('main'),
                ],
                'beta' => [
                    'worldNumber' => '2',
                    'worldName' => 'BETA Server',
                    'count' => $serverApi->getPlayerCount('beta'),
                ],
            ];
        }
        $oneWorld = [
            'all' => [
                'worldNumber' => '1',
                'worldName' => 'ECO Server',
                'count' => $serverApi->getPlayerCountFull()
            ]
        ];
        return response()->json( empty($multipleWorlds) ? $oneWorld : $multipleWorlds, 200);
    }

    public function getDiscord()
    {
        $discord = new Discord(config('homepage.discordID'));
        $discord->fetch();
        return response()->json([
            'members' => $discord->getMembers(),
            'memberCount' => $discord->getMemberCount(),
        ], 200);
    }
}