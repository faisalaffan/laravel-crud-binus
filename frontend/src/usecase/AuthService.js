import AuthLoginNetworkRepository from "@/repositories/network/AuthLoginNetworkRepository"

const login = (payload) => {
    return AuthLoginNetworkRepository.login(payload)
}


const AuthService = {
    login,
}

export default AuthService