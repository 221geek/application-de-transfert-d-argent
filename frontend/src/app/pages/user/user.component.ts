import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { RequestService } from 'src/app/services/request.service';
import { filter } from 'rxjs/operators';
import { MatSnackBar } from '@angular/material/snack-bar';
import { User } from 'src/app/models/user';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.scss']
})
export class UserComponent implements OnInit {

  id: number;
  showProfil: boolean = false;
  user: User;
  btnSwitch: boolean;

  constructor(private request: RequestService, private _snackBar: MatSnackBar, private route: ActivatedRoute, private router: Router ) { }

  ngOnInit(): void {
    this.route.paramMap.subscribe(
      (url: any) => {
        this.id = url.params.id
        this.showProfil = true
        this.request.getUser(this.id).subscribe(
          (user: any) => {
            this.user = user
          },
          (error) => {
            this.openSnackBar(error, "ok")
            setTimeout(() => {
              this.router.navigate(['/users'])
            }, 2500)
          }
        )
      }
    )
  }

  blockUser() {
    this.user.isActive = !this.user.isActive
    this.request.editUser(this.user, this.id).subscribe(
      (response) => {
        console.log(response)
        if (response.isActive) {
          this.openSnackBar("Utilisateur débloqué", "ok")
        }
        else {
          this.openSnackBar("Utilisateur bloqué", "ok")
        }
      },
      (error) => {
        console.log(error)
      }
    )
  }

  deleteUser() {
    this.request.deleteUser(this.id).subscribe(
      (response) => {
        this.openSnackBar("Utilisateur supprimé", "ok")
        setTimeout(() => {
          this.router.navigate(['/users'])
        }, 2500)
      },
      (error) => {
        console.log(error)
        this.openSnackBar(error, "ok")
      }
    )
  }

  openSnackBar(message: string, action: string) {
    this._snackBar.open(message, action, {
      duration: 2000,
    });
  }
}