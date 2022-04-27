<?php

namespace App\Http\Transformers;

class UserTransformer extends Transformer {

    public function transform($user) {

        $array = [
            'id' => $user['id'],
            'name'	=> $user['name'],
            'username'	=> $user['username'],
            'email' => $user['email'],
            'parent_id' => $user['parent_id'],
        ];

        // Append invitation_code to array if code not null
        if ( !empty($user['invitation_code']) ){
            $array['invitation_code'] = $user['invitation_code'];
        }

        return $array;
    }
}
