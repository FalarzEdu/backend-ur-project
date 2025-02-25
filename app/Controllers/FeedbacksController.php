<?php

namespace App\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackImage;
use App\Models\Image;
use App\Models\Message;
use Core\Constants\Constants;
use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Lib\FlashMessage;

class FeedbacksController extends Controller
{
    protected string $layout;
    /** @var array<string> $feedbackTypes */
    protected array $feedbackTypes = ['complaint', 'compliment', 'question', 'suggestion'];

    public function __construct()
    {
        $this->layout = $this->currentUseRole();
    }

    public function index(): void
    {
        $title = 'Avaliações registradas';
        $index_folder = $this->layout;

        if ($this->layout === 'admin') {
            $openFeedbacks = [];
        } else {
            $openFeedbacks = $this->currentUser()->feedbacks()->get();
        }

        $this->render(
            view: "feedbacks/$index_folder/index",
            data: compact(
                'title',
                'openFeedbacks'
            )
        );
    }

    public function new(): void
    {
        $title = 'Fazer uma avaliação';
        $feedbackTypes = $this->feedbackTypes;

        $this->render(
            view: 'feedbacks/user/new',
            data: compact('title', 'feedbackTypes')
        );
    }

    public function create(Request $request): void
    {
        $feedbackParams = $request->getParam(key: 'feedback');

        if (!empty($feedbackParams['rating'])) {
            $feedbackParams['rating'] = (int) $feedbackParams['rating'];
        }
        if (!empty($feedbackParams['is_harmfull'])) {
            $feedbackParams['is_harmfull'] = (int) $feedbackParams['is_harmfull'];
        } else {
            $feedbackParams['is_harmfull'] = 0;
        }

        $feedbackParams['id_user'] = $this->currentUser()->id;
        $feedback = new Feedback(params: $feedbackParams);

        if (!$feedback->save()) {
            FlashMessage::danger(value: 'Error creating feedback!');
            $this->redirectTo(location: Route(name: 'feedbacks'));
            throw new \Exception(message: 'Feedback could not be saved.');
        }
        $messageParams = $request->getParam(key: 'message');
        $messageParams['sender_type'] = $this->currentUseRole();
        $messageParams['feedback_id'] = $feedback->__get(property: 'id');
        $message = new Message(params: $messageParams);

        if (!$message->save()) {
            FlashMessage::danger(value: "Error creating feedback's message!");
            $this->redirectTo(location: Route(name: 'feedbacks'));
            throw new \Exception(message: 'Feedback could not be saved.');
        }

        for ($i = -1; !empty($_FILES['images']['name'][$i + 1]); $i++) {
            $imageInstance = new FeedbackImage(params:[
                'feedback_id' => $feedback->id
            ]);
            $imageInstance->addImage(
                imageTmpName: $_FILES['images']['tmp_name'][$i + 1],
                imageName: $_FILES['images']['name'][$i + 1],
                saveFolder: (string) "feedback_$feedback->id"
            );
        }

        FlashMessage::success(value: 'Feedback created successfully!');
        $this->redirectTo(location: Route(name: 'feedbacks'));
    }

    public function edit(Request $request): void
    {
        $params = $request->getParams();
        $feedback = $this->currentUser()->feedbacks()->findById($params['id']);
        $paramId = $request->getParam(key: 'id');
        $feedbackTypes = $this->feedbackTypes;

        $title = "Editar avaliação";
        $this->render(view: 'feedbacks/user/edit', data: compact('title', 'paramId', 'feedback', 'feedbackTypes'));
    }

    public function preview(Request $request): void
    {
        $params = $request->getParams();
        $feedbackId = $request->getParam(key: 'id');
        $feedback = $this->currentUser()->feedbacks()->findById($params['id']);

        // $feedbackTypes = $this->feedbackTypes;
        $images = Feedback::where(conditions: ['id' => $feedbackId])[0]
            ->images()
            ->get();

        $title = "Visualização";
        $this->render(
            view: 'feedbacks/user/preview',
            data: compact(
                'title',
                'feedback',
                'images'
            )
        );
    }

    public function update(Request $request): void
    {
        $id = $request->getParam('id');
        $params = $request->getParam('feedback');

        $feedback = $this->currentUser()->feedbacks()->findById($id);

        if ($feedback->update($params)) {
            FlashMessage::success('Problema atualizado com sucesso!');
            $this->redirectTo(location: Route(name: 'feedbacks'));
        } else {
            FlashMessage::success(value: 'Feedback created successfully!');
            $this->redirectTo(location: Route(name: 'feedbacks'));
        }
    }

    public function destroy(Request $request): void
    {
        $paramId = $request->getParam(key: 'id');
        $feedback = $this->currentUser()->feedbacks()->findById(id: $paramId);

        $imageInstance = new FeedbackImage(params: ['feedback_id' => $paramId]);
        $imageInstance->deleteImage($paramId);

        $feedback->destroy();

        if (!$feedback::findById($paramId)) {
            FlashMessage::success(value: 'Registro deletado com sucesso.');
            $this->redirectTo(location: Route(name: 'feedbacks'));
        }
    }
}
