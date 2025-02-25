<?php

namespace App\Controllers;

use App\Helpers\PriceFormatHelper;
use App\Models\SnackbarGood;
use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Lib\FlashMessage;

class SnackbarGoodsController extends Controller
{
    protected string $layout;

    public function __construct()
    {
        $this->layout = $this->currentUseRole();
    }

    public function index(): void
    {
        $title = 'Cantina';
        $index_folder = $this->layout;

        $goods = SnackbarGood::all();

        $this->render(
            view: "snackbar/$index_folder/index",
            data: compact(
                'title',
                'goods'
            )
        );
    }

    public function new(): void
    {
        $title = 'Adicionar novo item';

        $this->render(
            'snackbar/admin/new',
            compact('title')
        );
    }

    public function create(Request $request): void
    {
        $snackBarParams = $request->getParam(key: 'snackbar_good');

        $snackBarParams['price'] = PriceFormatHelper::prepareToDb(
            price: $snackBarParams['price']
        );
        $snackbar_good = new SnackbarGood(params: $snackBarParams);
        if ($snackbar_good->save()) {
            FlashMessage::success(
                'Item criado com sucesso!'
            );
        } else {
            FlashMessage::danger(
                'Não foi possível criar este item. Tente novamente mais tarde!'
            );
        };
        $this->redirectTo(location: Route(name: 'snackbar'));
    }

    public function edit(Request $request): void
    {
        $paramId = $request->getParam(key: 'id');
        $snackbarGood = SnackbarGood::findById(id: (int) $paramId);

        $title = 'Editar Item da Cantina';

        $this->render(
            'snackbar/admin/edit',
            compact('title', 'snackbarGood')
        );
    }

    public function update(Request $request): void
    {
        $paramId = $request->getParam(key: 'id');
        $snackBarParams = $request->getParam(key: 'snackbar_good');

        $snackBarParams['price'] = PriceFormatHelper::prepareToDb(
            price: $snackBarParams['price']
        );

        $snackbarGood = SnackbarGood::findById(id: (int) $paramId);
        if ($snackbarGood->update(data: $snackBarParams)) {
            FlashMessage::success(
                value: 'Item atualizado com sucesso!'
            );
        } else {
            FlashMessage::danger(
                value: 'Erro ao atualizar item. Tente novamente mais tarde!'
            );
        }
        $this->redirectTo(
            location: Route(name: 'snackbar')
        );
    }

    public function destroy(Request $request): void
    {
        $paramId = $request->getParam(key: 'id');

        $snackbarGood = SnackbarGood::findById(id: $paramId);

        if ($snackbarGood->destroy()) {
            FlashMessage::success(
                value: 'Item removido com sucesso!'
            );
        } else {
            FlashMessage::danger(
                value: 'Erro ao remover item. Tente novamente mais tarde!'
            );
        }
        $this->redirectTo(
            location: Route(name: 'snackbar')
        );
    }
}
