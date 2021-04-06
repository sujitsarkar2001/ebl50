<?php

if (!function_exists('DummyFunction')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function totalTeamMemberCount($user)
    {
        $left   = $user->countLeft();
        $middle = $user->countMiddle();
        $right  = $user->countRight();

        return $left + $middle + $right;
    }
}
