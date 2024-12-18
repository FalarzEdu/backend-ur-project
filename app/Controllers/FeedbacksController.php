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
        $this->layout = $this->currentUserRole();
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

        $this->render(view:'feedbacks/new', data: compact(var_name: 'title'));
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
        $messageParams['sender_type'] = $this->currentUserRole();
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

    public function destroy(Request $request): void
    {
        $paramId = $request->getParam(key: 'id');
        $feedback = $this
                        ->currentUser()
                        ->feedbacks()
                        ->findById(id: $paramId);
        if ($paramId) {
            $feedback = $this
                        ->currentUser()
                        ->feedbacks()
                        ->findById(id: $paramId);
        } else {
            FlashMessage::danger(
                value:'O registro não foi encontrado.'
            );
        }

        if ($feedback) {
            $feedback->destroy();

            if (!$feedback::findById(id: $paramId)) {
                FlashMessage::success(value:'Registro deletado com sucesso.');
            } else {
                FlashMessage::danger(
                    value:'Um erro ocorreu na tentativa de deletar este registro. Tente novamente!'
                );
            }
        } else {
            FlashMessage::danger(
                value:'O registro não foi encontrado.'
            );
        }

        $this->redirectTo(location: Route(name: 'feedbacks'));
    }

    // protected function render(string $view, array $data = []): void
    // {
    //     extract(array: $data);

    //     $view = Constants::rootPath()->join(
    //         path: "app/views/feedbacks/$view.phtml"
    //     );
    //     require Constants::rootPath()->join(
    //         path: "app/views/layouts/$this->layout.phtml"
    //     );
    // }
}
