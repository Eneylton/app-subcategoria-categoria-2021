import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { ServiceProvider } from '../../providers/service/service';


@IonicPage({})
@Component({
  selector: 'page-home',
  templateUrl: 'home.html',
})
export class HomePage {

  categorias: any = [];

  constructor(public navCtrl: NavController, public navParams: NavParams,  private serve: ServiceProvider) {
  }

  ionViewDidLoad() {
    this.categorias = [];
    this.listarCategorias();
  }

  listarCategorias() {

    return new Promise(resolve => {
      let body = {
        
        crud: 'Listar-Categorias'
      };

      this.serve.postData(body, 'categoria.php').subscribe((data:any)=> {
       
        for (let i = 0; i < data.result.length; i++) {
  
          this.categorias.push({
                id:                    data.result[i]["id"],
                nome:                  data.result[i]["nome"],
                subcategoria:          data.result[i]["subcategoria"]
  
              
          });

          console.log("BANCO: ", this.categorias);
  
        }
  
        })
    
        resolve(true);
  
      });
  
  }
  

}
