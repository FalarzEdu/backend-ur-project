<?php

namespace App\Controllers;

use App\Models\BuffetReservation;
use App\Models\Meal;
use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Exception;
use Lib\FlashMessage;

class BuffetReservationsController extends Controller
{
    protected string $layout = 'user';

    public function index(): void
    {
        $title = 'Refeições';

        $mealIds = Meal::getTodayMealsId();
        $lunchReservation = $this->verifyReservation(mealId: $mealIds['lunchId']);
        $dinnerReservation = $this->verifyReservation(mealId: $mealIds['dinnerId']);

        $this->render(view: 'reservations/index', data: compact('title', 'mealIds', 'lunchReservation', 'dinnerReservation'));
    }
    public function confirmReserve(Request $request): void
    {
        try {
            if (!$request->getParam(key: 'mealId')) {
                throw new Exception(message: 'Meal ID can not be empty!');
            }

            $mealId = (int) $request->getParam(key: 'mealId');
            $userId = $this->currentUser()->id;

            if ($reservation = $this->verifyReservation(mealId: $mealId)) {
                FlashMessage::danger(value: 'Você já confirmou sua presença nesta refeição!');
                $this->redirectBack();
                return;
            }

            $reservation = new BuffetReservation(params: [
                'user_id' => $userId,
                'meal_id' => $mealId,
                'has_assistance' => 0
            ]);

            $reservation->save();
            FlashMessage::success('Confirmação realizada com sucesso!');
            $this->redirectBack();

            return;
        } catch (Exception $e) {
            error_log(
                message: "Error making a buffet reservation: " . $e->getMessage()
            );
            FlashMessage::danger('Ocorreu um erro ao processar esta operação. Tente novamente mais tarde!');
            $this->redirectBack();
            return;
        }
    }

    public function disconfirmReserve(Request $request): void
    {
        try {
            if (!$request->getParam(key: 'mealId')) {
                throw new Exception(message: 'Meal ID can not be empty!');
            }

            $mealId = (int) $request->getParam(key: 'mealId');

            if ($reservation = $this->verifyReservation(mealId: $mealId)) {
                FlashMessage::success(value: 'Sucesso ao desconfirmar presença.');
                $reservation[0]->destroy();
                $this->redirectBack();
                return;
            }

            FlashMessage::danger(value: 'Você já desconfirmou sua presença nesta refeição!');
            $this->redirectBack();
            return;
        } catch (Exception $e) {
            error_log(
                message: "Error making a buffet reservation: " . $e->getMessage()
            );
            FlashMessage::danger('Ocorreu um erro ao processar esta operação. Tente novamente mais tarde!');
            $this->redirectBack();
            return;
        }
    }

    /**
     * Verifies if there is a reservation on a specific meal to the current user.
     * @param int $mealId
     * @return bool|BuffetReservation[]
     */
    private function verifyReservation($mealId): bool | array
    {
        if (
            $reservation = BuffetReservation::where(conditions: [
            'user_id' => $this->currentUser()->id,
            'meal_id' => $mealId
            ])
        ) {
            return $reservation;
        }

        return false;
    }
}
