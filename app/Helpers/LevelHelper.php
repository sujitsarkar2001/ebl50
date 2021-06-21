<?php

if (!function_exists('DummyFunction')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function level($user)
    {
        $left   = $user->countLeft();
        $middle = $user->countMiddle();
        $right  = $user->countRight();
        
        if ($left < 2 || $middle < 2 || $right < 2) {
            $level = 'No Level';
        }
        if ($left >= 2 && $middle >= 2 && $right >= 2) {
            $level = 'Elite';
        }
        if ($left > 2 && $left >= 9 && $middle > 2 && $middle >= 9 && $right > 2 && $right >= 9) {
            $level = 'Executive Elite';
        }
        if ($left > 9 && $left >= 50 && $middle >9 && $middle >= 50 && $right > 9 && $right >= 50) {
            $level = 'Executive';
        }
        if ($left > 50 && $left >= 120 && $middle > 50 && $middle >= 120 && $right > 50 && $right >= 120) {
            $level = 'Senior Executive';
        }
        if ($left > 120 && $left >= 360 && $middle > 120 && $middle >= 360 && $right > 120 && $right >= 360) {
            $level = 'Assistant Manager';
        }
        if ($left > 360 && $left >= 1080 && $middle > 360 && $middle >= 1080 && $right > 360 && $right >= 1080) {
            $level = 'Manager';
        }
        if ($left > 1080 && $left >= 3240 && $middle > 1080 && $middle >= 3240 && $right > 1080 && $right >= 3240) {
            $level = 'General Manager';
        }
        if ($left > 3240 && $left >= 9270 && $middle > 3240 && $middle >= 9270 && $right > 3240 && $right >= 9270) {
            $level = 'National Manager';
        }
        if ($left > 9270 && $left >= 29160 && $middle > 9270 && $middle >= 29160 && $right > 9270 && $right >= 29160) {
            $level = 'Director';
        }
        if ($left > 29160 && $left >= 87480 && $middle > 29160 && $middle >= 87480 && $right > 29160 && $right >= 87480) {
            $level = 'Presidential Director';
        }
        if ($left >= 87480 && $middle >= 87480 && $right >= 87480) {
            $level = 'Owners Club Member';
        }

        return $level;
    }
}
