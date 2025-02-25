<?php

namespace Database\Populate;

use App\Models\Feedback;
use Core\Database\ActiveRecord\Model;

class FeedbacksPopulate
{
    public static function populate(): void
    {
        $data =  [
            'type' => 'complaint',
            'id_user' => '1',
            'rating' => '5',
            'status_id' => '1',
            'is_harmfull' => '0',
        ];

        $feedback = new Feedback($data);
        $feedback->save();

        $feedback_types = ['compliment', 'question', 'suggestion', 'complaint'];

        $numberOfFeedbacks = 10;

        for ($i = 1; $i < $numberOfFeedbacks; $i++) {
            $random_feedback_type_index = random_int(
                min: 0, max: count(value: $feedback_types) - 1
            );
            $random_user_id = random_int(min: 1, max: 9);
            $random_rating = random_int(min: 1, max: 5);

            $data =  [
            'type' => $feedback_types[$random_feedback_type_index],
            'id_user' => (string) $random_user_id,
            'rating' => (string) $random_rating,
            'status_id' => '1',
            'is_harmfull' => '0',
            ];

            $feedback = new Feedback(params: $data);
            $feedback->save();
        }

        echo "Feedbacks populated with $numberOfFeedbacks registers\n";
    }
}