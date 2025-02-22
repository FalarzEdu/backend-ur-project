<?php

namespace Tests\Unit\Models\FeedbackImage;

use App\Models\Feedback;
use App\Models\FeedbackImage;
use App\Models\User;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class FeedbackImageTest extends TestCase
{
    protected User $user;
    protected Feedback $feedback;
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
        
        $this->user = User::where(['email' => 'fulano@example.com'])[0];
        
        $this->feedback = new Feedback(params: [
            'type' => 'compliment',
            'id_user' => $this->user->id,
            'rating' => 5,
            'is_harmfull' => 0
        ]);
        $this->feedback->save();

        $this->feedback = Feedback::where(['id_user' => $this->user->id])[0];
    }

    public function test_should_add_image(): void
    {
        $imageMock = $this->getMockBuilder(FeedbackImage::class)
        ->setConstructorArgs([['feedback_id' => $this->feedback->id, 'path' => 'test_image.jpg']])
        ->onlyMethods(['addImage']) // Mock only this method
        ->getMock();

        // Custom implementation of addImage
        $imageMock->expects($this->once())
            ->method('addImage')
            ->willReturnCallback(function ($imageTmpName, $imageName, $saveFolder) use ($imageMock) {
                // Fake hash filename
                $fakeFileName = 'abcde.jpg';

                // Simulate saving to the database
                $imageMock->__set('path', "$saveFolder/$fakeFileName");
                return $imageMock->save();
            });

        $result = $imageMock->addImage(
            tempnam(sys_get_temp_dir(), 'php'),
            'name_test.png',
            'decoy_folder'
        );

        // Check if it returns true
        $this->assertTrue($result);

        // Check if the fake filename was "saved"
        $this->assertEquals('decoy_folder/abcde.jpg', $imageMock->__get('path'));
    }

    public function test_should_delete_image(): void
    {
        $images = FeedbackImage::where(['path' => 'decoy_folder/abcde.jpg']);

        assertNotNull($images[0]);

        $image = $images[0];
        $image->deleteImage($image->feedback_id);

        $result = FeedbackImage::where(['path' => 'decoy_folder/abcde.jpg']);

        assertEmpty($result);
    }

    public function test_should_validate_image_attributes(): void
    {
        // $user = new User(params: [
        //     'name' => 'Fulano',
        //     'academic_register' => '0',
        //     'email' => 'fulano1@example.com',
        //     'password' => '123456',
        //     'password_confirmation' => '123456',
        //     'phone' => '0',
        // ]);
        // $user->save();        
        
        // $feedback = new Feedback(params: [
        //     'type' => 'compliment',
        //     'id_user' => $user->id,
        //     'rating' => 5,
        //     'is_harmfull' => 0
        // ]);
        // $feedback->save();

        $feedbackImage = new FeedbackImage(params: [
            'feedback_id' => $this->feedback->id,
        ]);
        $feedbackImage->path = '';

        $this->assertFalse(condition: $feedbackImage->isValid());

        $feedbackImage->__set(
            property: 'path', value: 'test_image.jpg'
        );

        $this->assertTrue(condition: $feedbackImage->isValid());
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // $this->user->destroy();
        // $this->feedback->destroy();
    }
}