import axios from 'axios';

const $axios = axios.create({
	baseURL: 'http://api.storage-app.local'
});

export default $axios;