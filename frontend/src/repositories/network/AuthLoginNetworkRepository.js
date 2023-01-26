import Http from "@/utils/Http";

const login = (payload) => {
  return Http.post("/auth/login", payload);
};

const register = (payload) => {
  return Http.post("/auth/register", payload);
};

const forgotPassword = (payload) => {
  return Http.post("/auth/reset-password", payload);
};

const AuthLoginNetworkRepository = {
  login,
  register,
  forgotPassword,
};

export default AuthLoginNetworkRepository;
