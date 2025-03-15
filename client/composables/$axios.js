import axios from 'axios';

const $axios = axios.create({
	baseURL: 'http://api.storage-app.local/api'
});

export default $axios;