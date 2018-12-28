import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable, of } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';

import { Category } from './category';


const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})
export class CategoryService {

  private apiUrl = 'http://localhost:8080';

  constructor(private http: HttpClient, ) {
  }

  private handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.error(error);

      return of(result as T);
    };
  }

  getCategories (): Observable<Category[]> {
    return this.http.get<Category[]>(this.apiUrl)
      .pipe(
        catchError(this.handleError('getCategories', []))
      );
  }

  addCategory (category: Category): Observable<Category> {
    return this.http.post<Category>(this.apiUrl, category, httpOptions)
      .pipe(
        catchError(this.handleError<Category>('addCategory'))
    );
  }

  deleteCategory (category: Category | number): Observable<Category> {
    const id = typeof category === 'number' ? category : category.id;
    const url = `${this.apiUrl}/${id}`;

    return this.http.delete<Category>(url, httpOptions).pipe(
      catchError(this.handleError<Category>('deleteCategory'))
    );
  }

  updateCategory (category: Category, name: string): Observable<any> {
    const id = typeof category === 'number' ? category : category.id;
    const url = `${this.apiUrl}/${id}`;

    category.name = name;

    return this.http.put(url, category, httpOptions).pipe(
      catchError(this.handleError<any>('updateCategory'))
    );
  }
}
