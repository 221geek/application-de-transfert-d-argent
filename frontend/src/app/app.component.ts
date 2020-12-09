import { Component } from '@angular/core';
import { AuthenticationService } from 'src/app/services/authentication.service';
import { Menu } from 'src/app/models/menu';
import { faWallet, faUsers, faSync, faTachometerAlt, faHandHoldingUsd } from '@fortawesome/free-solid-svg-icons';
import { ActivatedRoute, Router, NavigationEnd } from '@angular/router';
import { filter } from 'rxjs/operators';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

  toggle: boolean = true;
  menu: Array<Menu> = [];
  roleUser: string;
  loginPage: boolean = false;

  constructor(private request: AuthenticationService, private route: ActivatedRoute, private router: Router) {}

  ngOnInit(): void {
    this.router.events.pipe(filter(event => event instanceof NavigationEnd)).subscribe((event: any) => {
      if (event.url.startsWith("/login")) {
        this.loginPage = true;
      }
      else {
        this.loginPage = false;
        this.roleUser = this.request.getCurrentUser().roles[0]
    
        if (this.roleUser == "ROLE_SUPER_ADMIN") {
          this.menu = []
          this.menu.push(
            {icon: faTachometerAlt, wording: "Tableau de bord", route: "", routerLinkActiveOptions: true},
            {icon: faSync, wording: "Transfert d'argent", route: "transfer"},
            {icon: faSync, wording: "Transactions", route: "transactions"},
            {icon: faWallet, wording: "Compte", route: "accounts"},
            {icon: faHandHoldingUsd, wording: "Depot", route: "deposit"},
            {icon: faUsers, wording: "Utilisateurs", route: "users"}
          )
        }
      }
    })

  }
}
