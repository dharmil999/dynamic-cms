import axios from 'axios'

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // Replace with your actual backend URL
})

export const fetchPages = async () => {
  const response = await api.get('/pages')

  console.log('response',response);
  return response.data.data
}

export const createPage = async (pageData) => {
  const response = await api.post('/pages', pageData)
  return response.data.data
}

export const updatePage = async (pageId, pageData) => {
  const response = await api.put(`/pages/${pageId}`, pageData)
  return response.data.data
}

export const deletePage = async (pageId) => {
  const response = await api.delete(`/pages/${pageId}`)
  return response.data.data
}

export const fetchPageBySlug = async (slugPath) => {
  const response = await api.get(`/pages/${slugPath}`)
  return response.data.data
}

export default api
