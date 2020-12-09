import { Component, OnInit } from '@angular/core';
import { RequestService } from 'src/app/services/request.service';
import { Role } from 'src/app/models/role';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { User } from 'src/app/models/user';
import { MatSnackBar } from '@angular/material/snack-bar';
import { faCheckCircle } from '@fortawesome/free-solid-svg-icons';

@Component({
  selector: 'app-add-user',
  templateUrl: './add-user.component.html',
  styleUrls: ['./add-user.component.scss']
})

export class AddUserComponent implements OnInit {

  roles: Array<Role>;
  newUserForm: FormGroup;
  faCheckCircle = faCheckCircle;
  showMatCard: boolean = false;
  idNewUser: number;

  constructor(private request: RequestService, private _snackBar: MatSnackBar) { }

  ngOnInit(): void {

    this.newUserForm = new FormGroup({
      lastname: new FormControl('', [Validators.required]),
      firstname: new FormControl('', [Validators.required]),
      email: new FormControl('', [Validators.required]),
      phone: new FormControl(''),
      role: new FormControl('', [Validators.required]),
      password: new FormControl('', [Validators.required])
    })

    this.request.getRoles().subscribe(
      (response) => {
        this.roles = response['hydra:member']
      },
      (error) => {
        console.log(error)
      }
    )
  }

  addUser() {
    let user: User = {
      firstname: this.newUserForm.value.firstname,
      lastname: this.newUserForm.value.lastname,
      email: this.newUserForm.value.email,
      password: this.newUserForm.value.password,
      phone: (this.newUserForm.value.phone).toString(),
      role: "/api/roles/"+this.newUserForm.value.role
    }

    console.log(user)
    if (this.validateEmail(user.email)) {
      this.request.addUser(user).subscribe(
        (response: any) => {
          console.log(response)
          this.showMatCard = true
          this.idNewUser = response.id
        },
        (error) => {
          this.openSnackBar(error, "ok")
        }
      )
    }
    else {
      this.openSnackBar("Adresse email invalide", "réessayer")
    }
  }

  validateEmail(email: string) {
    const regularExpression = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regularExpression.test(String(email).toLowerCase());
  }

  openSnackBar(message: string, action: string) {
    this._snackBar.open(message, action, {
      duration: 2000,
    });
  }
}