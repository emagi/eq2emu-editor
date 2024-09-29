<?php

class eq2Guilds 
{
    function GetTabArray() {
        $ret = array(
            'guild_main'=>'Main', 
            'guild_members'=>'Members',
            'guild_ranks'=>'Ranks',
            'guild_points'=>'Points',
            'guild_bank_settings'=>'Bank Settings',
            'guild_recruiting'=>'Recruiting',
            'guild_achievements'=>'Achievements'
        );
        global $eq2;
        return $ret;
    }

    //handles odd datasets before sending it to database
    public function PreInsert() 
    {
		global $eq2;
    }

    //handles odd datasets before update
    public function PreUpdate() 
    {
        global $eq2;
    }

    //redirects browser after delete
    public function PostDeletes()
    {
        global $eq2;
    }

    //redirects browser after insert
    public function PostInsert($insert_res) 
    {
		global $eq2;
    }

    //redirects browser after update
    public function PostUpdate() 
    {
		global $eq2;
    }
}
?>