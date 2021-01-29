import { Component } from '@angular/core';
import { ActionSheetController, AlertController, IonicPage, NavController, NavParams, ToastController } from 'ionic-angular';
import { Camera, CameraOptions   } from '@ionic-native/camera';
import { ServiceProvider } from '../../providers/service/service';

@IonicPage({})
@Component({
  selector: 'page-fornecedor-cadastro',
  templateUrl: 'fornecedor-cadastro.html',
})

export class FornecedorCadastroPage {

  log:               any;

  nome:              string = "";
  fone:              string = "";
  email:             string = "";
  foto:              string = "";
  base64Image:       string = "";
  cameraData:        string = "";

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private serve: ServiceProvider,
    private camera: Camera,
    public actionSheetCtrl: ActionSheetController,
    public toastyCrtl: ToastController,
    public alertCtrl: AlertController) {

      
  }

  presentActionSheet() {
    const actionSheet = this.actionSheetCtrl.create({
      title: 'Abrir Midia',
      buttons: [
        {
          text: 'Camera',
          icon: 'camera',
          handler: () => {
            this.abrirCamrera();
          }
        }, {
          text: 'Galeria',
          icon: 'image',
          handler: () => {
            this.abrirGaleria();
          }
  
        }
      ]
    });
  
    actionSheet.present();
  }
  
  
  abrirCamrera() {
  
    const options: CameraOptions = {
      quality: 100,
      targetWidth:650,
      targetHeight:650,
      destinationType: this.camera.DestinationType.DATA_URL,
      encodingType: this.camera.EncodingType.JPEG,
      mediaType: this.camera.MediaType.PICTURE,
      allowEdit:true
    }
  
    this.camera.getPicture(options).then((imageData) => {
  
      this.cameraData = imageData;
      this.base64Image = 'data:image/jpeg;base64,' + imageData;
    }, (err) => {
  
      console.log(err);
  
    });
  
  }
  
  
  abrirGaleria() {
  
    const options: CameraOptions = {
      quality: 100,
      targetWidth:650,
      targetHeight:650,
      sourceType: this.camera.PictureSourceType.PHOTOLIBRARY,
      destinationType: this.camera.DestinationType.DATA_URL,
      encodingType: this.camera.EncodingType.JPEG,
      mediaType: this.camera.MediaType.PICTURE,
      allowEdit:true
    }
  
    this.camera.getPicture(options).then((imageData) => {
      this.cameraData = imageData;
      this.base64Image = 'data:image/jpeg;base64,' + imageData;
    }, (err) => {
  
    });
  
  }


  cadastrar() {

    if(this.nome ==""){
      
      const toast = this.toastyCrtl.create({
      message: 'O campo nome é Obrigatório',  
      duration:3000
      });
      toast.present();
  
  }

  let body = {
    
    nome:        this.nome,
    email:       this.email,
    fone:        this.fone,
    foto:        this.cameraData,
    crud: 'adicionar'
  };

  this.serve.postData(body, 'fornecedor.php').subscribe(data => {

    this.showInsertOk();
  });

  }

  showInsertOk() {
    let alert = this.alertCtrl.create({
      title: 'Sucesso!',
      message: 'Seu Cadastro efetuado com sucesso',
      enableBackdropDismiss: false,
      buttons: [
        {
          text: 'Ok',
          handler: () => {
            
            this.navCtrl.setRoot('FornecedorListPage');
          }
        }
      ]
    });
    alert.present();
  }

}
