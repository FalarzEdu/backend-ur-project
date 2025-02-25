import AsyncRequest from "../Models/AsyncRequest.js";
import MoneyHelper from "../helpers/MoneyHelper.js";
import FlashMessage from "../Models/FlashMessage.js";

async function getGoodsData() 
{
    return await AsyncRequest.get("snackbar/prices");
}

interface GoodInterface {
    id: number,
    price: number,
    description: string
}

document.querySelector("#refresh-data")?.addEventListener(
"click", async () => 
    {
        try
        {
            FlashMessage.create(
                "Aguarde...",
                "success"
            );
            const goodsData = await getGoodsData();
            if (!goodsData) 
            {
                throw new Error("Error sending request");
            }
            goodsData.forEach((good: GoodInterface) => {
                const element = document.querySelector(`#snackbar-card-${good.id}`);

                if (element) 
                {
                    element.textContent = MoneyHelper.prepareToDisplay(
                        good.price
                    );
                } 
                else
                {
                    throw new Error(`Good card ID #${good.id} missing.`);
                }
            });
            FlashMessage.removeAll();
            FlashMessage.create(
                "Itens atualizados com sucesso!",
                "success"
            );
        }
        catch(error)
        {
            FlashMessage.create(
                "Houve um erro ao atualizar os itens. Tente novamente mais tarde!",
                "danger"
            );
            console.error(`Error updating data: ${error}`);
        }
    }
);