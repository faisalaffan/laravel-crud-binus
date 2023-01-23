import Http from "@/utils/Http"

const login = (payload) => {
    return Http.post('/login', payload)
}


const AuthLoginNetworkRepository = {
    login,
}

export default AuthLoginNetworkRepository