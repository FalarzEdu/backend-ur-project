var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var _a;
import AsyncRequest from "../Models/AsyncRequest.js";
import MoneyHelper from "../helpers/MoneyHelper.js";
import FlashMessage from "../Models/FlashMessage.js";
function getGoodsData() {
    return __awaiter(this, void 0, void 0, function* () {
        return yield AsyncRequest.get("snackbar/prices");
    });
}
(_a = document.querySelector("#refresh-data")) === null || _a === void 0 ? void 0 : _a.addEventListener("click", () => __awaiter(void 0, void 0, void 0, function* () {
    try {
        FlashMessage.create("Aguarde...", "success");
        const goodsData = yield getGoodsData();
        if (!goodsData) {
            throw new Error("Error sending request");
        }
        goodsData.forEach((good) => {
            const element = document.querySelector(`#snackbar-card-${good.id}`);
            if (element) {
                element.textContent = MoneyHelper.prepareToDisplay(good.price);
            }
            else {
                throw new Error(`Good card ID #${good.id} missing.`);
            }
        });
        FlashMessage.removeAll();
        FlashMessage.create("Itens atualizados com sucesso!", "success");
    }
    catch (error) {
        FlashMessage.create("Houve um erro ao atualizar os itens. Tente novamente mais tarde!", "danger");
        console.error(`Error updating data: ${error}`);
    }
}));
//# sourceMappingURL=snackbar.js.map