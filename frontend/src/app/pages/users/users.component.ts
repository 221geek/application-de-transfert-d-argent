import { Component, OnInit, ViewChild } from '@angular/core';
import { RequestService } from 'src/app/services/request.service';
import { User } from 'src/app/models/user';
import { faUser, faUserPlus } from '@fortawesome/free-solid-svg-icons';
import { MatTableDataSource } from '@angular/material/table';
import { MatPaginator } from '@angular/material/paginator';
import {MatSort} from '@angular/material/sort';

@Component({
  selector: 'app-users',
  templateUrl: './users.component.html',
  styleUrls: ['./users.component.scss']
})
export class UsersComponent implements OnInit {

  faUser = faUser;
  faUserPlus = faUserPlus;
  users: Array<any>;
  ELEMENT_DATA: PeriodicElement[] = []
  displayedColumns: string[] = ['id', 'firstname', 'lastname', 'email', 'phone', 'roles'];
  dataSource = new MatTableDataSource<PeriodicElement>(this.ELEMENT_DATA);
  @ViewChild(MatPaginator, {static: true}) paginator: MatPaginator;
  @ViewChild(MatSort, {static: true}) sort: MatSort;

  constructor(private request: RequestService) { }

  ngOnInit(): void {
    this.request.getUsers().subscribe(
      (response) => {
        this.users = response['hydra:member']
        this.ELEMENT_DATA.splice(0, this.ELEMENT_DATA.length)
        for (const iterator of this.users) {
          this.ELEMENT_DATA.push({id: iterator.id, firstname: iterator.firstname, lastname: iterator.lastname, email: iterator.email, phone: iterator.phone, roles: iterator.roles[0].replace("ROLE_", "")})
        }
        this.dataSource.paginator = this.paginator;
        this.dataSource.sort = this.sort;
      },
      (error) => {
        console.log(error)
      }
    )
  }

  applyFilter(filterValue: string) {
    this.dataSource.filter = filterValue.trim().toLowerCase();
    console.log(this.dataSource.filter);
    if (this.dataSource.paginator) {
      this.dataSource.paginator.firstPage();
    }
  }
}

export interface PeriodicElement {
  id: number;
  firstname: string;
  lastname: string;
  email: string;
  phone: number
  roles: string;
}