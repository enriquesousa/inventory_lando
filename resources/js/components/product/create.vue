<template>
<div>
    <div>
        <router-link to="/product" class="btn btn-primary">Lista Productos</router-link>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="login-form">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Añadir Producto</h1>
                                </div>

                                <form class="user" @submit.prevent="employeeInsert" enctype="multipart/form-data">

                                    <!-- Nombre y Código -->
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label for="pname">Nombre</label>
                                                <input type="text" class="form-control" id="pname" placeholder="Entre Nombre Producto" v-model="form.product_name">
                                                <small class="text-danger" v-if="errors.product_name"> {{ errors.product_name[0] }} </small>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="pcodigo">Código</label>
                                                <input type="text" class="form-control" id="pcodigo" placeholder="Entre Código Producto" v-model="form.product_code">
                                                <small class="text-danger" v-if="errors.product_code"> {{ errors.product_code[0] }} </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Seleccionar: Categorías y Proveedores -->
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label for="exampleFormControlSelect1">Categoría</label>
                                                <select class="form-control" id="exampleFormControlSelect1">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="exampleFormControlSelect1">Proveedor</label>
                                                <select class="form-control" id="exampleFormControlSelect1">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Root, Precio de Compra y Precio de Venta -->
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label for="proot">Root</label>
                                                <input type="text" class="form-control" id="proot" placeholder="" v-model="form.root">
                                                <small class="text-danger" v-if="errors.root"> {{ errors.root[0] }} </small>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pcompra">Precio de Compra</label>
                                                <input type="text" class="form-control" id="pcompra" placeholder="" v-model="form.buying_price">
                                                <small class="text-danger" v-if="errors.buying_price"> {{ errors.buying_price[0] }} </small>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pventa">Precio de Venta</label>
                                                <input type="text" class="form-control" id="pventa" placeholder="" v-model="form.selling_price">
                                                <small class="text-danger" v-if="errors.selling_price"> {{ errors.selling_price[0] }} </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fecha de Compra y Cantidad Producto -->
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label for="fcompra">Fecha de Compra</label>
                                                <input type="date" class="form-control" id="fcompra" placeholder="" v-model="form.buying_date">
                                                <small class="text-danger" v-if="errors.buying_date"> {{ errors.buying_date[0] }} </small>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="pcantidad">Cantidad Producto</label>
                                                <input type="text" class="form-control" id="pcantidad" placeholder="Entre Cantidad" v-model="form.product_quantity">
                                                <small class="text-danger" v-if="errors.product_quantity"> {{ errors.product_quantity[0] }} </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Imagen del Producto -->
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                                <small class="text-danger" v-if="errors.image"> {{ errors.image[0] }} </small>
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            <div class="col-md-6">
                                                <img :src="form.image" style="height: 40px; width: 40px;">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Añadir</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script type="text/javascript">
  export default {
    created(){
      if (!User.loggedIn()){
        this.$router.push({ name: 'home'})
      }
    },

    data(){
      return {
        form:{
          name: null,
          email: null,
          phone: null,
          salary: null,
          address: null,
          photo: null,
          nid: null,
          joining_date: null,
        },
        errors:{

        }
      }
    },

    methods:{
        onFileSelected(event){
            let file = event.target.files[0];
            if (file.size > 1048770){
                Notification.image_validation();
            }else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.photo = event.target.result;
                    console.log(event.target.result);
                }
                reader.readAsDataURL(file);
            }
        },     
        employeeInsert(){
            axios.post('/api/employee',this.form)
            .then(() => {
                this.$router.push({ name: 'employee'})
                Notification.success()
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    }
    
  }
</script>

<style>

</style>
