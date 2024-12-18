<?php

use App\Models\Feedback;
use App\Models\User;
use Core\Debug\Debugger;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    private $user;
    private $feedback;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = new User(params: [
            'name' => 'Fulano',
            'academic_register' => '0',
            'email' => 'fulano@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'phone' => '0',
        ]);
        $this->user->save();

        $this->feedback = new Feedback(params: [
            'type' => 'compliment',
            'id_user' => $this->user->id,
            'rating' => 5,
            'is_harmfull' => 0
        ]);
        $this->feedback->save();
    }

    public function test_should_create_feedback(): void
    {
        $this->assertTrue(condition: $this->feedback->save());
        $this->assertCount(expectedCount: 1, haystack: Feedback::all());
    }

    public function test_should_retrieve_all_feedbacks(): void
    {
        $feedback2 = $this->user->feedbacks()->new(params: [
            'type' => 'complaint',
            'id_user' => $this->user->id,
            'rating' => 3,
            'is_harmfull' => 1
        ]);
        $feedback2->save();

        $this->assertCount(expectedCount: 2, haystack: Feedback::all());
    }

    public function test_should_update_feedback(): void
    {
        $feedback2 = $this->user->feedbacks()->new(
            params: [
                'type' => 'complaint',
                'id_user' => $this->user->id,
                'rating' => 3,
                'is_harmfull' => 1
            ]
        );
        $feedback2->save();

        $this->assertEquals(
            expected: 3, actual: $feedback2->rating
        );

        $feedback2->update(
            data: [
                'id' => $feedback2->id,
                'type' => 'question',
                'id_user' => $this->user->id,
                'rating' => 5,
                'is_harmfull' => 0
            ]
        );

        $feedback2 = Feedback::findById(id: $feedback2->id);

        $this->assertEquals(
            expected: 5, actual: $feedback2->rating
        );
        $this->assertEquals(
            expected: 'question', actual: $feedback2->type
        );
    }

    public function test_destroying_feedback(): void
    {
        $feedback2 = new Feedback(params: [
            'type' => 'complaint',
            'id_user' => $this->user->id,
            'rating' => 3,
            'is_harmfull' => 1
        ]);
        $feedback2->save();
        $this->assertCount(expectedCount: 2, haystack: Feedback::all());
        $this->assertTrue(condition: $feedback2->destroy());
        $this->assertCount(expectedCount: 1, haystack: Feedback::all());
    }

    public function test_valid_feedback_type(): void
    {
        $feedback2 = new Feedback(params: [
            // 'type' => 'complaint',
            'id_user' => $this->user->id,
            'rating' => 3,
            'is_harmfull' => 1
        ]);

        $this->assertFalse(condition: $feedback2->isValid());
        $this->assertFalse(condition: $feedback2->save());
        $this->assertNotEmpty(actual: $feedback2->allErrors());
        $this->assertEquals(
            expected: 'não pode ser vazio!', actual: $feedback2->errors(
                index: 'type'
            )
        );
    }

    public function test_find_by_id_should_return_feedback(): void
    {
        $this->assertEquals(
            expected: Feedback::findById(id: $this->feedback->id)->id,
            actual: $this->feedback->id
        );
    }

    public function test_search_for_inexistent_id_should_return_null(): void
    {
        $this->assertNull(actual: $this->feedback->findById(id: 10));
    }
}