<?php

namespace Tests\Unit\Models\FeedbackImage;

use App\Models\Feedback;
use App\Models\FeedbackImage;
use App\Models\User;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
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
        ->onlyMethods(['addImage'])
        ->getMock();

        $imageMock->expects($this->once())
            ->method('addImage')
            ->willReturnCallback(function ($imageTmpName, $imageName, $saveFolder) use ($imageMock) {
                $fakeFileName = 'abcde.jpg';

                $imageMock->__set('path', "$saveFolder/$fakeFileName");
                return $imageMock->save();
            });

        $result = $imageMock->addImage(
            tempnam(sys_get_temp_dir(), 'php'),
            'name_test.png',
            'decoy_folder'
        );

        $this->assertTrue($result);

        $this->assertEquals('decoy_folder/abcde.jpg', $imageMock->__get('path'));
    }

    public function test_should_return_all_images_of_a_feedback(): void
    {
        $imageMock = $this->getMockBuilder(FeedbackImage::class)
        ->setConstructorArgs([['feedback_id' => $this->feedback->id, 'path' => 'test_image.jpg']])
        ->onlyMethods(['addImage'])
        ->getMock();

        $imageMock->expects($this->once())
            ->method('addImage')
            ->willReturnCallback(function ($imageTmpName, $imageName, $saveFolder) use ($imageMock) {
                $fakeFileName = 'abcde.jpg';

                $imageMock->__set('path', "$saveFolder/$fakeFileName");
                return $imageMock->save();
            });

        $result = $imageMock->addImage(
            tempnam(sys_get_temp_dir(), 'php'),
            'name_test.png',
            'decoy_folder'
        );

        $imageCount = $this->feedback->images()->get();

        assertCount(expectedCount: 2, haystack: $imageCount);
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
        $feedbackImage = new FeedbackImage(params: [
            'feedback_id' => $this->feedback->id,
        ]);
        $feedbackImage->__set('path', '');

        $this->assertFalse(condition: $feedbackImage->isValid());

        $feedbackImage->__set(
            property: 'path',
            value: 'test_image.jpg'
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
