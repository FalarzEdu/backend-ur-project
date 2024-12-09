<?php

namespace App\Controllers;

use App\Models\Feedback;
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
        $this->layout = $this->current_user_role();
    }

    public function index(): void
    {
        $this->render(view: 'index');
    }

    public function new(): void
    {
        $title = 'Criar um feedback';

        $this->render(view:'new', data: compact(var_name: 'title'));
    }

    public function create(Request $request): void
    {
        $params = $request->getParam(key: 'feedback');

        if (!empty($params['rating'])) {
            $params['rating'] = (int) $params['rating'];
        }
        $params['is_harmfull'] = (int) $params['is_harmfull'];
        $params['id_user'] = $this->current_user()->id;

        $feedback = new Feedback(params: $params);

        if ($feedback->save()) {
            FlashMessage::success(value: 'Feedback criado com sucesso!');
            $this->redirectTo(location: Route(name: 'feedbacks'));
        } else {
            FlashMessage::danger(value: 'Erro ao criar feedback!');
            $this->redirectTo(location: Route(name: 'user.feedbacks.new'));
        }
    }

    protected function render(string $view, array $data = []): void
    {
        extract(array: $data);

        $view = Constants::rootPath()->join(
            path: "app/views/feedbacks/$view.phtml"
        );
        require Constants::rootPath()->join(
            path: "app/views/layouts/$this->layout.phtml"
        );
    }

}
