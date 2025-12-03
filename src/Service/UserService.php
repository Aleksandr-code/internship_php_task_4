<?php


namespace App\Service;


use Carbon\Carbon;

class UserService
{
    public function __construct()
    {
    }

    public function transformDatesPretty(array $users){
        $datesPretty = [];
        foreach($users as $user){
            $dateForHumans = Carbon::createFromDate($user->getLastLoginTime())->diffForHumans();
            $datesPretty[$user->getId()] = $dateForHumans;
        }
        return $datesPretty;
    }
}
