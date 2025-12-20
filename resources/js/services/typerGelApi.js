import axios from 'axios';

export function fetchTyperGelConfig(difficulty) {
  return axios.get('/api/user/typergel/config', {
    params: { difficulty }
  });
}

export function submitTyperGelResult(payload) {
  return axios.post('/api/user/typergel/result', payload);
}


