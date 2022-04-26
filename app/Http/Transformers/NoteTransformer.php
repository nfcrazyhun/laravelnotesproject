<?php

namespace App\Http\Transformers;

class NoteTransformer extends Transformer {

    public function transform($note) {

        return [
            'id' => $note['id'],
            'user_id' => $note['user_id'],
            'status' => $note['user_id'],
        ];
    }
}
