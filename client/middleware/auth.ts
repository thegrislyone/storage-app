import { type RawAxiosRequestHeaders } from "axios";

export default defineNuxtRouteMiddleware(async (to, from) => {

    const cookie = useRequestHeader('cookie') as string;
    const headers = {
        "Cookie": cookie
    } as RawAxiosRequestHeaders;

    const { data: authCheckData } = await $axios.get('/auth/check', { headers });

    const isAuthorized = authCheckData.data?.is_authorized;

    if (!isAuthorized)
        return navigateTo('/auth');

    return;

})