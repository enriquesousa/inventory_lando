<template>
<div>

    <div>
        <router-link to="/store-product" class="btn btn-primary">Añadir Producto</router-link>
    </div>
    <br>
    <div align="right">
        <input type="text" v-model="searchTerm" class="form-control mb-2" style="width: 300px;" placeholder="Buscar aquí">
    </div>

    <!-- Begin Row Simple Table -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de Productos</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Foto</th>
                                <th>Categoría</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Root</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="product in filtersearch" :key="product.id">
                                <td>{{ product.product_name }}</td>
                                <td>{{ product.product_code }}</td>
                                <td> <img :src="product.image" id="em_photo"></td>
                                <td>{{ product.category_name }}</td>
                                <td>{{ product.buying_price }}</td>
                                <td>{{ product.selling_price }}</td>
                                <td>{{ product.root }}</td>
                                <td>
                                    <router-link :to="{name: 'edit-product', params:{id:product.id}}" class="btn btn-sm btn-primary">Editar</router-link>
                                    <a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger"><font color="#ffffff">Eliminar</font></a>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
    <!-- End Row Simple Table -->

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
    return{
        products:[],
        searchTerm:'',
    }
},

computed:{
    filtersearch(){
        return this.products.filter(product => {
            return product.product_name.match(this.searchTerm)
        })
    }
},

methods:{
    
    allProduct(){
        axios.get('/api/product')
        .then(({data}) => (this.products = data))
        .catch()
    },

    deleteProduct(id){
        Swal.fire({
        title: 'Estas Seguro?',
        text: "No podrás revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('/api/product/'+id)
                .then(() => {
                    this.products = this.products.filter(product => {
                        return product.id != id
                    })
                })
                .catch(() => {
                    this.$router.push({name: 'product'})
                })
                location.reload()
                Swal.fire(
                'Eliminado!',
                'El archivo fue eliminado.',
                'success'
                )
            }
        })
    },

},

created(){
    this.allProduct();
}

}
</script>

<style type="text/css">
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>
