export default class MoneyHelper
{
    public static prepareToDisplay(value: number): string {
        let stringValue: string = Number(value).toFixed(2).replace(".", ",");
        return `R$ ${stringValue}`;
    }
}