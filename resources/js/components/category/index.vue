<template>
<div>

    <div>
        <router-link to="/store-category" class="btn btn-primary">Añadir Categoría</router-link>
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
                    <h6 class="m-0 font-weight-bold text-primary">Lista de Categorías</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Nombre Categoría</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in filtersearch" :key="category.id">
                                <td>{{ category.category_name }}</td>
                                <td>
                                    <router-link :to="{name: 'edit-category', params:{id:category.id}}" class="btn btn-sm btn-primary">Editar</router-link>
                                    <a @click="deleteCategory(category.id)" class="btn btn-sm btn-danger"><font color="#ffffff">Eliminar</font></a>
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
        categories:[],
        searchTerm:'',
    }
},

computed:{
    filtersearch(){
        return this.categories.filter(category => {
            return category.category_name.match(this.searchTerm)
        })
    }
},

methods:{
    
    allCategory(){
        axios.get('/api/category/')
        .then(({data}) => (this.categories = data))
        .catch()
    },

    deleteCategory(id){
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
                axios.delete('/api/category/'+id)
                .then(() => {
                    this.categories = this.categories.filter(category => {
                        return category.id != id
                    })
                })
                .catch(() => {
                    this.$router.push({name: 'category'})
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
    this.allCategory();
}

}
</script>

<style type="text/css">
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>
