import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { FormGroup, FormControl } from '@angular/forms';
import {MatSnackBar} from '@angular/material/snack-bar';
import {AuthenticationService} from 'src/app/services/authentication.service';
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  formLogin: FormGroup;
  returnUrl: string;

  constructor(private _snackBar: MatSnackBar, private request: AuthenticationService, private route: ActivatedRoute, private router: Router) {
    if (this.request.currentUserValue) {
      this.router.navigate(['/']);
    }
  }

  ngOnInit(): void {
    this.formLogin = new FormGroup({
      email: new FormControl(),
      password: new FormControl()
    });
    this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
  }

  onSubmit() {
    let loginData = {
      username: this.formLogin.value.email,
      password: this.formLogin.value.password
    }
    if (loginData.username == null || loginData.username == "") {
      this.openSnackBar("Veillez renseigner votre adresse email", "reessayer")
    }
    else {
      if (this.validateEmail(loginData.username)) {
        if (loginData.password == null || loginData.password == "") {
          this.openSnackBar("Veillez renseigner votre mot de passe", "reessayer")
        }
        else {
          this.request.login(loginData).subscribe(
            (response) => {
              console.log(response)
              this.router.navigate([this.returnUrl]);
            },
            (error) => {
              if (error.error.code) {
                this.openSnackBar(error.error.message, error.error.code)
              }
              else {
                this.openSnackBar(error.message, "ok")
              }
              console.log(error)
            }
          )
        }
      }
      else {
        this.openSnackBar("Adresse email incorrect", "reessayer")
      }
    }
  }
  
  openSnackBar(message: string, action: string) {
    this._snackBar.open(message, action, {
      duration: 2000,
    });
  }

  validateEmail(email) {
    const regularExpression = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regularExpression.test(String(email).toLowerCase());
  }   
}