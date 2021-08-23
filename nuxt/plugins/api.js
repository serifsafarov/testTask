export default ({app, $axios, $nuxt, $auth, redirect}, inject) => {
  const api = async function (type, path, params = {}) {
    return new Promise((resolve, reject) => {
      $axios({
        method: type,
        url: path,
        data: params,
        params: type.toLowerCase() === 'get' ? params : {},
      }).then((res) => {
        if (res.data.errors) {
          reject(res.data.errors)
        } else {
          resolve(res.data)
        }
      }).catch((error) => {
        if (error.response && [419].indexOf(error.response.status) !== -1) {
          this.$auth.logout().then(res => {
            redirect('/auth/login')
          });
        } else {
          if (error.response && error.response.data && error.response.data.errors) {
            reject(error.response.data.errors)
          } else if(error.response.data.message){
            reject({
              main: [
                error.response.data.message
              ]
            })
          } else {
            reject({
              main: [
                error.response.statusText
              ]
            })
          }
        }
      })
    })
  }
  inject('api', api)
}
