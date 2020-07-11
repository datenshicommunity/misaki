<?php


namespace App\Models;


use App\Enums\GameMode;
use Illuminate\Support\Facades\DB;

class ClanModel
{
    public function countClan()
    {
        return DB::select('SELECT COUNT(*) count FROM clans');
    }

    public function getListClan(int $gameMode, int $limit = 50, int $offset = 0)
    {
        switch ($gameMode) {
            case GameMode::TAIKO:
                $totalScoreColumn = 'total_score_taiko';
                $averagePpColumn = 'pp_taiko';
                break;
            case GameMode::CTB:
                $totalScoreColumn = 'total_score_ctb';
                $averagePpColumn = 'pp_ctb';
                break;
            case GameMode::MANIA:
                $totalScoreColumn = 'total_score_mania';
                $averagePpColumn = 'pp_mania';
                break;
            default:
                $totalScoreColumn = 'total_score_std';
                $averagePpColumn = 'pp_std';
                break;
        }

        return DB::select(
            sprintf('SELECT c.id,
                    c.name,
                    COUNT(*) member_count,
                    SUM(%s)  total_score,
                    AVG(%s)  average_pp
                FROM user_clans uc
                    JOIN users u ON u.id = uc.user
                    JOIN (SELECT us.id,
                            (us.total_score_std + rs.total_score_std)     total_score_std,
                            ROUND((us.pp_std + rs.pp_std) / 2)            pp_std,
                            (us.total_score_taiko + rs.total_score_taiko) total_score_taiko,
                            ROUND((us.pp_taiko + rs.pp_taiko) / 2)        pp_taiko,
                            (us.total_score_ctb + rs.total_score_ctb)     total_score_ctb,
                            ROUND((us.pp_ctb + rs.pp_ctb) / 2)            pp_ctb,
                            (us.total_score_mania + rs.total_score_mania) total_score_mania,
                            (us.pp_mania + rs.pp_mania)                   pp_mania
                            FROM users_stats us
                            JOIN rx_stats rs on us.id = rs.id) mixed_stats ON mixed_stats.id = uc.user
                    JOIN clans c ON uc.clan = c.id
                WHERE 1
                  AND privileges & 1 = 1
                GROUP BY clan
                ORDER BY average_pp DESC
                LIMIT %d OFFSET %d',
                $totalScoreColumn,
                $averagePpColumn,
                $limit,
                $offset
            ));
    }
}
