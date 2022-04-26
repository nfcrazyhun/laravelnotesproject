<?php

namespace App\Http\Transformers;

class UserTransformer extends Transformer {

    public function transform($user) {

        return [
            'id' => $user['id'],
            'name'	=> $user['name'],
            'username'	=> $user['username'],
            'email' => $user['email'],
            'parent_id' => $user['parent_id'],
        ];
    }
}
