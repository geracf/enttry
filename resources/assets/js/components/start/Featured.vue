<template>
    <div class="col-xs-12 start__card">

        <div class="row">
            <a href="#" class="btn btn-xs btn-primary pull-right"
                @click="openModal()">
                <i class="fa fa-plus"></i>
                Agregar
            </a>

            <div class="col-xs-10 project" v-for="work of works">
                <i class="fa fa-times text-danger delete-button" @click="deleteWork(work.id)"></i>
                <a :href="work.feature_url" v-text="work.feature_name"></a>
                <p class="small"><span class="strong">Fecha de realización:</span> {{ work.release_date }}</p>
                <p class="small"><span class="strong">Descripción:</span> {{ work.desc }}</p>
            </div>
        </div>


        <div class="modal fade" tabindex="-1" role="dialog" id="addFeaturedWork">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Agregar actividad extracurricular</h4>
                    </div>
                    <div class="modal-body">

                        <div v-if="error" class="alert alert-danger">
                            <p v-for="e in error" v-text="e"></p>
                        </div>

                        <form>

                            <div class="form-group">
                                <label>Nombre de la actividad</label>
                                <input class="form-control" type="text" v-model="new_work.name" placeholder="Que hacías?">
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>URL relevante (opcional)</label>
                                        <input class="form-control" type="url" v-model="new_work.url" placeholder="http://mi-actividad.com">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Fecha de realización</label>
                                        <input class="form-control" type="date" v-model="new_work.release_date" placeholder="Fecha de realización (última)">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Describe lo que hacías</label>
                                <textarea class="form-control" v-model="new_work.desc" placeholder="Describe lo que hacías"></textarea>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="postFeatured">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                works: [],
                new_work: {
                    name: null,
                    url: null,
                    technologies_used: null,
                    desc: null,
                    release_date: null,
                },
                error: null,
            }
        },
        mounted () {
            this.getFeatured()
        },
        methods: {
            getFeatured() {
                axios.get('api/featured')
                    .then(res => {
                        this.works = res.data
                    })
                    .catch(err => {
                        console.log()
                    })
            },
            postFeatured() {
                let data = {
                    feature_name: this.new_work.name,
                    feature_url: this.new_work.url,
                    technologies_used: this.new_work.technologies_used,
                    desc: this.new_work.desc,
                    release_date: this.new_work.release_date,
                }
                axios.post('api/featured', data)
                    .then(res => {
                        this.getFeatured()
                        this.restartModal()
                        $('#addFeaturedWork').modal('hide')
                        // Event.$emit('alert-created', {
                        //     type: 'alert-success',
                        //     title: 'Education added!',
                        //     body: 'Keep going!',
                        //     actions: []
                        // })
                    })
                    .catch(err => {
                        this.error = err.response.data
                    })
            },
            openModal() {
                $('#addFeaturedWork').modal('show')
            },
            deleteWork(featured_id) {

                let data = {
                    _method: 'delete',
                }

                axios.post('api/featured/' + featured_id, data)
                    .then(res => {
                        this.getFeatured()
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            restartModal() {
                this.new_work =  {
                    name: null,
                    url: null,
                    technologies_used: null,
                    desc: null,
                    release_date: null,
                }
            }
        }

    }
</script>