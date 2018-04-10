<template>
    <div class="col-xs-12 start__card">

        <div class="row">
            <a href="#" class="btn btn-xs btn-primary pull-right"
                @click="openModal()">
                <i class="fa fa-plus"></i>
                Agregar
            </a>
        </div>

        <div class="col-xs-10 project" v-for="experience of experiences">
            <i class="fa fa-times text-danger delete-button" @click="deleteWork(experience.id)"></i>
            <a :href="experience.feature_url" v-text="experience.where"></a>
            <p class="small">
                <span class="strong">Desde:</span> {{ experience.from }}
                <span class="strong">hasta: </span> {{ experience.to }}
            </p>
            <p class="small"><span class="strong">Descripción:</span> {{ experience.desc }}</p>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="addWorkExperience">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Agregar experiencia laboral</h4>
                    </div>
                    <div class="modal-body">

                        <p class="text-warning">Todos los campos son obligatorios.</p>

                        <div v-if="error" class="alert alert-danger">
                            <p v-for="e in error" v-text="e"></p>
                        </div>

                        <form>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Nombre de la organización</label>
                                        <input type="text" class="form-control" v-model="new_experience.organization_name" placeholder="Dónde trabajaste?">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Página web de la organización</label>
                                        <input type="url" class="form-control" v-model="new_experience.organization_website" placeholder="Su website">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Título</label>
                                        <input type="text" class="form-control" v-model="new_experience.title" placeholder="Que hacías?">
                                    </div>
                                </div>
                                <!-- <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Tech used</label>
                                        <input type="text" class="form-control" v-model="new_experience.technologies_used" placeholder="What technology did you use?">
                                    </div>
                                </div> -->
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Fecha de inicio</label>
                                        <input type="date" class="form-control" v-model="new_experience.start_date">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Fecha de término</label>
                                        <input type="date" class="form-control" v-model="new_experience.end_date">
                                    </div>
                                </div>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input v-model="new_experience.current" type="checkbox" value="true">
                                    Aún estoy haciendolo!
                                </label>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Responsabilidades y Logros</label>
                                    <textarea class="form-control" placeholder="Dinos todo!" v-model="new_experience.responsibilities"></textarea>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="postExperience">Guardar</button>
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
                experiences: [],
                new_experience: {
                    organization_name: null,
                    organization_website: null,
                    title: null,
                    technologies_used: null,
                    responsibilities: null,
                    start_date: null,
                    end_date: null,
                    current: false,
                },
                error: null,
            }
        },
        methods: {
            getExperience() {
                axios.get('api/experience')
                    .then(res => {
                        this.experiences = res.data
                        console.log(this.experiences)
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            postExperience() {
                let data = {
                    organization_name: this.new_experience.organization_name,
                    organization_website: this.new_experience.organization_website,
                    title: this.new_experience.title,
                    technologies_used: this.new_experience.technologies_used,
                    responsibilities: this.new_experience.responsibilities,
                    start_date: this.new_experience.start_date,
                    end_date: this.new_experience.end_date,
                    current: this.new_experience.current,
                }
                axios.post('api/experience', data)
                    .then(res => {
                        this.getExperience()
                        this.new_experience = {}
                        $('#addWorkExperience').modal('hide')
                        this.resetData()
                    })
                    .catch(err => {
                        this.error = err.response.data
                    })
            },
            deleteWork(experience_id) {

                let data = {
                    _method: 'delete',
                }

                axios.post('api/experience/' + experience_id, data)
                    .then(res => {
                        this.getExperience()
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            openModal() {
                $('#addWorkExperience').modal('toggle')
            },
            resetData() {
                this.new_experience = {
                    organization_name: null,
                    organization_website: null,
                    title: null,
                    technologies_used: null,
                    responsibilities: null,
                    start_date: null,
                    end_date: null,
                    current: false,
                }
            }
        },
        mounted() {
            this.getExperience()
        }

    }
</script>