var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
export default class AsyncRequest {
    static get(url) {
        return __awaiter(this, void 0, void 0, function* () {
            try {
                const PROTOCOL = window.location.protocol;
                const HOST = window.location.host;
                const response = yield fetch(`${PROTOCOL}//${HOST}/${url}`);
                const data = yield response.json();
                if (data.success) {
                    return data.data;
                }
                else {
                    throw new Error(data.error);
                }
            }
            catch (error) {
                console.error("Async request error: " + error);
                return null;
            }
        });
    }
}
//# sourceMappingURL=AsyncRequest.js.map