<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements ConfideUserInterface {
    use ConfideUser;
    use HasRole; 

   
    public function profileImage() {
    	return $this->morphOne('Asset', 'assetable');
    }

    public function hasDefaultProfileImage() {
       return $this->profileImage()->first() == null;
    }

    public function getProfileImageAttribute() {    
        $img = $this->profileImage()->first();
        if($img == null) return Asset::where('filename', '=', 'default.png')->first();
        return $img;
    }

    public function getName() {
        return (empty($this->firstname)||empty($this->lastname)) ? $this->username : $this->firstname." ".$this->lastname;
    }

    public function getRoleName() {

        return $this->roles() ? $this->roles()->first()->name : 'no role';
    }

    public function getProfileLinkAttribute() {
        return URL::to('traveler/'.$this->username);
    }


    static function findFromEmail($email) {

        $user = User::where('email', '=', $email)->first();
        
        return $user;

    }


}