export default class AsyncRequest
{
    public static async get(url: string)
    {
        try
        {
            const PROTOCOL: string = window.location.protocol;
            const HOST: string = window.location.host;

            const response = await fetch(
                `${PROTOCOL}//${HOST}/${url}`
            );
            const data = await response.json();

            if (data.success) {
                return data.data;
            } 
            else 
            {
                throw new Error(data.error);
            }
        }
        catch(error)
        {
            console.error("Async request error: " + error);
            return null;
        }
    }
}