import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './pages/login/login.component';
import { MaterialModule } from './material/material.module';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { ReactiveFormsModule } from '@angular/forms';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { JwtInterceptor } from './helpers/jwt-interceptor.service';
import { ErrorInterceptor } from './helpers/error.interceptor';
import { HomeComponent } from './pages/home/home.component';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { ContentComponent } from './components/content/content.component';
import { UsersComponent } from './pages/users/users.component';
import { TransfertComponent } from './pages/transfert/transfert.component';
import { AccountComponent } from './pages/account/account.component';
import { AddAccountComponent } from './pages/add-account/add-account.component';
import { AccountsComponent } from './pages/accounts/accounts.component';
import { RouterModule } from '@angular/router';
import { AddUserComponent } from './pages/add-user/add-user.component';
import { UserComponent } from './pages/user/user.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    HomeComponent,
    ContentComponent,
    UsersComponent,
    TransfertComponent,
    AccountComponent,
    AddAccountComponent,
    AccountsComponent,
    AddUserComponent,
    UserComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    ReactiveFormsModule,
    MaterialModule,
    BrowserAnimationsModule,
    FontAwesomeModule
  ],
  providers: [
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true }
  ],
  bootstrap: [AppComponent]
})

export class AppModule { }