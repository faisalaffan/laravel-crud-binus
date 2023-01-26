import AuthLoginNetworkRepository from "@/repositories/network/AuthLoginNetworkRepository";

const login = (payload) => {
  return AuthLoginNetworkRepository.login(payload);
};

const register = (payload) => {
  return AuthLoginNetworkRepository.register(payload);
};

const forgotPassword = (payload) => {
  return AuthLoginNetworkRepository.forgotPassword(payload);
};

const AuthService = {
  login,
  register,
  forgotPassword,
};

export default AuthService;
