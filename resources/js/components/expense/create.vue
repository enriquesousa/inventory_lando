    <template>

        <div>

            <div class="row">
                <router-link to="/expense" class="btn btn-primary">Lista de Gastos</router-link>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card shadow-sm my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="login-form">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Añadir Gasto</h1>
                                        </div>

                                        <form class="user" @submit.prevent="expenseInsert">

                                            <div class="form-group">

                                                <div class="form-row">

                                                    <div class="col-md-12">
                                                        <label for="Textarea1"><b>Detalles del Gasto</b></label>
                                                        <textarea class="form-control" id="Textarea1" rows="3" v-model="form.details"></textarea>
                                                        <small class="text-danger" v-if="errors.details"> {{ errors.details[0] }} </small>
                                                    </div>

                                                    <div class="col-md-12"><br>
                                                        <label for="price_amount"><b>Cantidad del Gasto</b></label>
                                                        <input type="text" class="form-control" id="price_amount" placeholder="Entre la Cantidad" v-model="form.amount">
                                                        <small class="text-danger" v-if="errors.amount"> {{ errors.amount[0] }} </small>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block">Aplicar</button>
                                            </div>

                                        </form>
                                        <hr>

                                        <div class="text-center">
                                        </div>
                                        <div class="text-center">
                                        </div>

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

        created() {
            if (!User.loggedIn()) {
                this.$router.push({
                    name: '/'
                })
            }
        },

        data() {
            return {
                form: {
                    details: '',
                    amount: '',
                },
                errors: {},
            }
        },

        methods: {

            expenseInsert() {
                axios.post('/api/expense', this.form)
                    .then(() => {
                        this.$router.push({
                            name: 'expense'
                        })
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },
        }


    }
    </script>


    <style type="text/css">

    </style>