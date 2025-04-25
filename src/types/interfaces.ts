export interface User {
  email: string;
  password: string;
}

export interface Compliant {
  message: string;
  status: "approved" | "rejected";
}
