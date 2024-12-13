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
    private string $index_folder;

    public function __construct()
    {
        $this->layout = $this->current_user_role();
        $this->index_folder = $this->current_user_role();
    }

    public function index(): void
    {
        $openFeedbacks = $this->current_user()->feedbacks()->get();
        $title = 'Feedbacks registrados';

        $this->render(view: "feedbacks/$this->index_folder/index", data: compact(  'title', 'openFeedbacks'));
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
        $feedbackParams['id_user'] = $this->current_user()->id;
        $feedback = new Feedback(params: $feedbackParams);

        if (!$feedback->save()) {
            FlashMessage::danger(value: 'Error creating feedback!');
            $this->redirectTo(location: Route(name: 'feedbacks'));
            throw new \Exception(message: 'Feedback could not be saved.');
        }
        $messageParams = $request->getParam(key: 'message');
        $messageParams['sender_type'] = $this->current_user_role();
        $messageParams['feedback_id'] = $feedback->__get(property: 'id');
        $message = new Message(params: $messageParams);

        if (!$message->save()) {
            FlashMessage::danger(value: "Error creating feedback's message!");
            $this->redirectTo(location: Route(name: 'feedbacks'));
            throw new \Exception(message: 'Feedback could not be saved.');
        }
        else {
            FlashMessage::success(value: 'Feedback created successfully!');
            $this->redirectTo(location: Route(name: 'feedbacks'));
        }
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
