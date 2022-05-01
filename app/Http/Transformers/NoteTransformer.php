<?php

namespace App\Http\Transformers;

class NoteTransformer extends Transformer {

    public function transform($note) {

        return [
            'id' => $note['id'],
            'user_id' => $note['user_id'],
            'body' => $note['body'],
            'status' => $note['status'],
        ];
    }
}
