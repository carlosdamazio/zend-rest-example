import { Component, OnInit } from '@angular/core';

import {NgbModal, ModalDismissReasons} from '@ng-bootstrap/ng-bootstrap';

import { Category } from './category';
import { CategoryService } from './category.service';


@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.scss']
})
export class CategoryComponent implements OnInit {
  categories: Category[];
  selCategory: Category;

  constructor(
    private service: CategoryService,
    private modalService: NgbModal,
  ) { }

  ngOnInit() {
    this.getCategories();
  }

  getCategories(): void {
    this.service.getCategories()
    .subscribe(categories => this.categories = categories);
  }

  addCat(name: string): void {
    name = name.trim();

    if (!name) { return; }

    this.service.addCategory({ name } as Category)
      .subscribe(() => this.getCategories());
  }

  delCat(category: Category): void {
    this.categories = this.categories.filter(c => c !== category);
    this.service.deleteCategory(category).subscribe();
  }

  selCat(category: Category): void {
    this.selCategory = category;
  }

  upCat(name: string): void {
    this.service.updateCategory(this.selCategory, name)
      .subscribe();
  }

  open(content, category) {
    this.modalService.open(content, {ariaLabelledBy: 'modal-basic-title'});
  }
}
