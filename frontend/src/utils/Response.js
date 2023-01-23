/**
 * @createdAt: 2022/08/07
 * @author: @FaisalAffan <faisallionel@gmail.com>
 */
export class ResponseStruct {
  constructor() {
    this.code = 200
    this.success = false
    this.message = ''
    this.data = []
    this.error = []
    this.pagination = null
  }
}

export const ResponseTimeout = () => {
  const response = new ResponseStruct()
  response.code = 400
  response.success = false
  response.message = 'Timeout Get Request Kelamaan From Frontend'
  response.data = null
  response.error = []
  response.pagination = null
  return response
}
