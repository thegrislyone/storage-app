import axios from 'axios';

const $axios = axios.create({
    withCredentials: true,
	baseURL: 'http://api.storage-app.local'
});

export default $axios;
