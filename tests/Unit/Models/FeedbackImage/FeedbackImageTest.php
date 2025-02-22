<?php

namespace Tests\Unit\Models\FeedbackImage;

use App\Models\Feedback;
use App\Models\FeedbackImage;
use App\Models\User;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class FeedbackImageTest extends TestCase
{
    private User $user;
    private Feedback $feedback;
    private FeedbackImage $feedbackImage;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = new User(params: [
            'name' => 'Fulano',
            'academic_register' => '0',
            'email' => 'fulano111111111@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'phone' => '0',
        ]);
        $this->user->save();

        $this->feedback = new Feedback(params: [
            'type' => 'complaint',
            'id_user' => $this->user->id,
            'rating' => 5,
            'is_harmfull' => 0
        ]);

        $this->feedback->save();

        $this->feedbackImage = new FeedbackImage(params: [
            'feedback_id' => $this->feedback->id,
            'path' => 'test_image.jpg'
        ]);
    }

    // public function test_should_add_image(): void
    // {
    //     // $image = $this->getMockBuilder(className: FeedbackImage::class)    
    //     //     ->setConstructorArgs(arguments: [[
    //     //         'feedback_id' => 1, 'path' => 'test_image.jpg'
    //     //     ]])
    //     //     ->onlyMethods(['addImage'])
    //     //     ->getMock();

    //     // $image->expects($this->once())
    //     //         ->method('addImage')
    //     //         ->willReturn(true);
        
    //     // $return = $image->addImage(
    //     //     imageTmpName: tempnam(directory: sys_get_temp_dir(), prefix: 'Tux'),
    //     //     imageName: 'test_image.jpg',
    //     //     saveFolder: 'feedback_1'
    //     // );
    //     // $this->assertTrue(condition: $return);

    //     $image = FeedbackImage::where(conditions: ['feedback_id' => 1]);
    //     dd($image);

    //     assertEquals(expected: 'test_image.jpg', actual: $image[0]->path);

    // }

    // public function test_should_delete_image(): void
    // {
    //     $this->feedbackImage->path = null;

    //     $this->assertNull(actual: $this->feedbackImage->path);
    // }

    public function test_should_validate_image_attributes(): void
    {
        $this->feedbackImage->path = '';
        $this->assertFalse(condition: $this->feedbackImage->isValid());

        $this->feedbackImage->__set(
            property: 'path', value: 'test_image.jpg'
        );
        $this->feedbackImage->__set(
            property: 'feedback_id', value: 1
        );

        $this->assertTrue(condition: $this->feedbackImage->isValid());
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}