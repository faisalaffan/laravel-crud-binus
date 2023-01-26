/**
 * @createdAt: 2022/08/07
 * @author: @FaisalAffan <faisallionel@gmail.com>
 */

import axios from 'axios'
import Cookies from 'js-cookie'
import { ResponseStruct, ResponseTimeout } from './Response'

const TIMEOUT = process.env.TIMEOUT_API
const API_HOST = process.env.API_URL || 'http://localhost:8000/api/v1'

const redirectHome = () => {
  Cookies.remove('token')
  Cookies.remove('user_login')
}

const refreshToken = () => {
  const url = process.env.URL_REFRESH_TOKEN || '/auth/refresh-token'
  const token = Cookies.get('token')
  // const token = process.env.HARDCODE_TOKEN
  if (token !== undefined) {
    const payload = {
      token,
    }
    return axios({
      url,
      method: 'POST',
      baseURL: API_HOST,
      headers: {
        common: {
          Accept: 'application/json',
        },
        Authorization: 'Bearer ' + token,
      },
      data: payload,
      transformResponse: (data) => {
        data = JSON.parse(data)
        const response = new ResponseStruct()
        response.code = data.code
        response.success = data.success
        response.message = data.message
        response.data = data.data
        response.error = data.error
        response.pagination = data.pagination

        return response
      },
      timeout: TIMEOUT,
    })
      .then((res) => {
        Cookies.set('token', res?.data?.data?.refresh_token)
        Cookies.set('token', res?.data?.data?.refresh_token)
      })
      .catch((err) => {
        if (err?.response?.status === 401) {
          redirectHome()
        }
        if (err.code === 'ECONNABORTED') {
          return ResponseTimeout()
        }
        return err.response.data
      })
  } else {
    window.location.replace('/auth/login')
  }
}

const get = (url, withRefreshToken = false) => {
  const token = Cookies.get('token')
  // const token = process.env.HARDCODE_TOKEN

  return axios({
    url,
    method: 'GET',
    baseURL: API_HOST,
    headers: {
      common: {
        Accept: 'application/json',
      },
      Authorization: 'Bearer ' + token,
    },
    transformResponse: (data) => {
      data = JSON.parse(data)
      const response = new ResponseStruct()
      response.code = data.code
      response.success = data.success
      response.message = data.message
      response.data = data.data
      response.error = data.error
      response.pagination = data.pagination

      return response
    },
    timeout: TIMEOUT,
  })
    .then(async (res) => {
      if (withRefreshToken) {
        await refreshToken()
      }
      return res.data
    })
    .catch((err) => {
      if (err?.response?.status === 401) {
        redirectHome()
      }
      if (err.code === 'ECONNABORTED') {
        return ResponseTimeout()
      }
      return err.response.data
    })
}

const post = (url, payload, withRefreshToken = false) => {
  const token = Cookies.get('token')
  // const token = process.env.HARDCODE_TOKEN

  return axios({
    url,
    method: 'POST',
    baseURL: API_HOST,
    headers: {
      common: {
        Accept: 'application/json',
      },
      Authorization: 'Bearer ' + token,
    },
    data: payload,
    transformResponse: (data) => {
      data = JSON.parse(data)
      const response = new ResponseStruct()
      response.code = data.code
      response.success = data.success
      response.message = data.message
      response.data = data.data
      response.error = data.error
      response.pagination = data.pagination

      return response
    },
    timeout: TIMEOUT,
  })
    .then(async (res) => {
      if (withRefreshToken) {
        await refreshToken()
      }
      return res.data
    })
    .catch((err) => {
      if (err?.response?.status === 401) {
        redirectHome()
      }
      if (err.code === 'ECONNABORTED') {
        return ResponseTimeout()
      }
      return err.response.data
    })
}

const put = (url, payload, withRefreshToken) => {
  const token = Cookies.get('token')
  // const token = process.env.HARDCODE_TOKEN

  return axios({
    url,
    method: 'PUT',
    baseURL: API_HOST,
    headers: {
      common: {
        Accept: 'application/json',
      },
      Authorization: 'Bearer ' + token,
    },
    data: payload,
    transformResponse: (data) => {
      data = JSON.parse(data)
      const response = new ResponseStruct()
      response.code = data.code
      response.success = data.success
      response.message = data.message
      response.data = data.data
      response.error = data.error
      response.pagination = data.pagination

      return response
    },
    timeout: TIMEOUT,
  })
    .then(async (res) => {
      if (withRefreshToken) {
        await refreshToken()
      }
      return res.data
    })
    .catch((err) => {
      if (err?.response?.status) {
        redirectHome()
      }
      if (err.code === 'ECONNABORTED') {
        return ResponseTimeout()
      }
      return err.response.data
    })
}

const del = (url, withRefreshToken) => {
  const token = Cookies.get('token')

  return axios({
    url,
    method: 'DELETE',
    baseURL: API_HOST,
    headers: {
      common: {
        Accept: 'application/json',
      },
      Authorization: 'Bearer ' + token,
    },
    transformResponse: (data) => {
      data = JSON.parse(data)
      const response = new ResponseStruct()
      response.code = data.code
      response.success = data.success
      response.message = data.message
      response.data = data.data
      response.error = data.error
      response.pagination = data.pagination

      return response
    },
    timeout: TIMEOUT,
  })
    .then(async (res) => {
      if (withRefreshToken) {
        await refreshToken()
      }
      return res.data
    })
    .catch((err) => {
      if (err?.response?.status) {
        redirectHome()
      }
      if (err.code === 'ECONNABORTED') {
        return ResponseTimeout()
      }
      return err.response.data
    })
}

const Http = { get, post, put, del }

export default Http
