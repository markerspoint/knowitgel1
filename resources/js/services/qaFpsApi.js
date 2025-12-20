import axios from 'axios';

export function fetchQAFPSQuestions(difficulty) {
  return axios.get('/api/user/qa-fps/questions', {
    params: { difficulty }
  });
}

export function submitQAFPSResult(score) {
  return axios.post('/api/user/qa-fps/result', { score });
}


