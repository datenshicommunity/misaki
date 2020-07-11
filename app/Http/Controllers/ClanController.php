<?php

namespace App\Http\Controllers;

use App\Enums\GameMode;
use App\Services\ClanService;
use Illuminate\Http\Request;

class ClanController extends Controller
{
    /** @var ClanService */
    private $clanService;

    public function __construct(ClanService $clanService)
    {
        $this->clanService = $clanService;
    }

    public function index(Request $request) {
        $gameMode = $request->query('m', GameMode::STD);
        $page = $request->query('p', 0);
        $limit = $request->query('l', 50);

        return response()->json(
            $this->clanService->getListClan($gameMode, $page, $limit)
        );
    }
}
