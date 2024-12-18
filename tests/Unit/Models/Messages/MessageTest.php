<?php

use App\Models\Feedback;
use App\Models\Message;
use App\Models\User;
use Tests\TestCase;

class MessageTest extends TestCase
{
    private $user;
    private $feedback;
    private $message;

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

        $this->message = new Message(params: [
            'feedback_id' => $this->feedback->id,
            'content' => 'Feedback mock content',
            'sender_type' => 'user',
        ]);
        $this->message->save();
    }

    public function test_should_create_message(): void
    {
        $this->assertTrue(condition: $this->message->save());
        $this->assertCount(expectedCount: 1, haystack: Message::all());
    }

    public function test_should_retrieve_all_messages(): void
    {
        $message2 = $this->feedback->messages()->new(params: [
            'feedback_id' => $this->feedback->id,
            'content' => 'Feedback mock content',
            'sender_type' => 'user',
        ]);
        $message2->save();

        $this->assertCount(expectedCount: 2, haystack: Message::all());
    }

    public function test_should_update_message(): void
    {
        $message2 = $this->feedback->messages()->new(params: [
            'feedback_id' => $this->feedback->id,
            'content' => 'Feedback mock content',
            'sender_type' => 'user',
        ]);
        $message2->save();

        $this->assertEquals(
            expected: 'Feedback mock content', actual: $message2->content
        );
        
        $this->assertTrue(
            condition: $message2->update(
                data: ['content' => 'New mock content']
            )
        );

        $message2 = Message::findById(id: $message2->id);

        $this->assertEquals(
            expected: 'New mock content', actual: $message2->content
        );
    }

    public function test_destroying_message(): void
    {
        $message2 = new Message(params: [
            'feedback_id' => $this->feedback->id,
            'content' => 'Feedback mock content',
            'sender_type' => 'user',
        ]);
        $message2->save();
        $this->assertCount(expectedCount: 2, haystack: Message::all());
        $this->assertTrue(condition: $message2->destroy());
        $this->assertCount(expectedCount: 1, haystack: Message::all());
    }

    public function test_valididating_incorrect_message(): void
    {
        $message2 = new Message(params: [
            'feedback_id' => null, // Does not exists
            'sender_type' => null,
        ]);

        $this->assertFalse(condition: $message2->isValid());
        $this->assertFalse(condition: $message2->save());
        $this->assertNotEmpty(actual: $message2->allErrors());
        $this->assertEquals(
            expected: 'não pode ser vazio!', actual: $message2->errors(
                index: 'feedback_id'
            )
        );
        $this->assertEquals(
            expected: 'não pode ser vazio!', actual: $message2->errors(
                index: 'sender_type'
            )
        );
    }

    public function test_find_by_id_should_return_message(): void
    {
        $this->assertEquals(
            expected: Message::findById(id: $this->message->id)->id,
            actual: $this->message->id
        );
    }

    public function test_search_for_inexistent_id_should_return_null(): void
    {
        $this->assertNull(actual: $this->message->findById(id: 10));
    }
}