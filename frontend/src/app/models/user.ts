export interface User {
    firstname?: string;
    lastname?: string;
    email?: string;
    username?: string;
    password: string;
    phone?: string;
    token?: string;
    role?: string;
    isActive?: boolean;
    roles?: string;
}