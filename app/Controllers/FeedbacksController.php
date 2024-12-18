<?php

namespace App\Controllers;

use App\Models\Feedback;
use App\Models\Message;
use Core\Http\Controllers\Controller;
use Core\Constants\Constants;
use Core\Debug\Debugger;
use Core\Http\Request;
use Core\Router\Route;
use Lib\FlashMessage;

class FeedbacksController extends Controller
{
    protected string $layout;

    public function __construct()
    {
        $this->layout = $this->currentUseRole();
    }

    public function index(): void
    {
        $title = 'Feedbacks registrados';
        $index_folder = $this->layout;

        if ($this->layout === 'admin') {
            $openFeedbacks = [];
        } else {
            $openFeedbacks = $this->currentUser()->feedbacks()->get();
        }

        $this->render(
            "feedbacks/$index_folder/index",
            data: compact('title', 'openFeedbacks')
        );
    }

    public function new(): void
    {
        $title = 'Criar um feedback';

        $this->render(view:'feedbacks/user/new', data: compact(var_name: 'title'));
    }

    public function create(Request $request): void
    {
        $feedbackParams = $request->getParam(key: 'feedback');

        if (!empty($feedbackParams['rating'])) {
            $feedbackParams['rating'] = (int) $feedbackParams['rating'];
        }
        $feedbackParams['is_harmfull'] = (int) $feedbackParams['is_harmfull'];
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
        } else {
            FlashMessage::success(value: 'Feedback created successfully!');
            $this->redirectTo(location: Route(name: 'feedbacks'));
        }
    }

    public function edit(Request $request): void
    {
        $params = $request->getParams();
        $feedback = $this->currentUser()->feedbacks()->findById($params['id']);
        $paramId = $request->getParam(key: 'id');

        $title = "Editar feedback #{$paramId}";
        $this->render(view: 'feedbacks/user/edit', data: compact('title', 'paramId', 'feedback'));
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
        $feedback->destroy();

        if (!$feedback::findById($paramId)) {
            FlashMessage::success(value:'Registro deletado com sucesso.');
            $this->redirectTo(location: Route(name: 'feedbacks'));
        }
    }
}
