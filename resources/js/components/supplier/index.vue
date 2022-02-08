<template>
<div>

    <div class="row py-1">
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand">
                    <router-link to="/store-supplier" class="btn btn-primary">Añadir Proveedor</router-link>
                </a>
                <form class="d-flex">
                    <input type="text" v-model="searchTerm" class="form-control mb-0" style="width: 300px;" aria-label="Search" placeholder="Buscar aquí">
                    <button class="btn btn-outline-success" type="submit">Reset</button>
                </form>
            </div>
        </nav>
    </div>

    <!-- Begin Row Simple Table -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de Proveedores</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Foto</th>
                                <th>Teléfono</th>
                                <th>Empresa Nombre</th>
                                <th>Correo Electrónico</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="supplier in filtersearch" :key="supplier.id">
                                <td>{{ supplier.name }}</td>
                                <td> <img :src="supplier.photo" id="em_photo"></td>
                                <td>{{ supplier.phone }}</td>
                                <td>{{ supplier.shopname }}</td>
                                <td>{{ supplier.email }}</td>
                                <td>
                                    <router-link :to="{name: 'edit-supplier', params:{id:supplier.id}}" class="btn btn-sm btn-primary">Editar</router-link>
                                    <a @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger"><font color="#ffffff">Eliminar</font></a>
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
        suppliers:[],
        searchTerm:'',
    }
},

computed:{
    filtersearch(){
        return this.suppliers.filter(supplier => {
            return supplier.name.match(this.searchTerm)
        })
    }
},

methods:{
    
    allSupplier(){
        axios.get('/api/supplier/')
        .then(({data}) => (this.suppliers = data))
        .catch()
    },

    deleteSupplier(id){
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
                axios.delete('/api/supplier/'+id)
                .then(() => {
                    this.suppliers = this.suppliers.filter(supplier => {
                        return supplier.id != id
                    })
                })
                .catch(() => {
                    this.$router.push({name: 'supplier'})
                })
                location.reload()
                Swal.fire(
                'Eliminado!',
                'El archivo ha sido eliminado.',
                'success'
                )
            }
        })
    },

},

created(){
    this.allSupplier();
}

}
</script>

<style type="text/css">
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>
