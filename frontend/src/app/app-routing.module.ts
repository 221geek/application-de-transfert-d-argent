import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './pages/login/login.component';
import { HomeComponent } from './pages/home/home.component';
import { UsersComponent } from './pages/users/users.component';
import { AuthGuard } from './helpers/authentication.guard';
import { TransfertComponent } from './pages/transfert/transfert.component';
import { AccountsComponent } from './pages/accounts/accounts.component';
import { AddAccountComponent } from './pages/add-account/add-account.component';
import { AddUserComponent } from './pages/add-user/add-user.component';
import { UserComponent } from './pages/user/user.component';

const routes: Routes = [
  {path: 'login', component: LoginComponent},
  {path: '', component: HomeComponent, canActivate: [AuthGuard]},
  {path: 'users', component: UsersComponent, canActivate: [AuthGuard]},
  {path: 'users/add', component: AddUserComponent, canActivate: [AuthGuard]},
  {path: 'users/:id', component: UserComponent, canActivate: [AuthGuard]},
  {path: 'transfer', component: TransfertComponent, canActivate: [AuthGuard]},
  {path: 'accounts', component: AccountsComponent, canActivate: [AuthGuard]},
  {path: 'accounts/add', component: AddAccountComponent, canActivate: [AuthGuard]}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})

export class AppRoutingModule { }