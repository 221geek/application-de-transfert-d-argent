import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { User } from '../models/user';
import { Role } from '../models/role';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class RequestService {

  constructor(private httpClient: HttpClient) { }

  getUsers() {
    return this.httpClient.get<User>(`${environment.backendUrl}/api/users`)
  }

  getUser(id: number) {
    return this.httpClient.get<User>(`${environment.backendUrl}/api/users/`+id)
  }

  getRoles() {
    return this.httpClient.get<Role>(`${environment.backendUrl}/api/roles`)
  }

  addUser(user: User) {
    return this.httpClient.post<User>(`${environment.backendUrl}/api/users`, user)
  }

  editUser(user: User, id: number) {
    return this.httpClient.put<User>(`${environment.backendUrl}/api/users/`+id, user)
  }

  deleteUser(id: number) {
    return this.httpClient.delete<User>(`${environment.backendUrl}/api/users/`+id)
  }
}