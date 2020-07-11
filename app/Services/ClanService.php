<?php


namespace App\Services;


use App\Models\ClanModel;

class ClanService
{
    /** @var ClanModel */
    private $clanModel;

    public function __construct()
    {
        $this->clanModel = app(ClanModel::class);
    }

    public function getListClan(int $gameMode, int $page = 0, int $limit = 50) {
        return (object) [
            'code' => 200,
            'page' => $page,
            'max_page' => ceil($this->clanModel->countClan()[0]->count / $limit) - 1,
            'clans' => $this->clanModel->getListClan($gameMode, $limit, $page * $limit),
        ];
    }
}
