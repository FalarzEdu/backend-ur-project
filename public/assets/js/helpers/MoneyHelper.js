export default class MoneyHelper {
    static prepareToDisplay(value) {
        let stringValue = Number(value).toFixed(2).replace(".", ",");
        return `R$ ${stringValue}`;
    }
}
//# sourceMappingURL=MoneyHelper.js.map