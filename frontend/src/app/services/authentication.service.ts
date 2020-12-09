import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { User } from 'src/app/models/user';
import { BehaviorSubject, Observable, from, pipe } from 'rxjs';
import { map } from 'rxjs/operators';
import * as jwt_decode from "jwt-decode";

@Injectable({
  providedIn: 'root'
})

export class AuthenticationService {

  private currentUser: any;
  private currentUserSubject: BehaviorSubject<User>;

  constructor(private httpClient: HttpClient) {
    this.currentUserSubject = new BehaviorSubject<User>(JSON.parse(localStorage.getItem('currentUser')));
  }

  public get currentUserValue() {
    return this.currentUserSubject.value
  }

  login(user: any) {
    return this.httpClient.post<User>(`${environment.backendUrl}/login_check`, user)
    .pipe(map(user => {
      localStorage.setItem('currentUser', JSON.stringify(user));
      this.currentUserSubject.next(user);
      return user;
    }));
  }

  getCurrentUser() {
    this.currentUser = jwt_decode(localStorage.getItem('currentUser'));
    return this.currentUser;
  }

  logout() {
    localStorage.removeItem('currentUser');
    this.currentUserSubject.next(null);
  }
}
