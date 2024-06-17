import axios from 'axios';

const BASE_URL = 'http://localhost:80/api';

export const apiService = {
    async createLink(data) {

        const requestData = {
            'url': data.url,
        };

        try {
            const response = await axios.post(`${BASE_URL}/links`, requestData);
            return response.data;
        } catch (error) {
            throw new Error(error.response.data.message);
        }
    },
};
